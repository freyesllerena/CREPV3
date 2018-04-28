<?php

namespace AppBundle\Service;

use AppBundle\Entity\Agent;
use AppBundle\EnumTypes\EnumStatutCrep;
use AppBundle\Entity\Crep;
use AppBundle\Util\Util;
use AppBundle\Entity\CampagneBrhp;
use AppBundle\Entity\ModeleCrep;
use AppBundle\Repository\CrepRepository;
use AppBundle\Repository\AgentRepository;
use AppBundle\Entity\Campagne;
use AppBundle\Entity\Perimetre;
use Symfony\Bundle\TwigBundle\TwigEngine;
use AppBundle\Entity\Document;
use Symfony\Component\HttpFoundation\File\File;
use AppBundle\Entity\Recours;
use AppBundle\Service\ModelesCrep\CrepMindef01Manager;
use AppBundle\Service\ModelesCrep\CrepAcManager;
use AppBundle\Service\ModelesCrep\CrepMccManager;
use AppBundle\Service\ModelesCrep\CrepMinefAbcManager;
use AppBundle\Service\ModelesCrep\CrepSclManager;
use AppBundle\Repository\RecoursRepository;
use AppBundle\EnumTypes\EnumTypeRecours;
use AppBundle\Service\ModelesCrep\CrepMso3Manager;
use AppBundle\Entity\Crep\CrepMso3\CrepMso3;
use AppBundle\Service\ModelesCrep\CrepMj01Manager;
use AppBundle\Entity\Crep\CrepMj01\CrepMj01;
use AppBundle\Entity\Crep\CrepMindef01\CrepMindef01;

class CrepManager extends BaseManager
{
    protected $tcpdf;

    protected $confidentialisationManager;

    protected $templating;

    protected $certificat;

    protected $crepMindef01Manager;

    protected $crepAcManager;

    protected $crepMccManager;

    protected $crepMinefAbcManager;

    protected $crepSclManager;

    protected $crepMso3Manager;

    protected $modelesCrepManagers;

    protected $crepMj01Manager;

    public function init(
        $tcpdf,

        $confidentialisationManager,

        TwigEngine $templating,

        $certificat,
                        CrepMindef01Manager $crepMindef01Manager,
                        CrepAcManager $crepAcManager,
                        CrepMccManager $crepMccManager,
                        CrepMinefAbcManager $crepMinefAbcManager,
                        CrepSclManager $crepSclManager,
                        CrepMso3Manager $crepMso3Manager,
                        CrepMj01Manager $crepMj01Manager
            ) {
        $this->tcpdf = $tcpdf;
        $this->confidentialisationManager = $confidentialisationManager;
        $this->templating = $templating;
        $this->certificat = $certificat;
        $this->crepMindef01Manager = $crepMindef01Manager;
        $this->crepAcManager = $crepAcManager;
        $this->crepMccManager = $crepMccManager;
        $this->crepMinefAbcManager = $crepMinefAbcManager;
        $this->crepSclManager = $crepSclManager;
        $this->crepMso3Manager = $crepMso3Manager;
        $this->crepMj01Manager = $crepMj01Manager;

        $this->modelesCrepManagers = [
                'CrepMindef01' => $this->crepMindef01Manager,
                'CrepAc' => $this->crepAcManager,
                'CrepMcc' => $this->crepMccManager,
                'CrepMinefAbc' => $this->crepMinefAbcManager,
                'CrepScl' => $this->crepSclManager,
                'CrepMso3' => $this->crepMso3Manager,
                'CrepMj01' => $this->crepMj01Manager,
        ];
    }

    public function creer(Agent $agent, ModeleCrep $modeleCrep)
    {
        $classe = $modeleCrep->getTypeEntity();

        $classPath = 'AppBundle\Entity\Crep\\'.$classe.'\\'.$classe;

        $crep = new $classPath();

        $crep->setModeleCrep($modeleCrep);
        $agent->setCrep($crep);
        $crep->setAgent($agent);
        $crep->initialiser($agent, $this->em);

        return $crep;
    }

    public function signerShd(Crep $crep)
    {
        $crep->setStatut(EnumStatutCrep::SIGNE_SHD);
        $crep->setDateVisaShd(new \DateTime());
        $crep->setShdSignataire($crep->getShd());

        //Réinitialisation des champs de renvoi (date et motif) de l'agent à null à chaque signature du N+1
        $crep->setDateRenvoiAgent(null);
        $crep->setMotifRenvoiAgent(null);

        //Réinitialisation des champs de renvoi (date et motif) du N+2 à null à chaque signature du N+1
        $crep->setDateRenvoiAh(null);
        $crep->setMotifRenvoiAh(null);

        $this->em->persist($crep);
        $this->em->flush();

        //Notifications au N+1
        $this->appMailer->notifierSignatureShd($crep);
    }

    public function viserAgent(Crep $crep)
    {
        $crep->setStatut(EnumStatutCrep::VISE_AGENT);
        $crep->setDateVisaAgent(new \DateTime());
        $crep->setDateRefusVisa(null);

        $this->em->persist($crep);
        $this->em->flush();

        //Notifications au N+1
        $this->appMailer->notifierVisaAgent($crep);
    }

    public function signerAh(Crep $crep)
    {
        $crep->setStatut(EnumStatutCrep::SIGNE_AH);
        $crep->setDateVisaAh(new \DateTime());
        $crep->setAhSignataire($crep->getAh());

        $this->em->persist($crep);
        $this->em->flush();

        //Notifications au N+1
        $this->appMailer->notifierSignatureAh($crep);
    }

    public function signerDefinitivementAgent(Crep $crep)
    {
        $crep->setStatut(EnumStatutCrep::NOTIFIE_AGENT);
        $crep->setDateNotification(new \DateTime());

        $crepPdf = $this->genererCrepPdf($crep, 'F');
        $crep->setCrepPdf($crepPdf);

        $this->em->persist($crep);

        $this->em->flush();

        //Notifications au N+1
        $this->appMailer->notifierSignatureAgent($crep);
    }

    public function notifierAbsenceVisaAgent(Crep $crep)
    {
        $crep->setNotificationAbsenceVisaAgent(true);
        $this->em->persist($crep);
        $this->em->flush();

        $this->appMailer->notifierAbsenceVisaAgent($crep);
    }

    public function renvoyerAgentShd(Crep $crep)
    {
        $crep->setStatut(EnumStatutCrep::MODIFIE_SHD);
        $crep->setDateRenvoiAgent(new \DateTime());
        //Annulation de la signature du shd
        $crep->setShdSignataire(null);
        $crep->setDateVisaShd(null);

        $this->em->persist($crep);
        $this->em->flush();

        //Notifications mail
        $this->appMailer->notifierRenvoiAgentShd($crep);
    }

    public function renvoyerAhShd(Crep $crep)
    {
        $crep->setStatut(EnumStatutCrep::MODIFIE_SHD);
        $crep->setDateRenvoiAh(new \DateTime());
        $crep->setObservationsAh(null); // Suite au ticket INC0021806
        //Annulation des actions de l'agent
        $crep->setDateVisaAgent(null);
        $crep->setDateRefusVisa(null);

        //Annulation de la signature du shd
        $crep->setShdSignataire(null);
        $crep->setDateVisaShd(null);

        $this->em->persist($crep);
        $this->em->flush();

        //Notifications mail
        $this->appMailer->notifierRenvoieAhShd($crep);
    }

    public function rappelerAgentAh(Crep $crep)
    {
        $crep->setStatut(EnumStatutCrep::VISE_AGENT);
        $crep->setDateVisaAh(null);
        $crep->setAhSignataire(null);

        $this->em->persist($crep);
        $this->em->flush();

        //Notification de l'agent
        $this->appMailer->notifierRappelAgentAh($crep);
    }

    public function refuserVisa(Crep $crep)
    {
        $crep->setStatut(EnumStatutCrep::REFUS_VISA_AGENT);
        $crep->setDateRefusVisa(new \DateTime());

        // On efface l'ensemble des champs (commentaires et observations) rédigés par l'agent
        $crep->confidentialisationChampsAgent();

        $this->em->persist($crep);
        $this->em->flush();

        //Notifications à l'agent et au N+2
        $this->appMailer->notifierRefusVisaAgent($crep);
    }

    public function refuserNotification(Crep $crep)
    {
        $crep->setStatut(EnumStatutCrep::REFUS_NOTIFICATION_AGENT);
        $crep->setDateRefusNotification(new \DateTime());

        // On efface l'ensemble des champs (commentaires et observations) rédigés par l'agent
        $crep->confidentialisationChampsAgentAvantNotification();

        $crepPdf = $this->genererCrepPdf($crep, 'F');
        $crep->setCrepPdf($crepPdf);

        $this->em->persist($crep);
        $this->em->flush();

        //Notifications à l'agent et au N+2
        $this->appMailer->notifierRefusSignatureAgent($crep);
    }

    public function calculIndicateurs(Campagne $campagne, Perimetre $perimetre = null, Agent $shd = null, Agent $ah = null)
    {
        /* @var $crepRepository CrepRepository */
        $crepRepository = $this->em->getRepository('AppBundle:Crep');

        /* @var $agentRepository AgentRepository */
        $agentRepository = $this->em->getRepository('AppBundle:Agent');

        /* @var $recoursRepository RecoursRepository */
        $recoursRepository = $this->em->getRepository('AppBundle:Recours');

        // Tableau qui va contenir les indicateurs à afficher dans le tableau de bord
        $indicateurs = [];

        $indicateurs['nbCrep'] = $agentRepository->getNbAgentsEvaluables($campagne, $perimetre, $shd, $ah);

        $indicateurs['nbCrepSignesShd'] = $crepRepository->getNbCreps($campagne, $perimetre, array(EnumStatutCrep::SIGNE_SHD), $shd, $ah);

        $indicateurs['nbCrepVisesAgent'] = $crepRepository->getNbCreps($campagne, $perimetre, array(EnumStatutCrep::VISE_AGENT), $shd, $ah);

        $indicateurs['nbCrepSignesAh'] = $crepRepository->getNbCreps($campagne, $perimetre, array(EnumStatutCrep::SIGNE_AH), $shd, $ah);

        $indicateurs['nbCrepNotifies'] = $crepRepository->getNbCreps($campagne, $perimetre, array(EnumStatutCrep::NOTIFIE_AGENT), $shd, $ah);

        $indicateurs['nbCrepRefusNotification'] = $crepRepository->getNbCreps($campagne, $perimetre, array(EnumStatutCrep::REFUS_NOTIFICATION_AGENT), $shd, $ah);

        $indicateurs['nbCrepModifieShd'] = $crepRepository->getNbCreps($campagne, $perimetre, array(EnumStatutCrep::MODIFIE_SHD), $shd, $ah);

        $indicateurs['nbCrepRefusVisas'] = $crepRepository->getNbCreps($campagne, $perimetre, array(EnumStatutCrep::REFUS_VISA_AGENT), $shd, $ah);

        $indicateurs['nbCrepCasAbsence'] = $crepRepository->getNbCreps($campagne, $perimetre, array(EnumStatutCrep::CAS_ABSENCE), $shd, $ah);

        $indicateurs['nbCrepNonRenseignes'] = $indicateurs['nbCrep']
                                            - $indicateurs['nbCrepSignesShd']
                                            - $indicateurs['nbCrepVisesAgent']
                                            - $indicateurs['nbCrepSignesAh']
                                            - $indicateurs['nbCrepNotifies']
                                            - $indicateurs['nbCrepRefusNotification']
                                            - $indicateurs['nbCrepModifieShd']
                                            - $indicateurs['nbCrepRefusVisas']
                                            - $indicateurs['nbCrepCasAbsence'];

        /************** Statistiques sur les recours **************/

        $indicateurs['nbTotalRecours'] = $recoursRepository->getNbRecours($campagne, $perimetre, null, $shd, $ah);

        $indicateurs['nbRecoursHierarchique'] = $recoursRepository->getNbRecours($campagne, $perimetre, EnumTypeRecours::RECOURS_HIERARCHIQUE, $shd, $ah);

        $indicateurs['nbRecoursEnCAP'] = $recoursRepository->getNbRecours($campagne, $perimetre, EnumTypeRecours::RECOURS_CAP, $shd, $ah);

        $indicateurs['nbRecoursAuTA'] = $recoursRepository->getNbRecours($campagne, $perimetre, EnumTypeRecours::RECOURS_TRIBUNAL_ADMINISTRATIF, $shd, $ah);

        //@param string $distinctCrep : pour avoir le nombre de CREP en mention de recours
        $indicateurs['nbCrepEnRecours'] = $recoursRepository->getNbRecours($campagne, $perimetre, null, $shd, $ah, true);

        return $indicateurs;
    }

    /**
     * @param Crep   $crep
     * @param string $dest I => Affiche le Crep PDF sur la fenêtre courante
     *                     F => enregistre le Crep PDF sur le disque local
     *                     D => Propose le Crep PDF en téléchargement
     *
     * @return \AppBundle\Entity\Document
     */
    public function genererCrepPdf(Crep $crep, $dest = 'I')
    {
        $pdf = $this->tcpdf->create(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $repertoireVuesCrep = lcfirst(Util::getClassName($crep));
        $vueCrep = $repertoireVuesCrep.'.html.twig';

        $template = 'crep/'.$repertoireVuesCrep.'/'.$vueCrep;

        $utilisateur = $this->securityTokenStorage->getToken()->getUser();

        // Ici nous utilisons le service de confidentialisation du crep en fonction du statut du crep
        $this->confidentialisationManager->confidentialisation($crep, $utilisateur);

        $anneeEvaluation = $crep->getAgent()->getCampagnePnc()->getAnneeEvaluee();

        $pdf->initHeader($crep, $anneeEvaluation);

        // set header and footer fonts
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, 20, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/../Resources/lang/fra.php')) {
            require_once dirname(__FILE__).'/../Resources/lang/fra.php';
            $pdf->setLanguageArray($l);
        }

        $pdf->initFooter($crep, $anneeEvaluation);

        // ---------------------------------------------------------
        // set font
        $pdf->SetFont('dejavusans', '', 10); // Cette police permet l'affichage correctement les cases à cocher

        // add a page
        $pdf->AddPage();

        $content = $this->templating->render($template, array(
                'crep' => $crep,
                'anneeEvaluee' => $anneeEvaluation,
        ));

        $pdf->writeHTML($content, true, false, true, false, '');

        // ---------------------------------------------------------

        // Signature numérique
        if (in_array($crep->getStatut(), array(EnumStatutCrep::NOTIFIE_AGENT, EnumStatutCrep::REFUS_NOTIFICATION_AGENT)) && !$crep->getCrepPdf()) {
            // fichier certificat
            $certificate = dirname(__FILE__).'/../../../../../../tmp/server.crt';

            // openssl req -x509 -nodes -days 365000 -newkey rsa:1024 -keyout private_key.crt -out certificate.crt
            $certificate = 'file://'.realpath('/tmp/certificate.crt');
            //$pricateKey = 'file://'.realpath('/tmp/private_key.crt');
            $certificate = 'file://'.realpath($this->certificat);

            // informations à mettre dans le fichier PDF
            $info = array(
                    'Name' => 'Expérimentation ESTEVE V2',
                    'Location' => 'CISIRH',
                    'Reason' => 'Expérimentation ESTEVE V2',
                    'ContactInfo' => 'innovation.cisirh@finances.gouv.fr',
            );

            // signature du document
            $pdf->setSignature($certificate, $certificate, '', '', 1, $info);
        }

        // ---------------------------------------------------------
        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.

        if ($crep->getId()) {
            $filename = $crep->getPdfFileName();
        } else {
            $filename = $crep->getModeleCrep()->getLibelle().'.pdf';
        }

        switch ($dest) {
            case 'I':
                $pdf->Output($filename, 'I');
                break;

            case 'F':
                $filePath = Document::getRootDir().'/'.$filename;

                // Enregistrement du PDF sur le disque
                $pdf->Output($filePath, 'F');
                $crepPdf = new Document($filename);

                return $crepPdf;
                break;

            case 'D':
                $pdf->Output($filename, 'D');
                exit(); // ce exit() est indispensable pour que le pdf ne soit pas modifié par des entêtes http après sa génération
                break;
            default:
                    throw new \Exception('Le paramètre $dist doit être égal à I, F ou D');
        }
    }

    public function exporterCrepsFinalises($agentsAyantCrepFinalise)
    {
        $zip = new \ZipArchive();

        $zipName = $this->kernelRootDir.'/../var/tmp/';
        $zipName .= 'Documents_'.time().$this->session->getId().'.zip';

        $zip->open($zipName, \ZipArchive::CREATE);

        /* @var $agent Agent */
        foreach ($agentsAyantCrepFinalise as $agent) {
            if ($agent->getCrep()->getCrepPapier()) {
                // CREPs papier
                $crepPath = $agent->getCrep()->getCrepPapier()->getAbsolutePath();
            } else {
                // CREPs finalisés dans ESTEVE
                $crepPath = $agent->getCrep()->getCrepPdf()->getAbsolutePath();
            }

            $sousDossier = 'Autre';
            if ($agent->getCorps()) {
                // remplacement des caractères suivants par "_" : \/:*?"<>|
                // explication
                // 		[] 		=> tous les caractères entre crochets
                // 		\\\\ 	=> le caractère \
                // 		\/ 		=> le caractère /
                //		:		=> le caractère :
                //		*		=> le caractère *
                //		?		=> le caractère ?
                //		\"		=> le caractère "
                //		<		=> le caractère <
                //		>		=> le caractère >
                //		|		=> le caractère |

                $sousDossier = preg_replace('/[\\\\\/:*?\"<>|]/', '_', $agent->getCorps());
            }

            $zip->addFile($crepPath, $sousDossier.'/'.$agent->getCrep()->getPdfFileName());
        }

        $zip->close();

        return $zipName;
    }

    public function supprimerCrep(Crep $crep)
    {
        $crep->getAgent()->setCrep(null);

        $this->em->remove($crep);
        $this->em->flush();
    }

    /**
     * Refaire un CREP suite à un recours.
     *
     * @param Crep $crep
     */
    public function devaliderCrep(Crep $crep)
    {
        // Supprimer le crep papier et le crep pdf
        $crepPapier = $crep->getCrepPapier();
        $crepPdf = $crep->getCrepPdf();

        $crep->setCrepPapier(null);
        $crep->setCrepPdf(null);

        if ($crepPapier) {
            $this->em->remove($crepPapier);
        }
        if ($crepPdf) {
            $this->em->remove($crepPdf);
        }

        // Dévalider les signatures
        $crep
            ->setDateVisaShd(null)
            ->setShdSignataire(null)
            ->setDateVisaAgent(null)
            ->setDateRefusVisa(null)
            ->setDateVisaAh(null)
            ->setAhSignataire(null)
            ->setDateNotification(null)
            ->setDateRefusNotification(null)
            ->setDateRenvoiAgent(null)
            ->setMotifRenvoiAgent(null)
            ->setMotifRenvoiAh(null)
            ->setDateRenvoiAh(null)
            ->setStatut(EnumStatutCrep::MODIFIE_SHD)
            ->setStatutCrepAvantImport(null);

        /* @var $recours Recours */
        foreach ($crep->getRecours() as $recours) {
            if (null !== $recours->getDecision()) {
                $recours->setDecisionPriseEnCompte(true);
            }
        }

        $this->em->persist($crep);
        $this->em->flush();
    }

    /**
     * @param unknown $crep
     */
    public function laisserCrepEnEtat(Crep $crep)
    {
        /* @var $recours Recours */
        foreach ($crep->getRecours() as $recours) {
            // Ne modifier que les recours qui ne sont pas traités
            if (!$recours->getDecisionPriseEnCompte()) {
                $recours->setDecisionPriseEnCompte(true);
            }
        }

        $this->em->persist($crep);
        $this->em->flush();
    }

    public function exporterFormations(CampagneBrhp $campagneBrhp)
    {
        $zip = new \ZipArchive();

        $zipName = $this->kernelRootDir.'/../var/tmp/';
        $zipName .= 'Documents_'.time().$this->session->getId().'.zip';

        $zip->open($zipName, \ZipArchive::CREATE);

        /* @var $modeleCrepRepository ModeleCrepRepository */
        $modeleCrepRepository = $this->em->getRepository('AppBundle:ModeleCrep');

        $modelesCrep = $modeleCrepRepository->getModelesCrep($campagneBrhp->getCampagnePnc()->getMinistere());

        /* @var $modeleCrep ModeleCrep */
        foreach ($modelesCrep as $modeleCrep) {
            if (isset($this->modelesCrepManagers[$modeleCrep->getTypeEntity()])) {
                $zip = $this->modelesCrepManagers[$modeleCrep->getTypeEntity()]->exporterFormations($campagneBrhp, $modeleCrep, $zip);
            } else {
                throw new \Exception('Modèle de CREP : '.$modeleCrep->getTypeEntity().' non défini dans la class : '.__CLASS__);
            }
        }

        $zip->close();

        return $zipName;
    }
}
