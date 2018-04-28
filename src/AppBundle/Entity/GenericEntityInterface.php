<?php

namespace AppBundle\Entity;

interface GenericEntityInterface
{
    /**
     * Get id.
     *
     * @return int
     */
    public function getId();

    /**
     * Set dateCreation.
     *
     * @param \DateTime $dateCreation
     *
     * @return Campagne1
     */
    public function setDateCreation($dateCreation);

    /**
     * Get dateCreation.
     *
     * @return \DateTime
     */
    public function getDateCreation();

    /**
     * Set dateModification.
     *
     * @param \DateTime $dateModification
     *
     * @return Campagne1
     */
    public function setDateModification($dateModification);

    /**
     * Get dateModification.
     *
     * @return \DateTime
     */
    public function getDateModification();

    /**
     * Set creePar.
     *
     * @param \AppBundle\Entity\Utilisateur $creePar
     *
     * @return GenericEntity
     */
    public function setCreePar(\AppBundle\Entity\Utilisateur $creePar = null);

    /**
     * Get creePar.
     *
     * @return \AppBundle\Entity\Utilisateur
     */
    public function getCreePar();

    /**
     * Set modifiePar.
     *
     * @param \AppBundle\Entity\Utilisateur $modifiePar
     *
     * @return GenericEntity
     */
    public function setModifiePar(\AppBundle\Entity\Utilisateur $modifiePar = null);

    /**
     * Get modifiePar.
     *
     * @return \AppBundle\Entity\Utilisateur
     */
    public function getModifiePar();
}
