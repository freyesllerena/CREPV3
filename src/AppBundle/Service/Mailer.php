<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Mailer\Mailer as FOSMailer;
use AppBundle\Entity\Message;
use AppBundle\Entity\Utilisateur;

abstract class Mailer extends FOSMailer
{
    protected $mailer;
    protected $container;
    protected $from;
    protected $reply;
    protected $companyName;
    protected $appName;

    protected function sendMessage(Utilisateur $to, $subject, $body, $piecesJointes = [], $flush = true)
    {
        /* @var $message Message */
        $message = new Message();

        // $from = $this->em->getRepository("BACBundle:Utilisateur")->findOneBy(array("email"=>"noreply-signac@finances.gouv.fr"));

        // Récupérer la balise table du body, pour ne pas stocker les balises: doctype, les head et body en base, ce qui qui crée des régression de mise en forme:
        // Récupérer la chaine de caractère qui commence par <table :
        $table = strstr($body, '<table');
        // Retirer les balises fermantes body et html de $table
        // $table = "<table ....> ..... </table>
        $table = strstr($table, '</body>', true);

        $message->setDestinataire($to)
    // 	    ->setExpediteur($from)
            ->setObjetMessage($subject)
            ->setContenuMessage($table);

        foreach ($piecesJointes as $pieceJointe) {
            $message->addPieceJointe($pieceJointe);
        }

        if ($flush) {
            $this->em->persist($message);
            $this->em->flush();
        }

        $mail = new \Swift_Message();
        $mail
            ->setFrom($this->from, $this->appName)
            ->setTo($to->getEmail())
            ->setSubject('['.$this->appName.'] '.$subject)
            ->setBody($body)
            ->setReplyTo($this->reply, $this->appName)
            ->setContentType('text/html');

        if ($piecesJointes) {
            foreach ($piecesJointes as $pieceJointe) {
                $mail->attach(\Swift_Attachment::fromPath($pieceJointe));
            }
        }

        $this->mailer->send($mail);

        return $message;
    }
}
