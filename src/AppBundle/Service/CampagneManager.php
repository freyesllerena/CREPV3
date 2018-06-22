<?php

namespace AppBundle\Service;

use AppBundle\Entity\Campagne;
use AppBundle\Entity\Document;

class CampagneManager
{
    protected $templating;

    /**
     * @var TokenStorage
     */
    protected $tokenStorage;

    protected $mailer;

    /* @var $personneManager PersonneManager */
    protected $personneManager;

    /**
     * Sauvegarder l'entité.
     *
     * @param Campagne $campagne
     */
    public function sauvegarder(Campagne $campagne)
    {
        $this->em->persist($campagne);
        $this->em->flush();
    }
}
