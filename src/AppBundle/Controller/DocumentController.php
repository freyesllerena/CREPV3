<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Psr\Log\LoggerInterface;

class DocumentController extends Controller
{
    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function getFileAction($id, $checksum, LoggerInterface $logger)
    {
        $em = $this->getDoctrine()->getManager();

        /* @var $document Document */
        $document = $em->getRepository('AppBundle:Document')->findOneDocumentBy($id, $checksum);

        if (!$document) {
            $message = 'Aucun document id='.$id.' checksum='.$checksum;
            $logger->critical($message);
            throw $this->createNotFoundException($message);
        }

        $filename = $document->getWebPath();

        return new Response(
            file_get_contents($filename),

            200,
                array('Content-Type' => 'application/xls',
                        'Content-Disposition' => 'attachment; filename="'.$document->getNom().'"',
                )
        );
    }
}
