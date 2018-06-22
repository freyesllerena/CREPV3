<?php

// src/AppBundle/Entity/Utilisateur.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use AppBundle\Util\Util;

/**
 * @ORM\Table(name="utilisateur", indexes={ @ORM\Index(columns={"email"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UtilisateurRepository")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(fields={"email"}, message="Un utilisateur avec cet email existe déjà.")
 * @ORM\AttributeOverrides({
 *     @ORM\AttributeOverride(name="password",
 *          column=@ORM\Column(
 *              name     = "password",
 *              type     = "string",
 *              nullable = true
 *          )
 *      )
 * })
 */
class Utilisateur extends BaseUser implements GenericEntityInterface, PersonneInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le nom doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le nom ne doit pas faire plus de {{ limit }} caractères"
     * )
     */
    protected $nom = '';

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le prénom doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le prénom ne doit pas faire plus de {{ limit }} caractères"
     * )
     */
    protected $prenom = '';

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Choice(choices = {"m.", "mme"}, message = "Civilité non valide. Valeurs acceptées : 'M.', 'Mme'")
     */
    protected $civilite = '';

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\Length(
     *      max = 30,
     *      maxMessage = "Ce champ ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    protected $titre;
    
    /**
     * @ORM\Column(type="integer", name="nb_connexion_ko", nullable=true)
     */
    protected $nbConnexionKO;

    /**
     * @var array
     * @Assert\NotBlank(message = "Un rôle est requis au minimum")
     */
    protected $roles;

    /**
     * @var string
     */
    protected $plainPassword;

    ////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * @ORM\Column(type="boolean", name="locked", nullable=true)
     */
    protected $locked;
    /////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ministere")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ministere;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime")
     */
    private $dateCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_modification", type="datetime")
     */
    private $dateModification;

    /**
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumn(name="cree_par_id", referencedColumnName="id")
     */
    private $creePar;

    /**
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumn(name="modifie_par_id", referencedColumnName="id")
     */
    private $modifiePar;

    private $menu;

    public function __construct()
    {
        parent::__construct();
        $this->nbConnexionKO = 0;
        $this->locked = false;
        $this->setPasswordRequestedAt(new \DateTime());
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get nom.
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Get prenom.
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Get civilite.
     *
     * @return string
     */
    public function getCivilite()
    {
        return $this->civilite;
    }

    public function getTitre()
    {
    	return $this->titre;
    }
    
    public function setTitre($titre)
    {
    	$this->titre = $titre;
    
    	return $this;
    }
    
    /**
     * Get nbConnexionKO.
     *
     * @return int
     */
    public function getNbConnexionKO()
    {
        return $this->nbConnexionKO;
    }

    /**
     * Set nom.
     *
     * @param string $nom
     *
     * @return Utilisateur
     */
    public function setNom($nom)
    {
        // Nom en majuscules
        $this->nom = strtoupper($nom);

        return $this;
    }

    /**
     * Set prenom.
     *
     * @param string $prenom
     *
     * @return Utilisateur
     */
    public function setPrenom($prenom)
    {
        // Prenom chaque mot commance par une majuscule
        $this->prenom = ucwords(mb_strtolower($prenom, 'UTF-8'));

        return $this;
    }

    /**
     * Set civilite.
     *
     * @param string $civilite
     *
     * @return Utilisateur
     */
    public function setCivilite($civilite)
    {
        $this->civilite = $civilite;

        return $this;
    }

    /**
     * Set nbConnexionKO.
     *
     * @param int $nbConnexionKO
     *
     * @return Utilisateur
     */
    public function setNbConnexionKO($nbConnexionKO)
    {
        $this->nbConnexionKO = $nbConnexionKO;

        return $this;
    }

    /**
     * Set ministere.
     *
     * @param Ministere $ministere
     *
     * @return Utilisateur
     */
    public function setMinistere(Ministere $ministere)
    {
        $this->ministere = $ministere;

        return $this;
    }

    /**
     * Get ministere.
     *
     * @return Ministere
     */
    public function getMinistere()
    {
        return $this->ministere;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return Utilisateur
     */
    public function setEmail($email)
    {
        parent::setEmail(mb_strtolower($email, 'UTF-8'));

        return $this;
    }

    /**
     * Set dateCreation.
     *
     * @param \DateTime $dateCreation
     *
     * @return Utilisateur
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation.
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set dateModification.
     *
     * @param \DateTime $dateModification
     *
     * @return Utilisateur
     */
    public function setDateModification($dateModification)
    {
        $this->dateModification = $dateModification;

        return $this;
    }

    /**
     * Get dateModification.
     *
     * @return \DateTime
     */
    public function getDateModification()
    {
        return $this->dateModification;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedUserName()
    {
        $this->setUsername($this->email);
    }

    public function getRoleImpression($role)
    {
        switch ($role) {
            case 'ROLE_ADMIN':
                return 'Administrateur';
            case 'ROLE_ADMIN_MIN':
                return 'Administrateur ministétiel';
            case 'ROLE_DGAFP':
                return 'DGAFP';
            case 'ROLE_PNC':
                return 'Pilote national de campagne';
            case 'ROLE_RLC':
                return 'Responsable local de campagne';
            case 'ROLE_BRHP':
                return 'Bureau RH de proximité';
            case 'ROLE_GESTIONNAIRE_RECOURS':
                return 'Gestionnaire de recours';
            case 'ROLE_CONSEILLER_FORMATION':
                return 'Conseiller de formation';
            case 'ROLE_SHD':
                return 'N+1';
            case 'ROLE_AH':
                return 'N+2';
            case 'ROLE_AGENT':
                return 'Agent';

            default:
                return 'Rôle "Utilisateur" ou non reconnu';
        }
    }

    public function removeAllRoles()
    {
        foreach ($this->getRoles() as $role) {
            $this->removeRole($role);
        }
    }

    /**
     * Set creePar.
     *
     * @param \AppBundle\Entity\Utilisateur $creePar
     *
     * @return GenericEntity
     */
    public function setCreePar(\AppBundle\Entity\Utilisateur $creePar = null)
    {
        $this->creePar = $creePar;

        return $this;
    }

    /**
     * Get creePar.
     *
     * @return \AppBundle\Entity\Utilisateur
     */
    public function getCreePar()
    {
        return $this->creePar;
    }

    /**
     * Set modifiePar.
     *
     * @param \AppBundle\Entity\Utilisateur $modifiePar
     *
     * @return GenericEntity
     */
    public function setModifiePar(\AppBundle\Entity\Utilisateur $modifiePar = null)
    {
        $this->modifiePar = $modifiePar;

        return $this;
    }

    /**
     * Get modifiePar.
     *
     * @return \AppBundle\Entity\Utilisateur
     */
    public function getModifiePar()
    {
        return $this->modifiePar;
    }

    /**
     * @Assert\Callback(groups={"ResetPassword", "ChangePassword"})
     */
    public function validatePassword(ExecutionContextInterface $context, $payload)
    {
        if (strlen($this->plainPassword) < 8) {
            $context->buildViolation('Votre mot de passe doit être composé d\'au moins 8 caractères')
            ->atPath('plainPassword')
            ->addViolation();
        } elseif (!$this->isPasswordValid($this->plainPassword)) {
            $context->buildViolation('Votre mot de passe doit être composé d\'au moins : une majuscule, une minuscule, un chiffre et un caractère spécial.')
            ->atPath('plainPassword')
            ->addViolation();
        }
    }

    /**
     * @Assert\Callback()
     */
    public function validateEmail(ExecutionContextInterface $context, $payload)
    {
        if (!$this->email) {
            return;
        }

        if (!Util::validerEmail($this->email)) {
            $context->buildViolation('L\'email n\'est pas valide')
            ->atPath('email')
            ->addViolation();
        }
    }

    public function isAccountNonLocked()
    {
        return !$this->locked;
    }

    public function isLocked()
    {
        return !$this->isAccountNonLocked();
    }

    public function setLocked($boolean)
    {
        $this->locked = $boolean;

        return $this;
    }

    public function isAccountEnabled()
    {
        return $this->enabled;
    }

    public function setEnabled($boolean)
    {
        $this->enabled = $boolean;

        return $this;
    }

    private function generatePassword($length = 8, $upp = 1, $low = 5, $num = 1, $spec = 1)
    {
        if ($upp + $low + $num + $spec > $length) {
            throw new \Exception('Vous devez péciser une logueur plus importante.');
        }

        $chiffres = '0123456789';
        $minuscules = 'abcdefghijklmnopqrstuvwxyz';
        $majuscules = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $caracteresSpeciaux = '!:;,.?';

        $password = '';
        for ($i = 0; $i < $upp; ++$i) {
            $password = $password.$majuscules[mt_rand(0, strlen($majuscules) - 1)];
        }

        for ($i = 0; $i < $low; ++$i) {
            $password = $password.$minuscules[mt_rand(0, strlen($minuscules) - 1)];
        }

        for ($i = 0; $i < $num; ++$i) {
            $password = $password.$chiffres[mt_rand(0, strlen($chiffres) - 1)];
        }

        for ($i = 0; $i < $spec; ++$i) {
            $password = $password.$caracteresSpeciaux[mt_rand(0, strlen($caracteresSpeciaux) - 1)];
        }

        return $password;
    }

    private function isPasswordValid($plainPassword)
    {
        if (!preg_match('#[A-Z]#', $plainPassword)) {
            return false;
        }

        if (!preg_match('#[a-z]#', $plainPassword)) {
            return false;
        }

        if (!preg_match('#[0-9]#', $plainPassword)) {
            return false;
        }

        if (!preg_match('#[^0-9A-Za-z]#', $plainPassword)) {
            return false;
        }

        return true;
    }
}
