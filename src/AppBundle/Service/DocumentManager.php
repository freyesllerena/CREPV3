<?php

namespace AppBundle\Service;

use AppBundle\Entity\Document;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Doctrine\ORM\EntityManagerInterface;

class DocumentManager
{
    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * Cette fonction permet de supprimer les documents (array) passés en paramètres.
     *
     * @param array
     */
    public function deleteDocuments($documentsAPurger, $withFlush = false)
    {
        /* @var $documentAPurger Document */
        foreach ($documentsAPurger as $documentAPurger) {
            $this->em->remove($documentAPurger);
        }

        if ($withFlush) {
            $this->em->flush();
        }
    }

    public function getDocument(Document $document)
    {
        $response = new Response(file_get_contents($document->getAbsolutePath()));
        $asciiFileName = mb_convert_encoding($document->getNom(), 'ASCII');

        // Ajout des en-têtes
        $dispositionHeader = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $document->getNom(), $asciiFileName);
        $response->headers->set('Content-Type', mime_content_type($document->getAbsolutePath()));
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Content-Disposition', $dispositionHeader);
        $response->headers->set('Set-Cookie', 'fileDownload=true; path=/');

        return $response;
    }
}
