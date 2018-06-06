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
     * Vérifier les documents d'une campagne pour éviter d'insérer un même document plusieurs fois
     * dans la base des données.
     *
     * @param Campagne $campagne
     *
     * @return Campagne $campagne
     */
    public function verfierDocuments(Campagne $campagne)
    {
        /* @var $document Document */
        foreach ($campagne->getDocuments() as $document) {
            // Si le document n'a ni ID ni File => c'est un document qu'il faut supprimer car vide
            if (!$document->getId() && !$document->getFile()) {
                $campagne->getDocuments()->removeElement($document);
            }
        }

        return $campagne;
    }

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
