<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Message.
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MessageRepository")
 */
class Message extends GenericEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="Utilisateur", cascade={"persist"})
     * @ORM\JoinColumn(name="destinataire", referencedColumnName="id", nullable=false)
     */
    private $destinataire;

    /**
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumn(name="expediteur", referencedColumnName="id", nullable=true)
     */
    private $expediteur;

    /**
     * @var string
     *
     * @ORM\Column(name="objet", type="string")
     */
    private $objetMessage;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text")
     */
    private $contenuMessage;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Document", cascade={"persist"})
     */
    private $piecesJointes; //Dans une relation ManyToMany, on ajoute l'attribut d'association dans l'entité proriétaire

    /**
     * @var bool
     *
     * @ORM\Column(name="favoris", type="boolean")
     */
    private $favoris;

    /**
     * @var bool
     *
     * @ORM\Column(name="lu", type="boolean")
     */
    private $lu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_lecture", type="datetime", nullable=true)
     */
    private $dateLecture;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_envoi", type="datetime")
     */
    private $dateEnvoi;

    /**
     * @var bool
     *
     * @ORM\Column(name="supprime", type="boolean")
     */
    private $supprime;

    public function __construct()
    {
        //Initialiser un message
        $this->piecesJointes = new ArrayCollection();
        $this->dateEnvoi = new \DateTime();
        $this->favoris = 0;
        $this->supprime = 0;
        $this->lu = 0;
    }

    /**
     * Set destinataire.
     *
     * @param Utilisateur $destinataire
     *
     * @return Message
     */
    public function setDestinataire($destinataire)
    {
        $this->destinataire = $destinataire;

        return $this;
    }

    /**
     * Get destinataire.
     *
     * @return Utilisateur
     */
    public function getDestinataire()
    {
        return $this->destinataire;
    }

    /**
     * Set expediteur.
     *
     * @param Utilisateur $expediteur
     *
     * @return Message
     */
    public function setExpediteur($expediteur)
    {
        $this->expediteur = $expediteur;

        return $this;
    }

    /**
     * Get expediteur.
     *
     * @return Utilisateur
     */
    public function getExpediteur()
    {
        return $this->expediteur;
    }

    /**
     * Set objetMessage.
     *
     * @param string $objetMessage
     *
     * @return Message
     */
    public function setObjetMessage($objetMessage)
    {
        $this->objetMessage = $objetMessage;

        return $this;
    }

    /**
     * Get objetMessage.
     *
     * @return string
     */
    public function getObjetMessage()
    {
        return $this->objetMessage;
    }

    /**
     * Set contenuMessage.
     *
     * @param string $contenuMessage
     *
     * @return Message
     */
    public function setContenuMessage($contenuMessage)
    {
        $this->contenuMessage = $contenuMessage;

        return $this;
    }

    /**
     * Get contenuMessage.
     *
     * @return string
     */
    public function getContenuMessage()
    {
        return $this->contenuMessage;
    }

    /**
     * Set favoris.
     *
     * @param bool $favoris
     *
     * @return Message
     */
    public function setFavoris($favoris)
    {
        $this->favoris = $favoris;

        return $this;
    }

    /**
     * Get favoris.
     *
     * @return bool
     */
    public function getFavoris()
    {
        return $this->favoris;
    }

    /**
     * Set lu.
     *
     * @param bool $lu
     *
     * @return Message
     */
    public function setLu($lu)
    {
        $this->lu = $lu;

        return $this;
    }

    /**
     * Get lu.
     *
     * @return bool
     */
    public function getLu()
    {
        return $this->lu;
    }

    /**
     * Set dateLecture.
     *
     * @param \DateTime $dateLecture
     *
     * @return Message
     */
    public function setDateLecture($dateLecture)
    {
        $this->dateLecture = $dateLecture;

        return $this;
    }

    /**
     * Get dateLecture.
     *
     * @return \DateTime
     */
    public function getDateLecture()
    {
        return $this->dateLecture;
    }

    /**
     * Set dateEnvoi.
     *
     * @param \DateTime $dateEnvoi
     *
     * @return Message
     */
    public function setDateEnvoi($dateEnvoi)
    {
        $this->dateEnvoi = $dateEnvoi;

        return $this;
    }

    /**
     * Get dateEnvoi.
     *
     * @return \DateTime
     */
    public function getDateEnvoi()
    {
        return $this->dateEnvoi;
    }

    /**
     * Set supprime.
     *
     * @param bool $supprime
     *
     * @return Message
     */
    public function setSupprime($supprime)
    {
        $this->supprime = $supprime;

        return $this;
    }

    /**
     * Get supprime.
     *
     * @return bool
     */
    public function getSupprime()
    {
        return $this->supprime;
    }

    /**
     * Get piecesJointes.
     *
     * @return array
     */
    public function getPiecesJointes()
    {
        return $this->piecesJointes;
    }

    /**
     * Set piecesJointes.
     *
     * @param array $piecesJointes
     *
     * @return Message
     */
    public function setPiecesJointes($piecesJointes)
    {
        $this->piecesJointes = $piecesJointes;

        return $this;
    }

    /**
     * add piecesJointes  Ajouter une pièce jointe.
     *
     * @param Document $piecesJointe
     *
     * @return Message
     */
    public function addPieceJointe(Document $piecesJointe)
    {
        $this->piecesJointes[] = $piecesJointe;

        return $this;
    }

    public function getObjetTronquee()
    {
        $longueurMax = 42;

        if (strlen($this->objetMessage) <= $longueurMax) {
            return $this->objetMessage;
        }

        return mb_substr($this->objetMessage, 0, $longueurMax, 'UTF-8').'...';
    }
}
