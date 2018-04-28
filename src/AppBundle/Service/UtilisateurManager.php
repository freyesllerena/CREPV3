<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Utilisateur;
use AppBundle\Repository\UtilisateurRepository;
use FOS\UserBundle\Model\UserManager;
use AppBundle\Entity\Agent;
use AppBundle\Entity\Personne;
use AppBundle\Entity\UtilisateurTmp;

class UtilisateurManager
{
    /* @var $em EntityManager */
    protected $em;

    /* @var $repository UtilisateurRepository */
    protected $repository;

    protected $tokenGenerator;

    protected $fos_user_manager;

    protected $defaultPassword;

    protected $mailer;

    public function __construct(EntityManager $em, $tokenGenerator, UserManager $fos_user_manager, $defaultPassword, AppMailer $mailer)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository('AppBundle:Utilisateur');
        $this->tokenGenerator = $tokenGenerator;
        $this->fos_user_manager = $fos_user_manager;
        $this->defaultPassword = $defaultPassword;
        $this->mailer = $mailer;
    }

    /**
     * Permet de créer un utilisateur avec un mot de passe par defaut.
     *
     * @param Utilisateur $utilisateur
     */
    public function creer(Utilisateur $utilisateur, $enable = true)
    {
        $utilisateur->setUsername($utilisateur->getEmail())
        //->setEnabled($enable)
        ->setNbConnexionKO(0);

        //pour la dev
        if ($this->defaultPassword) {
            $utilisateur->setPlainPassword($this->defaultPassword);
            $utilisateur->setEnabled(true);
        }

        $this->em->persist($utilisateur);
        $this->em->flush();
    }

    public function getUtilisateurs()
    {
        return $this->repository->findAll(array(), array('email' => 'desc'));
    }

    public function supprimerRole($role, Utilisateur $utilisateur)
    {
        $roles = $utilisateur->getRoles();

        // Si l'utilisateur dispose d'un seul ROLE (en plus de ROLE_USER), on le désactive
        if (count($roles) <= 2) {
            $utilisateur->setEnabled(false);
        }

        // On lui supprime le ROLE
        $utilisateur = $utilisateur->removeRole($role);

        $this->fos_user_manager->updateUser($utilisateur);
    }

    /*
     * Met à jour les données de l'utilisateur à partir des données de l'agent
     */
    public function updateFromAgent(Utilisateur $utilisateur, Agent $agent)
    {
        // Mettre à jour les données utilisateur
        $utilisateur->setCivilite($agent->getCivilite())
                    ->setNom($agent->getNom())
                    ->setPrenom($agent->getPrenom());

        // En cas de mise à jour de l'email
        if ($utilisateur->getEmail() != $agent->getEmail()) {
            /* @var $utilisateurExistant Utilisateur */
            $utilisateurExistant = $this->repository->findOneByEmail($agent->getEmail());

            if ($utilisateurExistant) {
                // On ajoute le role ROLE_AGENT à l'utilisateur existant
                // Si l'utilisateur dispose déjà du ROLE_AGENT cette ligne ne fera rien
                $utilisateurExistant->addRole('ROLE_AGENT');

                $agent->setUtilisateur($utilisateurExistant);

                // On retire le role AGENT du nouvel utilisateur
                $utilisateur->removeRole('ROLE_AGENT');
            } else {
                $utilisateur->setEmail($agent->getEmail());

                // Générer un nouveau token pour l'utilisateur
                $token = $this->tokenGenerator->generateToken();
                $utilisateur->setConfirmationToken($token);

                // On set le password à null dans le cas d'un environnement local (si le paramètre defaultPassword != de null)
                if (!$this->defaultPassword) {
                    $utilisateur->setPlainPassword($this->defaultPassword);
                } else { // On set le mot de passe à null sur les autres environnements
                    $utilisateur->setPlainPassword(null);
                    $utilisateur->setPassword(null);
                }

                // Renvoyer le mail de confirmation de création de compte
                $this->mailer->sendConfirmationEmailMessage($utilisateur);
            }
        }

        $this->em->flush();
    }

    private function creerFromAgent(Agent $agent, $role, $flush = true)
    {
        $ministere = $agent->getCampagnePnc()->getMinistere();

        /* @var $utilisateur Utilisateur */
        $utilisateur = $this->em->getRepository('AppBundle:Utilisateur')->findOneByEmail($agent->getEmail());

        if (!$utilisateur) {
            // génére token
            $token = $this->tokenGenerator->generateToken();
            $nouvelUtilisateur = new Utilisateur();
            $nouvelUtilisateur
            ->setCivilite($agent->getCivilite())
            ->setPrenom($agent->getPrenom())
            ->setNom($agent->getNom())
            ->setEmail($agent->getEmail())
            ->setRoles(array($role))
            ->setMinistere($ministere)
            ->setEnabled(true);

            if ($this->defaultPassword) {
                $nouvelUtilisateur->setPlainPassword($this->defaultPassword);
            }

            $agent->setUtilisateur($nouvelUtilisateur);

            $this->em->persist($nouvelUtilisateur);
            // 			$this->em->persist($agent);

            if (null === $nouvelUtilisateur->getConfirmationToken()) {
                $nouvelUtilisateur->setConfirmationToken($token);
            }

            $this->mailer->sendConfirmationEmailMessage($nouvelUtilisateur);
        } else {
            // si l'entité "Utilisateur" n'est pas en relation avec l'entité "Personne"
            $agent->setUtilisateur($utilisateur);

            // si l'utilisateur est actif et n'a pas le rôle, il faut lui ajouter le rôle
            if ($utilisateur->isEnabled() && !$utilisateur->hasRole($role)) {
                $utilisateur->addRole($role);
            }

            // si l'utilisateur est inactif, il faut lui supprimer tous ses anciens rôles
            // et lui ajouter le nouveau rôle
            if (!$utilisateur->isEnabled()) {
                $utilisateur->setRoles(array($role));
                $utilisateur->setEnabled(true);
            }
        }

        if ($flush) {
            $this->em->flush();
        }
    }

    public function creerFromAgents($nbAgents)
    {
        //Début de la transaction
        $this->em->getConnection()->beginTransaction();

        try {
            // Récupère un lot d'utilisateurs à créer
            $utilisateursTmp = $this->em->getRepository('AppBundle:UtilisateurTmp')->getUtilisateursPourCreation($nbAgents);

            /* @var $utilisateurTmp UtilisateurTmp */
            foreach ($utilisateursTmp as $utilisateurTmp) {
                $utilisateurTmp->setLocked(true);
            }
            $this->em->flush();

            $this->em->getConnection()->commit();

            // Annuler la transaction si le commit ne peut pas se faire
        // Dans le cas où deux processus travaillent sur le même lot
        } catch (\Doctrine\ORM\PessimisticLockException $exception) {
            $this->em->getConnection()->rollback();
        }

        /* @var $utilisateurTmp UtilisateurTmp */
        foreach ($utilisateursTmp as $utilisateurTmp) {
            $this->creerFromAgent($utilisateurTmp->getAgent(), $utilisateurTmp->getRole());
            $this->em->remove($utilisateurTmp);
        }
        $this->em->flush();
    }
}
