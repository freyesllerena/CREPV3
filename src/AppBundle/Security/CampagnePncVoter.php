<?php

namespace AppBundle\Security;

use AppBundle\Entity\CampagnePnc;
use AppBundle\Entity\Utilisateur;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManager;
use AppBundle\EnumTypes\EnumStatutCampagne;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\Brhp;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use AppBundle\Entity\CampagneBrhp;

class CampagnePncVoter extends Voter
{
    /* @var $decisionManager AccessDecisionManager */
    protected $decisionManager;

    /**
     * @var EntityManager
     */
    protected $em;

    protected $session;

    // Liste des actions supportées
    const VOIR = 'voir_campagne_pnc';
    const MODIFIER = 'modifier_campagne_pnc';
    const SUPPRIMER = 'supprimer_campagne_pnc';
    const OUVRIR = 'ouvrir_campagne_pnc';
//     const CONSULTER_DOCUMENT = 'consulter_document_campagne_pnc';
    const SUPPRIMER_DOCUMENT = 'supprimer_document_campagne_pnc';
    const DIFFUSER_POPULATION = 'diffuser_population_campagne_pnc';
    const SUPPRIMER_POPULATION = 'supprimer_population_campagne_pnc';
    const CLOTURER = 'cloturer_campagne_pnc';
    const ROUVRIR = 'rouvrir_campagne_pnc';
    const FERMER = 'fermer_campagne_pnc';
    const AJOUTER_AGENT = 'ajouter_agent_campagne_pnc';
    const LISTER_AGENTS = 'lister_agent_campagne_pnc';
    const VOIR_SANS_PERIMETRE = 'voir_sans_perimetre';
    const CONSULTER_FICHIER_POPULATION = 'consulter_fichier_population_campagne_pnc';
    const EXTRAIRE_DONNEES_AGENTS = 'extraire_donnees_agents_campagne_pnc';

    public function __construct(AccessDecisionManagerInterface $decisionManager, EntityManagerInterface $em, SessionInterface $session)
    {
        $this->em = $em;
        $this->decisionManager = $decisionManager;
        $this->session = $session;
    }

    protected function supports($attribute, $subject)
    {
        // Si l'attribut n'est pas supporté, return false
        if (!in_array($attribute, array(
            self::VOIR,
            self::MODIFIER,
            self::SUPPRIMER,
            self::OUVRIR,
//         	self::CONSULTER_DOCUMENT,
            self::SUPPRIMER_DOCUMENT,
            self::DIFFUSER_POPULATION,
            self::SUPPRIMER_POPULATION,
            self::CLOTURER,
            self::ROUVRIR,
            self::FERMER,
            self::AJOUTER_AGENT,
            self::LISTER_AGENTS,
            self::VOIR_SANS_PERIMETRE,
            self::CONSULTER_FICHIER_POPULATION,
            self::EXTRAIRE_DONNEES_AGENTS,
        ))) {
            return false;
        }

        // Si l'objet n'est pas de type CampagnePnc, il n'est pas supporté
        if ($subject && !$subject instanceof CampagnePnc) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $utilisateur = $token->getUser();

        /* @var $roleUtilisateurSession string */
        $roleUtilisateurSession = $this->session->get('selectedRole');

        /* @var $campagnePnc CampagnePnc  */
        $campagnePnc = $subject;

        if (!$utilisateur instanceof Utilisateur) {
            // Si l'utilisateur n'est pas connecté, l'accès est refusé
            return false;
        }

        if (!$utilisateur->hasRole('ROLE_ADMIN') && $utilisateur->getMinistere()->getId() != $campagnePnc->getMinistere()->getId()) {
            // Si l'utilisateur n'est pas du même ministere que la campagne PNC, l'accès est refusé
            return false;
        }

        switch ($attribute) {
            case self::VOIR:
                return $this->peutVoir($campagnePnc, $utilisateur, $roleUtilisateurSession);
            case self::MODIFIER:
                return $this->peutModifier($campagnePnc, $utilisateur);
            case self::SUPPRIMER:
                return $this->peutSupprimer($campagnePnc, $utilisateur);
            case self::OUVRIR:
                return $this->peutOuvrir($campagnePnc, $utilisateur);
//           	case self::CONSULTER_DOCUMENT:
//                 return $this->peutConsulterDocument($campagnePnc, $utilisateur, $roleUtilisateurSession);
            case self::SUPPRIMER_DOCUMENT:
                return $this->peutSupprimerDocument($campagnePnc, $utilisateur);
            case self::DIFFUSER_POPULATION:
                return $this->peutDiffuserPopulation($campagnePnc, $utilisateur, $roleUtilisateurSession);
            case self::SUPPRIMER_POPULATION:
                return $this->peutSupprimerPopulation($campagnePnc, $utilisateur, $roleUtilisateurSession);
            case self::CLOTURER:
                return $this->peutCloturer($campagnePnc, $utilisateur, $roleUtilisateurSession);
            case self::ROUVRIR:
                return $this->peutRouvrir($campagnePnc, $utilisateur, $roleUtilisateurSession);
            case self::FERMER:
                return $this->peutFermer($campagnePnc, $utilisateur, $roleUtilisateurSession);
            case self::AJOUTER_AGENT:
                return $this->peutAjouterAgent($campagnePnc, $utilisateur, $roleUtilisateurSession);
            case self::LISTER_AGENTS:
                    return $this->peutListerAgent($campagnePnc, $utilisateur, $roleUtilisateurSession);
            case self::VOIR_SANS_PERIMETRE:
                return $this->peutVoirSansPerimetre($campagnePnc, $utilisateur, $roleUtilisateurSession);
            case self::CONSULTER_FICHIER_POPULATION:
                return $this->peutConsulterFichierPopulation($campagnePnc, $utilisateur, $roleUtilisateurSession);
            case self::EXTRAIRE_DONNEES_AGENTS:
                return $this->peutExtraireDonneesAgents($campagnePnc, $utilisateur, $roleUtilisateurSession);
        }

        throw new \LogicException('Erreur de logique : type d\'accès '.$attribute.' non géré !');
    }

    private function peutVoir(CampagnePnc $campagnePnc, Utilisateur $utilisateur, $roleUtilisateurSession)
    {
        if ($utilisateur->hasRole('ROLE_ADMIN')) {
            return true;
        } elseif ('ROLE_ADMIN_MIN' === $roleUtilisateurSession) {
            if (in_array($campagnePnc->getStatut(), [EnumStatutCampagne::OUVERTE, EnumStatutCampagne::FERMEE, EnumStatutCampagne::CLOTUREE])) {
                return true;
            }
        } elseif ('ROLE_PNC' === $roleUtilisateurSession) {
            return true;
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutModifier(CampagnePnc $campagnePnc, Utilisateur $utilisateur)
    {
        if ($utilisateur->hasRole('ROLE_ADMIN') && in_array($campagnePnc->getStatut(), array(EnumStatutCampagne::CREEE, EnumStatutCampagne::OUVERTE))) {
            return true;
        }

        // Si l'utilisateur a le bon Ministère
        if (in_array($campagnePnc->getStatut(), array(EnumStatutCampagne::CREEE, EnumStatutCampagne::OUVERTE))) {
            return true;
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutSupprimer(CampagnePnc $campagnePnc, Utilisateur $utilisateur)
    {
        if ($utilisateur->hasRole('ROLE_ADMIN') && in_array($campagnePnc->getStatut(), array(EnumStatutCampagne::CREEE))) {
            return true;
        }

        // Si l'utilisateur a le bon Ministère
        if (in_array($campagnePnc->getStatut(), array(EnumStatutCampagne::CREEE))) {
            return true;
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutOuvrir(CampagnePnc $campagnePnc, Utilisateur $utilisateur)
    {
        if ($utilisateur->hasRole('ROLE_ADMIN') && in_array($campagnePnc->getStatut(), array(EnumStatutCampagne::CREEE))) {
            return true;
        }

        // Si l'utilisateur a le bon Ministère
        if (in_array($campagnePnc->getStatut(), array(EnumStatutCampagne::CREEE))) {
            return true;
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutSupprimerDocument(CampagnePnc $campagnePnc, Utilisateur $utilisateur)
    {
        if ($utilisateur->hasRole('ROLE_ADMIN')) {
            return true;
        }

        if (in_array($campagnePnc->getStatut(), array(EnumStatutCampagne::CREEE, EnumStatutCampagne::OUVERTE))) {
            return true;
        }

        // Dans tous les autres cas, on refuse l'accès
        return false;
    }

    private function peutDiffuserPopulation(CampagnePnc $campagnePnc, Utilisateur $utilisateur, $roleUtilisateurSession)
    {
        if (!$campagnePnc->getDiffusee()
            && EnumStatutCampagne::OUVERTE == $campagnePnc->getStatut()
            && in_array($roleUtilisateurSession, ['ROLE_ADMIN', 'ROLE_ADMIN_MIN'])) {
            return true;
        }

        return false;
    }

    private function peutSupprimerPopulation(CampagnePnc $campagnePnc, Utilisateur $utilisateur, $roleUtilisateurSession)
    {
    	// On compte le nombre de campagnes BRHP ayant un statut différent de CREEE
    	// Si une des campagnes Brhp a déjà été ouverte aux N+1 
    	//  => le fichier de popultaion ne peut plus être supprimé
    	$nbCampgnesBrhp = $this->em->getRepository(CampagneBrhp::class)->countCampagnesByNotStatut($campagnePnc, EnumStatutCampagne::CREEE);
    	
    	if($nbCampgnesBrhp == 0 && in_array($roleUtilisateurSession, ['ROLE_ADMIN', 'ROLE_ADMIN_MIN'])){
    		return true;
    	}

        return false;
    }

    private function peutCloturer(CampagnePnc $campagnePnc, Utilisateur $utilisateur, $roleUtilisateurSession)
    {
        if (EnumStatutCampagne::OUVERTE === $campagnePnc->getStatut()
            && in_array($roleUtilisateurSession, ['ROLE_ADMIN', 'ROLE_PNC'])) {
            return true;
        }

        return false;
    }

    private function peutRouvrir(CampagnePnc $campagnePnc, Utilisateur $utilisateur, $roleUtilisateurSession)
    {
        if (EnumStatutCampagne::CLOTUREE === $campagnePnc->getStatut()
            && in_array($roleUtilisateurSession, ['ROLE_ADMIN', 'ROLE_PNC'])) {
            return true;
        }

        return false;
    }

    private function peutFermer(CampagnePnc $campagnePnc, Utilisateur $utilisateur, $roleUtilisateurSession)
    {
        if (EnumStatutCampagne::CLOTUREE === $campagnePnc->getStatut()
            && in_array($roleUtilisateurSession, ['ROLE_ADMIN', 'ROLE_PNC'])) {
            return true;
        }

        return false;
    }

    private function peutAjouterAgent(CampagnePnc $campagnePnc, Utilisateur $utilisateur, $roleUtilisateurSession)
    {
        if (in_array($roleUtilisateurSession, ['ROLE_ADMIN', 'ROLE_PNC'])
            && in_array($campagnePnc->getStatut(), [
                EnumStatutCampagne::INITIALISEE,
                EnumStatutCampagne::CREEE,
                EnumStatutCampagne::OUVERTE, ])
            && $campagnePnc->getDiffusee()) {
            return true;
        }

        return false;
    }

    private function peutVoirSansPerimetre(CampagnePnc $campagnePnc, Utilisateur $utilisateur, $roleUtilisateurSession)
    {
        if (in_array($roleUtilisateurSession, ['ROLE_ADMIN', 'ROLE_PNC', 'ROLE_RLC'])) {
            return true;
        }

        return false;
    }

    private function peutListerAgent(CampagnePnc $campagnePnc, Utilisateur $utilisateur, $roleUtilisateurSession)
    {
        if (in_array($roleUtilisateurSession, ['ROLE_ADMIN', 'ROLE_PNC', 'ROLE_RLC', 'ROLE_BRHP', 'ROLE_SHD'])) {
            return true;
        }

        return false;
    }

    private function peutConsulterDocument(CampagnePnc $campagnePnc, Utilisateur $utilisateur, $roleUtilisateurSession)
    {
        if (in_array($roleUtilisateurSession, ['ROLE_ADMIN', 'ROLE_PNC'])) {
            return true;
        }

        if ('ROLE_RLC' == $roleUtilisateurSession) {
            /** @var $rlc Rlc */
            $rlc = $this->em->getRepository('AppBundle:Rlc')->findOneByUtilisateur($utilisateur);

            // On fait l'intersection des périmètres de la campagne et des périmètres du RLC
            // Il faut que le RLC gère au moins un périmètre des ceux de la campagne
            if ($rlc && !empty(array_intersect($campagnePnc->getPerimetresRlc()->toArray(), $rlc->getPerimetresRlc()->toArray()))) {
                return true;
            }
        }

        if ('ROLE_BRHP' == $roleUtilisateurSession) {
            // TODO : croiser l'ensemble des peimetres BRHP de la campagne PNC et les perimetres du RLC
        }

        if ('ROLE_SHD' == $roleUtilisateurSession) {
            // TODO : croiser les campagnes du SHD et la campagne PNC
        }

        // TODO : gérer les accès des autres rôles

        return false;
    }

    private function peutConsulterFichierPopulation(CampagnePnc $campagnePnc, Utilisateur $utilisateur, $roleUtilisateurSession)
    {
        if (in_array($roleUtilisateurSession, ['ROLE_ADMIN', 'ROLE_ADMIN_MIN'])) {
            return true;
        }

        return false;
    }

    private function peutExtraireDonneesAgents(CampagnePnc $campagnePnc, Utilisateur $utilisateur, $roleUtilisateurSession)
    {
        if (in_array($roleUtilisateurSession, ['ROLE_ADMIN', 'ROLE_ADMIN_MIN'])) {
            return true;
        }

        return false;
    }
}
