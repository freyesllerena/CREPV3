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
     *    minMessage = "Le nom de naissance doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le nom de naissance ne doit pas faire plus de {{ limit }} caractères"
     * )
     */
    protected $nomNaissance;

    /**
     * @ORM\Column(type="string")
     * @Assert\Length(
     *    min = 2,
     *    max = 50,
     *    minMessage = "Le nom de naissance doit faire au moins {{ limit }} caractères",
     *    maxMessage = "Le nom de naissance ne doit pas faire plus de {{ limit }} caractères"
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


//    /**
//     * @ORM\Column(type="string")
//     * @Assert\Length(
//     *    max = 255,
//     *    maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
//     * )
//     */
//    protected $direction;
//
//    /**
//     * @ORM\Column(type="string")
//     * @Assert\Length(
//     *    max = 255,
//     *    maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
//     * )
//     */
//    protected $departement;
//
//    /**
//     * @ORM\Column(type="string")
//     * @Assert\Length(
//     *    max = 255,
//     *    maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
//     * )
//     */
//    protected $service;
//
//    /**
//     * @var int
//     *
//     * @ORM\Column(type="integer")
//     * @Assert\Range(
//     *      min = 0,
//     *      max = 1000,
//     *      minMessage = "Valeur non valide",
//     *      maxMessage = "Valeur non valide",
//     *      invalidMessage= "Valeur non valide",
//     * )
//     */
//    protected $nbAgentsEncadresA;
//
//    /**
//     * @var int
//     *
//     * @ORM\Column(type="integer")
//     * @Assert\Range(
//     *      min = 0,
//     *      max = 1000,
//     *      minMessage = "Valeur non valide",
//     *      maxMessage = "Valeur non valide",
//     *      invalidMessage= "Valeur non valide",
//     * )
//     */
//    protected $nbAgentsEncadresB;
//
//    /**
//     * @var int
//     *
//     * @ORM\Column(type="integer")
//     * @Assert\Range(
//     *      min = 0,
//     *      max = 1000,
//     *      minMessage = "Valeur non valide",
//     *      maxMessage = "Valeur non valide",
//     *      invalidMessage= "Valeur non valide",
//     * )
//     */
//    protected $nbAgentsEncadresC;
//
//    /**
//     * @var int
//     *
//     * @ORM\Column(type="integer")
//     * @Assert\Range(
//     *      min = 0,
//     *      max = 1000,
//     *      minMessage = "Valeur non valide",
//     *      maxMessage = "Valeur non valide",
//     *      invalidMessage= "Valeur non valide",
//     * )
//     */
//    protected $nbAgentsEncadres;
//
//    /**
//     * @var boolean
//     *
//     * @ORM\Column(type="boolean", nullable=true)
//     *
//     */
//    protected $activiteEncadrement;
//
//    /**
//     * @var \DateTime
//     *
//     * @ORM\Column(type="date", nullable=true)
//     * @Assert\DateTime(format="d/m/Y", message = "Date d'entrée dans le poste non valide. Le format attendu est JJ/MM/AAAA", groups={"importCSV", "Default"})
//     */
//    protected $dateEntreePosteOccupe;
//
//    /**
//     * @ORM\Column(type="string")
//     * @Assert\Length(
//     *    min = 2,
//     *    max = 50,
//     *    minMessage = "Le nom d'usage doit faire au moins {{ limit }} caractères",
//     *    maxMessage = "Le nom d'usage ne doit pas faire plus de {{ limit }} caractères"
//     * )
//     */
//    protected $nomNaissanceShd;
//
//    /**
//     * @ORM\Column(type="string")
//     * @Assert\Length(
//     *    min = 2,
//     *    max = 50,
//     *    minMessage = "Le nom d'usage doit faire au moins {{ limit }} caractères",
//     *    maxMessage = "Le nom d'usage ne doit pas faire plus de {{ limit }} caractères"
//     * )
//     */
//    protected $nomMaritalShd;
//
//    /**
//     * @ORM\Column(type="string")
//     * @Assert\Length(
//     *    min = 2,
//     *    max = 50,
//     *    minMessage = "Le prénom doit faire au moins {{ limit }} caractères",
//     *    maxMessage = "Le prénom ne doit pas faire plus de {{ limit }} caractères"
//     * )
//     */
//    protected $prenomShd;



    // ############################################################################################################

    public function initialiser(Agent $agent, $em)
    {
        $this->initialiserParent($agent, $em);


        $this->setPrenom($agent->getPrenom());
        $this->setNomNaissance($this->getNomNaissance());
        $this->setNomMarital($this->getNomMarital());

        $this->setCorps($this->getCorps());
        $this->setGrade($this->getGrade());



    }


//    public function __construct()
//    {
//        parent::init();
//    }

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
     * @return CrepMj01
     */
    public function setNomNaissance($nomNaissance)
    {
        $this->nomNaissance = $nomNaissance;

        return $this;
    }


    /**
     * Méthode appelée lors d'un rattachement d'un nouveau N+1.
     *
     * Actualisation de données Shd
     */
    public function actualiserDonneesShd()
    {
        $shd = $this->getAgent()->getShd();

        if ($shd) {
            $this
                ->setNomNaissanceShd($shd->getNom())
                ->setPrenomShd($shd->getPrenom());
//                ->setPosteOccupeShd($shd->getPosteOccupe())
//                ->setAffectationShd($shd->getAffectation());
        } else {
            $this
//                ->setNomUsageShd(null)
                ->setPrenomShd(null);
            //                ->setPosteOccupeShd(null)
//                ->setAffectationShd(null);
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
     * @return mixed
     */
    public function getNomMarital()
    {
        return $this->nomMarital;
    }

    /**
     * @param mixed $nomMarital
     */
    public function setNomMarital($nomMarital)
    {
        $this->nomMarital = $nomMarital;
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
    public function getNomNaissanceSdh()
    {
        return $this->nomNaissanceShd;
    }

    /**
     * @param $nomNaissanceShd
     * @return $this
     */
    public function setNomNaissanceShd($nomNaissanceShd)
    {
        $this->nomNaissanceShd = $nomNaissanceShd;
        return $this;
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
}
