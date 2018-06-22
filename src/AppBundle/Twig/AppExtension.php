<?php

namespace AppBundle\Twig;

use AppBundle\EnumTypes\EnumStatutCrep;
use AppBundle\EnumTypes\EnumStatutValidationAgent;
use AppBundle\Entity\Utilisateur;
use AppBundle\Entity\Personne;
use AppBundle\Util\Util;
use AppBundle\Entity\Crep\CrepMso3\CrepMso3;
Use AppBundle\Entity\Crep\CrepMcc02\CrepMcc02;
use AppBundle\Entity\Crep\CrepMindef01\CrepMindef01;
use AppBundle\Entity\Crep\CrepMindef\CrepMindef;
use AppBundle\Entity\Crep\CrepAc\CrepAc;
use AppBundle\Entity\Crep\CrepMinefAbc\CrepMinefAbc;
use AppBundle\Entity\Crep\CrepEdd\CrepEdd;
use AppBundle\Entity\Agent;
use AppBundle\Entity\PersonneInterface;

class AppExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('role', array(
                $this,
                'roleImpression',
            )),
            new \Twig_SimpleFilter('fileIcon', array(
                $this,
                'fileIcon',
            )),
            new \Twig_SimpleFilter('statutCrep', array(
                $this,
                'statutCrep',
            )),
            new \Twig_SimpleFilter('statutCrepImpression', array(
                $this,
                'statutCrepImpression',
            )),
            new \Twig_SimpleFilter('statutCrepAvancementPourcentage', array(
                $this,
                'statutCrepAvancementPourcentage',
            )),
            new \Twig_SimpleFilter('statutCrepEtapeAvancement', array(
                $this,
                'statutCrepEtapeAvancement',
            )),
            new \Twig_SimpleFilter('statutCrepCouleur', array(
                $this,
                'statutCrepCouleur',
            )),
            new \Twig_SimpleFilter('echelleObjectifEvalueCrepMindef', array(
                $this,
                'echelleObjectifEvalueCrepMindef',
            )),
            new \Twig_SimpleFilter('origineDemandeFormationCrepMcc', array(
                $this,
                'origineDemandeFormationCrepMcc',
            )),
            new \Twig_SimpleFilter('echelleObjectifEvalueCrepMindef01', array(
                $this,
                'echelleObjectifEvalueCrepMindef01',
            )),
            new \Twig_SimpleFilter('echelleObjectifEvalueCrepAc', array(
                $this,
                'echelleObjectifEvalueCrepAc',
            )),
            new \Twig_SimpleFilter('echelleObjectifEvalueCrepEdd', array(
                $this,
                'echelleObjectifEvalueCrepEdd',
            )),
            new \Twig_SimpleFilter('echelleNiveauSameCrepMindef01', array(
                $this,
                'echelleNiveauSameCrepMindef01',
            )),
            new \Twig_SimpleFilter('selectTypologieFormationCrepMindef01', array(
                $this,
                'selectTypologieFormationCrepMindef01',
            )),
            new \Twig_SimpleFilter('selectTypologieFormationCrepMinefAbc', array(
                $this,
                'selectTypologieFormationCrepMinefAbc',
            )),
            new \Twig_SimpleFilter('selectTypologieFormationCrepEdd', array(
                $this,
                'selectTypologieFormationCrepEdd',
            )),
            new \Twig_SimpleFilter('ouiNon', array(
                $this,
                'ouiNon',
            )),
            new \Twig_SimpleFilter('iconCheck', array(
                $this,
                'iconCheck',
            )),
            new \Twig_SimpleFilter('iconCheckReverse', array(
                    $this,
                    'iconCheckReverse',
            )),
            new \Twig_SimpleFilter('statutAgentFilter', array(
                $this,
                'statutAgentFilter',
            )),
            new \Twig_SimpleFilter('typeEntretienFilter', array(
                $this,
                'typeEntretienFilter',
            )),
            new \Twig_SimpleFilter('identite', array(
                    $this,
                    'identite',
            )),
            new \Twig_SimpleFilter('escapeJs', array(
                $this,
                'escapeJs',
            )),
			new \Twig_SimpleFilter('echelleObjectifEvalueCrepMcc02', array(
                $this,
                'echelleObjectifEvalueCrepMcc02'
            )),
        	new \Twig_SimpleFilter('typeRecoursFilter', array(
        			$this,
        			'typeRecoursFilter'
        	)),
        	new \Twig_SimpleFilter('typeDecisionRecoursFilter', array(
        			$this,
        			'typeDecisionRecoursFilter'
        	)),
        	new \Twig_SimpleFilter('echelleObjectifEvalueCrepMso3', array(
        			$this,
        			'echelleObjectifEvalueCrepMso3'
        	)),
            new \Twig_SimpleFilter('niveauCompetenceCrepMcc02', array(
                $this,
                'niveauCompetenceCrepMcc02'
            )),
            new \Twig_SimpleFilter('allNiveauCompetenceCrepMcc02', array(
                $this,
                'allNiveauCompetenceCrepMcc02'
            )),
            new \Twig_SimpleFilter('allNiveauPotentielEvolutionCrepMcc02', array(
                $this,
                'allNiveauPotentielEvolutionCrepMcc02'
            )),
        );
    }


    public function getTests()
    {
        return array(
            new \Twig_SimpleFilter('role', array(
                $this,
                'roleImpression',
            )),
        );
    }

    public function roleImpression($role = null)
    {
        if (!$role) {
            return '';
        }

        $roles = [
            'ROLE_ADMIN' => 'Administrateur',
            'ROLE_ADMIN_MIN' => 'Administrateur ministériel',
            'ROLE_DGAFP' => 'DGAFP',
            'ROLE_PNC' => 'Pilote national de campagne',
            'ROLE_RLC' => 'Responsable local de campagne',
            'ROLE_BRHP' => 'Acteur RH de proximité',
            'ROLE_BRHP_CONSULT' => 'Acteur RH de proximité consultation',
            'ROLE_GESTIONNAIRE_RECOURS' => 'Gestionnaire de recours',
            'ROLE_CONSEILLER_FORMATION' => 'Conseiller de formation',
            'ROLE_SHD' => 'N+1',
            'ROLE_AH' => 'N+2',
            'ROLE_AGENT' => 'Agent',
        ];

        if (array_key_exists($role, $roles)) {
            return $roles[$role];
        }

        return '';
    }

    public function fileIcon($fileName)
    {
        $extension = pathinfo($fileName)['extension'];

        switch ($extension) {
            case 'doc':
            case 'docx':
                $icone = 'fa fa-file-word-o';
                break;
            case 'pdf':
                $icone = 'fa fa-file-pdf-o';
                break;
            case 'xls':
            case 'xlsx':
            case 'odt':
            case 'csv':
                $icone = 'fa fa-file-excel-o';
                break;
            case 'zip':
            case 'rar':
                $icone = 'fa fa-file-archive-o';
                break;
            default:
                $icone = 'fa fa-file-o';
        }

        return $icone;
    }

    public function statutCrep($statut)
    {
        switch ($statut) {
            case EnumStatutCrep::CREE:
                $label = 'label-primary';
                break;
            case EnumStatutCrep::MODIFIE_SHD:
                $label = 'label-primary';
                break;
            case EnumStatutCrep::SIGNE_SHD:
                $label = 'label-info';
                break;
            case EnumStatutCrep::VISE_AGENT:
                $label = 'label-warning';
                break;
            case EnumStatutCrep::REFUS_VISA_AGENT:
                $label = 'label-danger';
                break;
            case EnumStatutCrep::SIGNE_AH:
                $label = 'label-info';
                break;
            case EnumStatutCrep::NOTIFIE_AGENT:
                $label = 'label-success';
                break;
            case EnumStatutCrep::REFUS_EP:
                $label = 'label-danger';
                break;
            case EnumStatutCrep::REFUS_NOTIFICATION_AGENT:
                $label = 'label-danger';
                break;
            case EnumStatutCrep::CAS_ABSENCE:
                $label = 'label-default';
                break;
            default:
                $label = 'label-info';
        }

        return $label;
    }

    public function statutCrepImpression($statut)
    {
        switch ($statut) {
            case '':
                $statut = "En attente d'initialisation";
                break;
            case EnumStatutCrep::CREE:
                $statut = 'Créé';
                break;
            case EnumStatutCrep::MODIFIE_SHD:
                $statut = 'En cours de rédaction';
                break;
            case EnumStatutCrep::SIGNE_SHD:
                $statut = 'Signé N+1';
                break;
            case EnumStatutCrep::VISE_AGENT:
                $statut = 'Visé agent';
                break;
            case EnumStatutCrep::REFUS_VISA_AGENT:
                $statut = 'Refus visa agent';
                break;
            case EnumStatutCrep::SIGNE_AH:
                $statut = 'Signé N+2';
                break;
            case EnumStatutCrep::NOTIFIE_AGENT:
                $statut = 'Signé agent';
                break;
            case EnumStatutCrep::REFUS_EP:
                $statut = 'Refus entretien professionnel';
                break;
            case EnumStatutCrep::REFUS_NOTIFICATION_AGENT:
                $statut = 'Refus signature agent';
                break;
            case EnumStatutCrep::CAS_ABSENCE:
                $statut = "CREP en cas d'absence de l'agent";
                break;
        }

        return $statut;
    }

    public function statutCrepAvancementPourcentage($statut)
    {
        switch ($statut) {
            case EnumStatutCrep::CREE:
                $avancementPourcentage = 20;
                break;
            case EnumStatutCrep::MODIFIE_SHD:
                $avancementPourcentage = 20;
                break;
            case EnumStatutCrep::SIGNE_SHD:
                $avancementPourcentage = 40;
                break;
            case EnumStatutCrep::VISE_AGENT:
                $avancementPourcentage = 60;
                break;
            case EnumStatutCrep::REFUS_VISA_AGENT:
                $avancementPourcentage = 60;
                break;
            case EnumStatutCrep::SIGNE_AH:
                $avancementPourcentage = 80;
                break;
            case EnumStatutCrep::NOTIFIE_AGENT:
                $avancementPourcentage = 100;
                break;
            case EnumStatutCrep::REFUS_EP:
                $avancementPourcentage = 0;
                break;
            case EnumStatutCrep::REFUS_NOTIFICATION_AGENT:
                $avancementPourcentage = 100;
                break;
            case EnumStatutCrep::CAS_ABSENCE:
                $avancementPourcentage = 100;
                break;
        }

        return $avancementPourcentage;
    }

    public function statutCrepEtapeAvancement($statut)
    {
        switch ($statut) {
            case '':
                $etapeAvancement = '0/5';
                break;
            case EnumStatutCrep::CREE:
                $etapeAvancement = '1/5';
                break;
            case EnumStatutCrep::MODIFIE_SHD:
                $etapeAvancement = '1/5';
                break;
            case EnumStatutCrep::SIGNE_SHD:
                $etapeAvancement = '2/5';
                break;
            case EnumStatutCrep::VISE_AGENT:
                $etapeAvancement = '3/5';
                break;
            case EnumStatutCrep::REFUS_VISA_AGENT:
                $etapeAvancement = '3/5';
                break;
            case EnumStatutCrep::SIGNE_AH:
                $etapeAvancement = '4/5';
                break;
            case EnumStatutCrep::NOTIFIE_AGENT:
                $etapeAvancement = '5/5';
                break;
            case EnumStatutCrep::REFUS_EP:
                $etapeAvancement = '0';
                break;
            case EnumStatutCrep::REFUS_NOTIFICATION_AGENT:
                $etapeAvancement = '5/5';
                break;
            case EnumStatutCrep::CAS_ABSENCE:
                $etapeAvancement = '5/5';
                break;
        }

        return $etapeAvancement;
    }

    public function statutCrepCouleur($statut)
    {
        $couleur = '';

        switch ($statut) {
            case EnumStatutCrep::CREE:
                $couleur = 'bg-blue-sky';
                break;
            case EnumStatutCrep::MODIFIE_SHD:
                $couleur = 'bg-crepModifieShd';
                break;
            case EnumStatutCrep::SIGNE_SHD:
                $couleur = 'bg-blue';
                break;
            case EnumStatutCrep::VISE_AGENT:
                $couleur = 'bg-purple';
                break;
            case EnumStatutCrep::REFUS_VISA_AGENT:
                $couleur = 'bg-crepRefusVisa';
                break;
            case EnumStatutCrep::SIGNE_AH:
                $couleur = 'bg-orange';
                break;
            case EnumStatutCrep::NOTIFIE_AGENT:
                $couleur = 'bg-green';
                break;
            case EnumStatutCrep::REFUS_EP:
                $couleur = 'bg-red';
                break;
            case EnumStatutCrep::REFUS_NOTIFICATION_AGENT:
                $couleur = 'bg-crepRefusNotification';
                break;
            case EnumStatutCrep::CAS_ABSENCE:
                $couleur = 'bg-crepCasAbsence';
                break;
        }

        return $couleur;
    }

    public function echelleObjectifEvalueCrepMindef($objectifEvalue)
    {
        if (null === $objectifEvalue) {
            return '';
        }

        return array_flip(CrepMindef::$echelleObjectifEvalue)[$objectifEvalue];
    }

    public function echelleObjectifEvalueCrepMindef01($objectifEvalue)
    {
        if (null === $objectifEvalue) {
            return '';
        }

        return array_flip(CrepMindef01::$echelleObjectifEvalue)[$objectifEvalue];
    }

    public function echelleObjectifEvalueCrepAc($objectifEvalue)
    {
        if (null === $objectifEvalue) {
            return '';
        }

        return array_flip(CrepAc::$echelleObjectifEvalue)[$objectifEvalue];
    }

    public function echelleObjectifEvalueCrepEdd($objectifEvalue)
    {
        if (null === $objectifEvalue) {
            return '';
        }

        return array_flip(CrepEdd::$echelleObjectifEvalue)[$objectifEvalue];
    }

    public static function echelleNiveauSameCrepMindef01($niveauSame)
    {
        if (null === $niveauSame) {
            return '';
        }

        return array_flip(CrepMindef01::$echelleNiveauSame)[$niveauSame];
    }

    public static function selectTypologieFormationCrepMindef01($typologieFormation)
    {
        if (null === $typologieFormation) {
            return '';
        }

        return array_flip(CrepMindef01::$selectTypologieFormation)[$typologieFormation];
    }

    public static function selectTypologieFormationCrepMinefAbc($typologieFormation)
    {
        if (null === $typologieFormation) {
            return '';
        }

        return array_flip(CrepMinefAbc::$selectTypologieFormation)[$typologieFormation];
    }

    public function echelleObjectifEvalueCrepMcc02($objectifEvalue)
    {
        if (null === $objectifEvalue) {
            return '';
        }

        return array_flip(CrepMcc02::$echelleObjectifEvalue)[$objectifEvalue];
    }

    public static function selectTypologieFormationCrepEdd($typologieFormation)
    {
        if (null === $typologieFormation) {
            return '';
        }

        return array_flip(CrepEdd::$selectTypologieFormation)[$typologieFormation];
    }

    public static function ouiNon($valeur)
    {
    	$resultat ='';

        if (true === $valeur || 1 == $valeur) {
            $resultat = 'Oui';
        }

        if (false === $valeur || 0 == $valeur) {
            $resultat = 'Non';
        }

        if (null === $valeur) {
            $resultat = '';
        }

        return $resultat;
    }

    public function iconCheck($niveau, $index)
    {
        if (null === $niveau) {
            return '<br>';
        }

        return $niveau === $index ? '<i class="fa fa-check"></i>' : '<br>';
    }

    public function iconCheckReverse($niveau, $index, $nbNiveaux)
    {
        if (null === $niveau) {
            return;
        }

        return ($nbNiveaux - $niveau === $index) ? '<i class="fa fa-check"></i>' : '';
    }

    public function statutAgentFilter($statut, $type = 'message')
    {
        $messages = [
            EnumStatutValidationAgent::EN_COURS => 'Rattachement en attente de validation',
            EnumStatutValidationAgent::VALIDE => 'Rattachement validé',
            EnumStatutValidationAgent::REJETE => 'Rattachement rejeté',
            EnumStatutValidationAgent::ERREUR_SIGNALEE => 'Erreur signalée',
        ];

        $icones = [
            EnumStatutValidationAgent::EN_COURS => 'fa-clock-o orange',
            EnumStatutValidationAgent::VALIDE => 'fa-check green',
            EnumStatutValidationAgent::REJETE => 'fa-remove red',
            EnumStatutValidationAgent::ERREUR_SIGNALEE => 'fa-remove red',
        ];

        $arguments = [
            'message' => $messages,
            'icone' => $icones,
        ];

        return $arguments[$type][$statut];
    }

    public function getName()
    {
        return 'app_extension';
    }

    public function typeEntretienFilter($valeur)
    {
        if (0 === $valeur) {
            $resultat = 'avec son bureau des ressources humaines';
        }

        if (1 == $valeur) {
            $resultat = 'avec son bureau gestionnaire (Direction des ressources humaines - SDRH 2)';
        }

        if (2 == $valeur) {
            $resultat = 'avec la mission de suivi personnalisé et des parcours professionnels (MS3P) de la DRH';
        }

        if (null === $valeur) {
            $resultat = '';
        }

        return $resultat;
    }

    public static function identite(PersonneInterface $personne)
    {
    	return Util::identite($personne);
    }

    public function escapeJs($html)
    {
        $blacklistedTags = ['script'];

        foreach ($blacklistedTags as $tag) {
            $html = str_replace($tag, '', $html);
        }

        return $html;
    }

    public static function typeRecoursFilter($type)
    {
        $typesRecours = ['Recours hiérarchique', 'Recours en CAP', 'Recours au tribunal administratif'];

        return isset($typesRecours[$type]) ? $typesRecours[$type] : '';
    }

    public static function typeDecisionRecoursFilter($type)
    {
        $typesDecisionsRecours = ['Suppression du CREP de l\'agent', 'Modification du CREP de l\'agent', 'Pas de modification du CREP de l\'agent'];

        return isset($typesDecisionsRecours[$type]) ? $typesDecisionsRecours[$type] : '';
    }

    public static function origineDemandeFormationCrepMcc($valeur)
    {
        $origines = [
                'Demande de l\'agent-e',
                'Avis du-de la responsable hiérarchique',
                'Demande au regard des objectifs du service',
        ];

        return isset($origines[$valeur]) ? $origines[$valeur] : '';
    }

    public function echelleObjectifEvalueCrepMso3($objectifEvalue)
    {
        if (null === $objectifEvalue) {
            return '';
        }

        return array_flip(CrepMso3::$echelleObjectifEvalue)[$objectifEvalue];
    }

    /**
     * Niveau competence CrepMcc02
     *
     * @param $niveaux
     * @return string
     */
    public function niveauCompetenceCrepMcc02($niveaux)
    {
        if (null === $niveaux) {
            return '';
        }

        return array_flip(CrepMcc02::$niveauCompetence)[$niveaux];
    }

    /**
     * Liste niveau compentences CrepMcc02
     * @return array
     */
    public function allNiveauCompetenceCrepMcc02()
    {
        return CrepMcc02::$niveauCompetence;
    }

    /**
     * Liste niveau potentiel evolution CrepMcc02
     * @return array
     */
    public function allNiveauPotentielEvolutionCrepMcc02()
    {
        return CrepMcc02::$niveauPotentielEvolution;
    }

    /**
     * Retourne une chaine sous forme 
     * M. Jeans MARTIN
     * Dr. Jean Paul DE LA RUE
     * Maître Frank DU MAINE
     * @param Agent $agent
     */
    private function identitePersonne(Agent $agent){
    	$result = '';
    		 
    	if($agent->getTitre()){
    		$result .= Util::twig_title($agent->getTitre());
    	}elseif ($agent->getCivilite()){
    		$result .= Util::twig_title($agent->getCivilite());
    	}

    	if($agent->getPrenom()){
    		$result .= ' '.Util::twig_title($agent->getPrenom());
    	}
    	
    	if($agent->getNom()){
    		$result .= ' '.Util::twig_upper($agent->getNom());
    	}
    	
    	return $result;
    }
}
