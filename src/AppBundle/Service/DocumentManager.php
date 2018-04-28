<?php

namespace AppBundle\Service;

use AppBundle\Entity\Document;
use Symfony\Component\HttpFoundation\File\File;

class DocumentManager extends BaseManager
{
    /**
     * Cette fonction retourne un document à partir d'un filePath passé en paramètre (créer un document dans la base,
     * si on n'a pas déjà un doc
     * avec le même checksum (calculé avec md5_file).
     * Si un doc avec le même checksum existe, on le retourne (on ne crée pas un nouveau doc ).
     *
     * @param File
     *
     * @return Document
     */
    // 	public function createDocumentFromFilePath($filePath) {
    // 		$documentRepository = $this->em->getRepository("BACBundle:Document");

    // 		// génére le checksum du document en paramètre
    // 		$checksum = md5_file($filePath);

    // 		$documentFounded = $documentRepository->findOneDocumentByChecksum($checksum);

    // 		// si un doc avec le même checksum existe, on le retourne
    // 		if ($documentFounded !== null) {
    // 			return $documentFounded ;
    // 		}

    // 		// sinon, on crée un nouveau document
    // 		$document = new Document();

    // 		$document->setChecksum($checksum);

    // 		// crée un fichier à partir du filePath
    // 		$file = new File($filePath);

    // 		$document->setFile($file);

    // 		// enregitre le document dans la base
    // 		$this->em->persist($document);
    // 		$this->em->flush();

    // 		return $document;
    // 	}

    /**
     * Cette fonction permet de supprimer les documents (array) passés en paramètres.
     *
     * @param array
     */
    public function deleteDocuments($documentsAPurger)
    {
        /* @var $documentAPurger Document */
        foreach ($documentsAPurger as $documentAPurger) {
            $this->em->remove($documentAPurger);
        }
    }
}
