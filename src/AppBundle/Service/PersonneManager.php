<?php

namespace AppBundle\Service;

use AppBundle\Entity\PerimetreBrhp;
use AppBundle\Entity\PerimetreRlc;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Utilisateur;
use FOS\UserBundle\Util\TokenGenerator;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class PersonneManager extends BaseManager
{
    protected $tokenGenerateur;

    protected $tokenSauvegarde;

    protected $mailer;

    protected $defaultPassword;

    public function __construct(
        EntityManager $em,
        TokenGenerator $tokenGenerateur,
        TokenStorage $tokenSauvegarde,
        Mailer $mailer,
        $defaultPassword
    ) {
        $this->em = $em;
        $this->tokenGenerateur = $tokenGenerateur;
        $this->tokenSauvegarde = $tokenSauvegarde;
        $this->mailer = $mailer;
        $this->defaultPassword = $defaultPassword;
    }

    /**
     * Récupère le gestionnaire de l'entité Personne.
     *
     * @return EntityManager
     */
    protected function recupereEntrepot()
    {
        return $this->em->getRepository('AppBundle:Personne');
    }

    
    /**
     * Récupère les brhps d'un ou plusieurs périmètres.
     *
     * @param Collection $perimetres Une collection de périmètres
     *
     * @return array Un tableau contenant les personnes
     */
    public function getBrhps(Collection $perimetresBrhp){
    	$brhps = [];
    	
    	/* @var $perimetreBrhp PerimetreBrhp */
    	foreach ($perimetresBrhp as $perimetreBrhp) {
    		$brhps = array_merge($brhps, $perimetreBrhp->getBrhps()->toArray());
    	}
    	
    	return $brhps;
    }
    
    /**
     * Récupère les brhps consultants d'un ou plusieurs périmètres.
     *
     * @param Collection $perimetres Une collection de périmètres
     *
     * @return array Un tableau contenant les personnes
     */
    public function getBrhpsConsult(Collection $perimetresBrhp){
    	$brhpsConsult = [];
    	 
    	/* @var $perimetreBrhp PerimetreBrhp */
    	foreach ($perimetresBrhp as $perimetreBrhp) {
    		$brhpsConsult = array_merge($brhpsConsult, $perimetreBrhp->getBrhpsConsult()->toArray());
    	}
    	 
    	return $brhpsConsult;
    }
    
    /**
     * Récupère les rlcs d'un ou plusieurs périmètres.
     *
     * @param Collection $perimetres Une collection de périmètres
     *
     * @return array Un tableau contenant les personnes
     */
    public function getRlcs(Collection $perimetresRlc){
    	$rlcs = [];
    
    	/* @var $perimetreRlc PerimetreRlc */
    	foreach ($perimetresRlc as $perimetreRlc) {
    		$rlcs = array_merge($rlcs, $perimetreRlc->getRlcs()->toArray());
    	}
    
    	return $rlcs;
    }
    

    /**
     * Fait passer les gestionnaires en utilisateurs.
     *
     * @param array $gestionnaires Les gestionnaires que l'on souhaite passer en utilisateurs
     */
    public function ajoutePersonnesDansUtilisateurs(array $personnes, $role)
    {
        $utilisateurs = array();

        foreach ($personnes as $personne) {
            // si personne est un doublon, on passe à la personne suivante
            if (isset($utilisateurs[$personne->getId()])) {
                continue;
            }

            /* @var $utilisateur Utilisateur */
            $utilisateur = $this->em->getRepository('AppBundle:Utilisateur')->findOneByEmail($personne->getEmail());

            if (!$utilisateur) {
                // génére token
                $token = $this->tokenGenerateur->generateToken();
                $nouvelUtilisateur = new Utilisateur();
                $nouvelUtilisateur
                    ->setCivilite($personne->getCivilite())
                    ->setPrenom($personne->getPrenom())
                    ->setNom($personne->getNom())
                    ->setEmail($personne->getEmail())
                    ->setRoles(array($role))
                    ->setMinistere($this->tokenSauvegarde->getToken()->getUser()->getMinistere())
                    ->setEnabled(true)
                    ->setNbConnexionKO(0);

                if ($this->defaultPassword) {
                    $nouvelUtilisateur->setPlainPassword($this->defaultPassword);
                }

                $personne->setUtilisateur($nouvelUtilisateur);

                $this->em->persist($nouvelUtilisateur);
                $this->em->persist($personne);

                if (null === $nouvelUtilisateur->getConfirmationToken()) {
                    $nouvelUtilisateur->setConfirmationToken($token);
                }

                $this->mailer->sendConfirmationEmailMessage($nouvelUtilisateur);
            } else {
                // si l'entité "Utilisateur" n'est pas en relation avec l'entité "Personne"
                $personne->setUtilisateur($utilisateur);

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

            // ajoute le personne dans le tableau utilisateurs
            $utilisateurs[$personne->getId()] = $personne;
        }
        $this->em->flush();
    }
}
