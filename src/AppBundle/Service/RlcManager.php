<?php

namespace AppBundle\Service;

use AppBundle\Entity\Ministere;
use AppBundle\Entity\Utilisateur;
use FOS\UserBundle\Model\UserManagerInterface;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Rlc;
use AppBundle\Entity\CampagneRlc;
use AppBundle\Repository\CampagneRlcRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class RlcManager
{
    protected $utilisateurManager;

    protected $fos_user_manager;

    protected $personneManager;

    protected $tokenStorage;

    protected $session;

    protected $em;

    public function __construct(
            UtilisateurManager $utilisateurManager,
            UserManagerInterface $fos_user_manager,
            PersonneManager $personneManager,
            TokenStorageInterface $tokenStorage,
    		EntityManagerInterface $entityManager,
            SessionInterface $session
            )
    {
        $this->utilisateurManager = $utilisateurManager;
        $this->fos_user_manager = $fos_user_manager;
        $this->personneManager = $personneManager;
        $this->tokenStorage = $tokenStorage;
        $this->session = $session;
        $this->em = $entityManager;
    }

    /**
     * Ajoute le rlc dans la table Rlc, et créer l'utilisateur associé si besoin.
     *
     * @param Rlc $rlc
     */
    public function creerRlc(Rlc $rlc)
    {
        /* @var $campagneRlcRepository CampagneRlcRepository */
        $campagneRlcRepository = $this->em->getRepository('AppBundle:CampagneRlc');
        $campagnesRlc = $campagneRlcRepository->getCampagnes($rlc);

        if ($campagnesRlc) {
            $this->personneManager->ajoutePersonnesDansUtilisateurs([$rlc], 'ROLE_RLC');
        }

        $this->em->persist($rlc);
        $this->em->flush();
    }

    /**
     * Supprime le rlc de la table RLC et retire le rôle ROLE_RLC à l'utilisateur associé.
     *
     * @param Rlc $rlc
     */
    public function supprimerRlc(Rlc $rlc)
    {
        $rlcUser = $rlc->getUtilisateur();

        $this->utilisateurManager->supprimerRole('ROLE_RLC', $rlcUser);

        $this->em->remove($rlc);
        $this->em->flush();
    }

    /**
     * Permet de créer un RLC.
     *
     * @param RLC $rlc
     */
    public function create(Utilisateur $rlc)
    {
        /* @var $utilisateur Utilisateur */
        $utilisateur = $this->fos_user_manager->findUserByUsernameOrEmail($rlc->getEmail());

        // L'utilisateur existe déjà
        if ($utilisateur) {
            if ($utilisateur->hasRole('ROLE_ADMIN')) {
                throw new \Exception('Erreur : cet utilisateur dispose du ROLE_ADMIN !');
            }

            // Si l'utilisateur est incatif, on lui supprime tous ses anciens rôles
            if (!$utilisateur->isEnabled()) {
                $utilisateur->removeAllRoles();
            }

            // On lui ajoute le rôle RLC
            $utilisateur->addRole('ROLE_RLC');
            $utilisateur->setCivilite($rlc->getCivilite());
            $utilisateur->setNom($rlc->getNom());
            $utilisateur->setPrenom($rlc->getPrenom());

            $this->fos_user_manager->updateUser($utilisateur);
        } else {
            $rlc->addRole('ROLE_RLC');
            $this->utilisateurManager->creer($rlc, false);
        }
    }

    /**
     * Permet de modifier un RLC.
     *
     * @param RLC $rlc
     */
    public function update(Utilisateur $rlc)
    {
        $this->em->persist($rlc);
        $this->em->flush();
    }

    /**
     * Permet de supprimer un RLC.
     *
     * @param RLC $rlc
     */
    public function delete(Utilisateur $rlc)
    {
        if ($rlc->hasRole('ROLE_ADMIN')) {
            throw new \Exception('Erreur : cet utilisateur dispose du ROLE_ADMIN !');
        }

        $this->utilisateurManager->supprimerRole('ROLE_RLC', $rlc);
    }

    /**
     * Retourne l'ensemble des RLC d'un ministère.
     *
     * @param Ministere $ministere
     *
     * @return Collection Rlc
     */
    public function getRlc(Ministere $ministere)
    {
        return $this->getRepository()->findByMinistere($ministere);
    }

    /**
     * Retourne l'ensemble des RLC d'un ministère.
     *
     * @param Ministere $ministere
     *
     * @return Collection Rlc
     */
    public function getRlcs()
    {
        if ('ROLE_ADMIN' === $this->session->get('selectedRole')) {
            return $this->em->getRepository('AppBundle:Rlc')->findAll();
        } else {
            $ministere = $this->tokenStorage->getToken()->getUser()->getMinistere();

            return $this->em->getRepository('AppBundle:Rlc')->findByMinistere($ministere);
        }
    }

    /**
     * Retourne le repository de Rlc.
     *
     * @return EntityRepository
     */
    public function getRepository()
    {
        return $this->em->getRepository('AppBundle:Rlc');
    }
}
