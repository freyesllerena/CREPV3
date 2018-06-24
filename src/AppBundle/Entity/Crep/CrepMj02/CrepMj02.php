<?php

/**
 * Created by PhpStorm.
 * User: freyes-adc
 * Date: 14/06/2018
 * Time: 13:50
 */

namespace AppBundle\Entity\Crep\CrepMj02;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Agent;
use AppBundle\Entity\Crep;
use AppBundle\Util\Converter;


/**
 * Class CrepMj02
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMj02Repository")
 */
class CrepMj02 extends Crep
{
    public static $echelleObjectifEvalue = [
        'Atteint' => 0,
        'Partiellement' => 1,
        'Non atteint' => 2,
        'Devenu sans objet' => 3,
    ];

    /**
     * @ORM\Column(type="string")
     * @Assert\Length(
     *    min = 2,
     *    max = 50,
     *    minMessage = "Le nom d'usage doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le nom d'usage ne doit pas faire plus de {{ limit }} caractères"
     * )
     */
    protected $nomUsage;

    /**
     * @ORM\Column(type="string")
     * @Assert\Length(
     *    min = 2,
     *    max = 50,
     *    minMessage = "Le nom de famille doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le nom de famille ne doit pas faire plus de {{ limit }} caractères"
     * )
     */
    protected $nomNaissance;

    /**
     * @ORM\Column(type="string")
     * @Assert\Length(
     *    min = 2,
     *    max = 50,
     *    minMessage = "Le nom marital doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le nom marital ne doit pas faire plus de {{ limit }} caractères"
     * )
     */
    protected $nomMarital;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message = "Prénom obligatoire")
     * @Assert\Length(
     *    min = 2,
     *    max = 50,
     *    minMessage = "Le prénom doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le prénom ne doit pas faire plus de {{ limit }} caractères"
     * )
     */
    protected $prenom;

    /**
     * @var \DateTime @ORM\Column(type="date")
     *
     * @Assert\Date(message = "Date non valide")
     *
     * @Assert\Range(
     *      min = "1900-01-01",
     *      max = "2999-12-31",
     *      minMessage = "Date non valide",
     *      maxMessage = "Date non valide"
     * )
     */
    protected $dateNaissance;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\Length(
     *    max = 255,
     *    maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $grade;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\Length(
     *    max = 255,
     *    maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $corps;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\Length(
     *    max = 255,
     *    maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $posteOccupe;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\DateTime(format="d/m/Y", message = "Date d'entrée dans le poste non valide. Le format attendu est JJ/MM/AAAA", groups={"importCSV", "Default"})
     */
    protected $dateEntreePosteOccupe;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=true)
     *
     */
    protected $activiteEncadrement;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $titulaire;

    /**
     * @ORM\Column(type="string")
     * @Assert\Length(
     *    max = 255,
     *    maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $direction;

    /**
     * @ORM\Column(type="string")
     * @Assert\Length(
     *    max = 255,
     *    maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $departement;

    /**
     * @ORM\Column(type="string")
     * @Assert\Length(
     *    max = 255,
     *    maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $service;

    /**
     * @ORM\Column(type="string")
     * @Assert\Length(
     *    max = 255,
     *    maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $directionShd;

    /**
     * @ORM\Column(type="string")
     * @Assert\Length(
     *    max = 255,
     *    maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $departementShd;

    /**
     * @ORM\Column(type="string")
     * @Assert\Length(
     *    max = 255,
     *    maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $serviceShd;


    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min = 0,
     *      max = 1000,
     *      minMessage = "Valeur non valide",
     *      maxMessage = "Valeur non valide",
     *      invalidMessage= "Valeur non valide",
     * )
     */
    protected $nbAgentsEncadresA;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min = 0,
     *      max = 1000,
     *      minMessage = "Valeur non valide",
     *      maxMessage = "Valeur non valide",
     *      invalidMessage= "Valeur non valide",
     * )
     */
    protected $nbAgentsEncadresB;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min = 0,
     *      max = 1000,
     *      minMessage = "Valeur non valide",
     *      maxMessage = "Valeur non valide",
     *      invalidMessage= "Valeur non valide",
     * )
     */
    protected $nbAgentsEncadresC;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min = 0,
     *      max = 1000,
     *      minMessage = "Valeur non valide",
     *      maxMessage = "Valeur non valide",
     *      invalidMessage= "Valeur non valide",
     * )
     */
    protected $nbAgentsEncadres;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Length(
     *    min = 2,
     *    max = 50,
     *    minMessage = "Le nom d'usage doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le nom d'usage ne doit pas faire plus de {{ limit }} caractères"
     * )
     */
    protected $nomNaissanceShd;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Length(
     *    min = 2,
     *    max = 50,
     *    minMessage = "Le nom marital doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le nom marital ne doit pas faire plus de {{ limit }} caractères"
     * )
     */
    protected $nomMaritalShd;

    /**
     * @ORM\Column(type="string")
     * @Assert\Length(
     *    min = 2,
     *    max = 50,
     *    minMessage = "Le prénom doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le prénom ne doit pas faire plus de {{ limit }} caractères"
     * )
     */
    protected $prenomShd;

    /**
     * @ORM\Column(type="string")
     * @Assert\Length(
     *    max = 255,
     *    maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $posteOccupeShd;

    /**
     * @ORM\Column(type="string")
     */
    protected $motifAbsenceEntretien;

    /**
     * @ORM\Column(type="string")
     */
    protected $motifAbsenceAgent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\DateTime(format="d/m/Y", message = "Date d'entrée dans le poste non valide. Le format attendu est JJ/MM/AAAA", groups={"importCSV", "Default"})
     */
    protected $dateEntretien;

    /**
     * @ORM\Column(type="string")
     * @Assert\Length(
     *    min = 2,
     *    max = 50,
     *    minMessage = "Le nom d'usage doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le nom d'usage ne doit pas faire plus de {{ limit }} caractères"
     * )
     */
    protected $nomUsageShd;


    // ############################################################################################################

    public function initialiser(Agent $agent, $em)
    {
        $this->initialiserParent($agent, $em);

        $defaultNomAgent = ($agent->getNom())? $agent->getNom() : $agent->getNomNaissance();
        $this->setNomNaissance($defaultNomAgent);
        $this->setNomMarital($agent->getNomMarital());
        $this->setPrenom($agent->getPrenom());

        $this->setTitulaire($agent->isTitulaire());

        $this->setCorps($this->getCorps());
        $this->setGrade($this->getGrade());


        if ($agent->getShd()) {
            $this->setPrenomShd($agent->getShd()->getPrenom());
            $this->setNomNaissanceShd($agent->getShd()->getNomNaissance());
            $this->setNomMarital($agent->getShd()->getNomMarital());
//            $this->setCorpsShd($agent->getShd()->getCorps());
//            $this->setGradeShd($agent->getShd()->getGrade());
            $this->setPosteOccupeShd($agent->getShd()->getPosteOccupe());
//            $this->setDateEntreePosteOccupeShd($agent->getShd()->getDateEntreePosteOccupe());
        }

    }

    public function __construct()
    {
        parent::init();
    }

    /**
     * @return the string
     */
    public function getNomUsage()
    {
        return $this->nomUsage;
    }

    /**
     * @param $nomUsage
     *
     * @return CrepMj02
     */
    public function setNomUsage($nomUsage)
    {
        $this->nomUsage = $nomUsage;

        return $this;
    }

    /**
     * @return the string
     */
    public function getNomNaissance()
    {
        return $this->nomNaissance;
    }

    /**
     * @param $nomNaissance
     *
     * @return $this
     */
    public function setNomNaissance($nomNaissance)
    {
        $this->nomNaissance = $nomNaissance;

        return $this;
    }

    /**
     * Actualisation de données Shd
     */
    public function actualiserDonneesShd()
    {
        $shd = $this->getAgent()->getShd();

        if ($shd) {
            $this
                ->setNomNaissanceShd($shd->getNomNaissance())
//                ->setNomMarital($shd->getNomMarital())
                ->setPrenomShd($shd->getPrenom())
                ->setPosteOccupeShd($shd->getPosteOccupe());
//                ->setAffectationShd($shd->getAffectation());
        } else {
            $this
                ->setNomNaissanceShd(null)
                ->setPrenomShd(null)
                ->setPosteOccupeShd(null)
                ->setAffectationShd(null);
        }
    }






    public function confidentialisationChampsShd()
    {
        // TODO: Implement confidentialisationChampsShd() method.
    }

    public function confidentialisationChampsAgent()
    {
        // TODO: Implement confidentialisationChampsAgent() method.
    }

    public function confidentialisationChampsAgentAvantNotification()
    {
        // TODO: Implement confidentialisationChampsAgentAvantNotification() method.
    }

    public function confidentialisationChampsAh()
    {
        // TODO: Implement confidentialisationChampsAh() method.
    }

    /**
     * Set nomMarital.
     *
     * @param string $nomMarital
     *
     * @return $this
     */
    public function setNomMarital($nomMarital)
    {
        $this->nomMarital = $nomMarital;

        return $this;
    }

    /**
     * Get nomMarital.
     *
     * @return string
     */
    public function getNomMarital()
    {
        return $this->nomMarital;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return bool
     */
    public function getTitulaire()
    {
        return $this->titulaire;
    }

    /**
     * @param $titulaire
     * @return $this
     */
    public function setTitulaire($titulaire)
    {
        $this->titulaire = $titulaire;

        return $this;
    }

    /**
     * @return string
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * @param string $grade
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;
    }

    /**
     * @return string
     */
    public function getCorps()
    {
        return $this->corps;
    }

    /**
     * @param string $corps
     */
    public function setCorps($corps)
    {
        $this->corps = $corps;
    }

    /**
     * @return string
     */
    public function getPosteOccupe()
    {
        return $this->posteOccupe;
    }

    /**
     * @param $posteOccupe
     * @return $this
     */
    public function setPosteOccupe($posteOccupe)
    {
        $this->posteOccupe = $posteOccupe;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateEntreePosteOccupe()
    {
        return $this->dateEntreePosteOccupe;
    }

    /**
     * @param $dateEntreePosteOccupe
     * @return $this
     */
    public function setDateEntreePosteOccupe($dateEntreePosteOccupe)
    {
        $this->dateEntreePosteOccupe = Converter::convertDate($dateEntreePosteOccupe);
        return $this;
    }

    /**
     * @return bool
     */
    public function isActiviteEncadrement()
    {
        return $this->activiteEncadrement;
    }

    /**
     * @param bool $activiteEncadrement
     */
    public function setActiviteEncadrement($activiteEncadrement)
    {
        $this->activiteEncadrement = $activiteEncadrement;
    }

    /**
     * @return mixed
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * @param mixed $direction
     */
    public function setDirection($direction)
    {
        $this->direction = $direction;
    }

    /**
     * @return mixed
     */
    public function getDepartement()
    {
        return $this->departement;
    }

    /**
     * @param mixed $departement
     */
    public function setDepartement($departement)
    {
        $this->departement = $departement;
    }

    /**
     * @return mixed
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param mixed $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }

    /**
     * @return int
     */
    public function getNbAgentsEncadresA()
    {
        return $this->nbAgentsEncadresA;
    }

    /**
     * @param int $nbAgentsEncadresA
     */
    public function setNbAgentsEncadresA($nbAgentsEncadresA)
    {
        $this->nbAgentsEncadresA = $nbAgentsEncadresA;
    }

    /**
     * @return int
     */
    public function getNbAgentsEncadresB()
    {
        return $this->nbAgentsEncadresB;
    }

    /**
     * @param int $nbAgentsEncadresB
     */
    public function setNbAgentsEncadresB($nbAgentsEncadresB)
    {
        $this->nbAgentsEncadresB = $nbAgentsEncadresB;
    }

    /**
     * @return int
     */
    public function getNbAgentsEncadresC()
    {
        return $this->nbAgentsEncadresC;
    }

    /**
     * @param int $nbAgentsEncadresC
     */
    public function setNbAgentsEncadresC($nbAgentsEncadresC)
    {
        $this->nbAgentsEncadresC = $nbAgentsEncadresC;
    }

    /**
     * @return int
     */
    public function getNbAgentsEncadres()
    {
        return $this->nbAgentsEncadres;
    }

    /**
     * @param int $nbAgentsEncadres
     */
    public function setNbAgentsEncadres($nbAgentsEncadres)
    {
        $this->nbAgentsEncadres = $nbAgentsEncadres;
    }

    /**
     * @return mixed
     */
    public function getNomNaissanceShd()
    {
        return $this->nomNaissanceShd;
    }

    /**
     * @param mixed $nomNaissanceShd
     */
    public function setNomNaissanceShd($nomNaissanceShd)
    {
        $this->nomNaissanceShd = $nomNaissanceShd;
    }

    /**
     * @return mixed
     */
    public function getNomMaritalShd()
    {
        return $this->nomMaritalShd;
    }

    /**
     * @param mixed $nomMaritalShd
     */
    public function setNomMaritalShd($nomMaritalShd)
    {
        $this->nomMaritalShd = $nomMaritalShd;
    }

    /**
     * @return mixed
     */
    public function getPrenomShd()
    {
        return $this->prenomShd;
    }

    /**
     * @param $prenomShd
     * @return $this
     */
    public function setPrenomShd($prenomShd)
    {
        $this->prenomShd = $prenomShd;
        return $this;
    }

    /**
     * @return string
     */
    public function getPosteOccupeShd()
    {
        return $this->posteOccupeShd;
    }

    /**
     * @param string $posteOccupeShd
     */
    public function setPosteOccupeShd($posteOccupeShd)
    {
        $this->posteOccupeShd = $posteOccupeShd;
    }

    /**
     * @return mixed
     */
    public function getDirectionShd()
    {
        return $this->directionShd;
    }

    /**
     * @param mixed $directionShd
     */
    public function setDirectionShd($directionShd)
    {
        $this->directionShd = $directionShd;
    }

    /**
     * @return mixed
     */
    public function getDepartementShd()
    {
        return $this->departementShd;
    }

    /**
     * @param mixed $departementShd
     */
    public function setDepartementShd($departementShd)
    {
        $this->departementShd = $departementShd;
    }

    /**
     * @return mixed
     */
    public function getServiceShd()
    {
        return $this->serviceShd;
    }

    /**
     * @param mixed $serviceShd
     */
    public function setServiceShd($serviceShd)
    {
        $this->serviceShd = $serviceShd;
    }

    /**
     * @return mixed
     */
    public function getMotifAbsenceEntretien()
    {
        return $this->motifAbsenceEntretien;
    }

    /**
     * @param mixed $motifAbsenceEntretien
     */
    public function setMotifAbsenceEntretien($motifAbsenceEntretien)
    {
        $this->motifAbsenceEntretien = $motifAbsenceEntretien;
    }

    /**
     * @return mixed
     */
    public function getMotifAbsenceAgent()
    {
        return $this->motifAbsenceAgent;
    }

    /**
     * @param mixed $motifAbsenceAgent
     */
    public function setMotifAbsenceAgent($motifAbsenceAgent)
    {
        $this->motifAbsenceAgent = $motifAbsenceAgent;
    }

    /**
     * @return \DateTime
     */
    public function getDateEntretien()
    {
        return $this->dateEntretien;
    }

    /**
     * @param \DateTime $dateEntretien
     */
    public function setDateEntretien($dateEntretien)
    {
        $this->dateEntretien = $dateEntretien;
    }
}
