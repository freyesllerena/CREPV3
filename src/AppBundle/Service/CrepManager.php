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
use AppBundle\Entity\Document;
use Symfony\Component\HttpFoundation\File\File;
use AppBundle\Entity\Recours;
use AppBundle\Service\ModelesCrep\CrepMindef01Manager;
use AppBundle\Service\ModelesCrep\CrepAcManager;
use AppBundle\Service\ModelesCrep\CrepMccManager;
use AppBundle\Service\ModelesCrep\CrepMinefAbcManager;
use AppBundle\Service\ModelesCrep\CrepMinefContractManager;
use AppBundle\Service\ModelesCrep\CrepSclManager;
use AppBundle\Repository\RecoursRepository;
use AppBundle\EnumTypes\EnumTypeRecours;
use AppBundle\Service\ModelesCrep\CrepMso3Manager;
use AppBundle\Service\ModelesCrep\CrepMso5Manager;
use AppBundle\Service\ModelesCrep\CrepMcc02Manager;
use AppBundle\Service\ModelesCrep\CrepMj02Manager;
use AppBundle\Service\ModelesCrep\CrepMj01Manager;
use AppBundle\Service\ModelesCrep\CrepEddManager;
use AppBundle\Service\ModelesCrep\CrepDgacManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\ORM\EntityManagerInterface;
use WhiteOctober\TCPDFBundle\Controller\TCPDFController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use AppBundle\Service\ConstanteManager;
use Symfony\Component\Templating\EngineInterface;
use AppBundle\Service\ModelesCrep\CrepScl02Manager;
use Symfony\Component\HttpFoundation\StreamedResponse;
use ZipStream\ZipStream;
use Symfony\Component\Debug\Exception\ContextErrorException;

class CrepManager
{
    protected $tokenStorage;

    protected $tcpdf;

    protected $confidentialisationManager;

    protected $appMailer;

    protected $templating;

    protected $session;

    protected $em;

    protected $kernelRootDir;

    protected $certificat;

    protected $crepMindef01Manager;

    protected $crepAcManager;

    protected $crepMccManager;

    protected $crepMinefAbcManager;

    protected $crepMinefContractManager;

    protected $crepSclManager;

    protected $crepMso3Manager;

    protected $crepMso5Manager;

    protected $modelesCrepManagers;

    protected $crepEddManager;

    protected $crepMj01Manager;

    protected $crepMcc02Manager;

    protected $crepScl02Manager;

    protected $crepMj02Manager;

    protected $crepDgacManager;

    public function __construct(
        EntityManagerInterface $entityManager,
        TokenStorageInterface $tokenStorage,
        TCPDFController $tcpdf,
        CrepConfidentialisationManager $confidentialisationManager,
        AppMailer $appMailer,
        EngineInterface $templating,
        SessionInterface $session,
        ConstanteManager $constanteManager,

        CrepMindef01Manager $crepMindef01Manager,
        CrepAcManager $crepAcManager,
        CrepMccManager $crepMccManager,
        CrepMinefAbcManager $crepMinefAbcManager,
        CrepMinefContractManager $crepMinefContractManager,
        CrepSclManager $crepSclManager,
        CrepMso3Manager $crepMso3Manager,
        CrepMso5Manager $crepMso5Manager,
        CrepMj01Manager $crepMj01Manager,
        CrepMcc02Manager $crepMcc02Manager,
        CrepEddManager $crepEddManager,
        CrepScl02Manager $crepScl02Manager,
        CrepMj02Manager $crepMj02Manager,
        CrepDgacManager $crepDgacManager
    )
    {

        $this->em = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->tcpdf = $tcpdf;
        $this->confidentialisationManager = $confidentialisationManager;
        $this->appMailer = $appMailer;
        $this->templating = $templating;
        $this->session = $session;
        $this->certificat = $constanteManager->getCertificat();
        $this->kernelRootDir = $constanteManager->getKernelRootDir();
        $this->crepMindef01Manager = $crepMindef01Manager;
        $this->crepAcManager = $crepAcManager;
        $this->crepMccManager = $crepMccManager;
        $this->crepMinefAbcManager = $crepMinefAbcManager;
        $this->crepMinefContractManager = $crepMinefContractManager;
        $this->crepSclManager = $crepSclManager;
        $this->crepMso3Manager = $crepMso3Manager;
        $this->crepMso5Manager = $crepMso5Manager;
        $this->crepMj01Manager = $crepMj01Manager;
        $this->crepMcc02Manager = $crepMcc02Manager;
        $this->crepEddManager = $crepEddManager;
        $this->crepScl02Manager = $crepScl02Manager;
        $this->crepMj02Manager = $crepMj02Manager;

        $this->modelesCrepManagers = [
            'CrepMindef01' => $this->crepMindef01Manager,
            'CrepAc' => $this->crepAcManager,
            'CrepMcc' => $this->crepMccManager,
            'CrepMinefAbc' => $this->crepMinefAbcManager,
            'CrepMinefContract' => $this->crepMinefContractManager,
            'CrepScl' => $this->crepSclManager,
            'CrepMso3' => $this->crepMso3Manager,
            'CrepMso5' => $this->crepMso5Manager,
            'CrepMj01' => $this->crepMj01Manager,
            'CrepMcc02' => $this->crepMcc02Manager,
            'CrepEdd' => $this->crepEddManager,
            'CrepScl02' => $this->crepScl02Manager,
            'CrepMj02' => $this->crepMj02Manager,
        ];
    }

    public function creer(Agent $agent, ModeleCrep $modeleCrep)
    {
        $classe = $modeleCrep->getTypeEntity();

        $classPath = 'AppBundle\Entity\Crep\\' . $classe . '\\' . $classe;

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
        $crep->setDateConsultationAgent(null);
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
//        $crep->setObservationsAh(null); // Suite au ticket INC0021806
        $crep->setDateConsultationAgent(null);
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

    public function rappelerAgentShd(Crep $crep)
    {
        $crep->setStatut(EnumStatutCrep::MODIFIE_SHD);
        $crep->setDateVisaShd(null);
        $crep->setShdSignataire(null);

        $this->em->persist($crep);
        $this->em->flush();

        //Notification de l'agent
        $this->appMailer->notifierRappelAgentShd($crep);
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

    public function calculIndicateurs(Campagne $campagne, $perimetresRlc = [], $perimetresBrhp = [], Agent $shd = null, Agent $ah = null, $categories = [], $affectations = [], $corps = [])
    {
        /* @var $crepRepository CrepRepository */
        $crepRepository = $this->em->getRepository('AppBundle:Crep');

        /* @var $agentRepository AgentRepository */
        $agentRepository = $this->em->getRepository('AppBundle:Agent');

        /* @var $recoursRepository RecoursRepository */
        $recoursRepository = $this->em->getRepository('AppBundle:Recours');

        // Tableau qui va contenir les indicateurs à afficher dans le tableau de bord
        $indicateurs = [];

        $indicateurs['nbCrep'] = $agentRepository->getNbAgentsEvaluables($campagne, $perimetresRlc, $perimetresBrhp, $shd, $ah, $categories, $affectations, $corps);

        $indicateurs['nbCrepSignesShd'] = $crepRepository->getNbCreps($campagne, $perimetresRlc, $perimetresBrhp, array(EnumStatutCrep::SIGNE_SHD), $shd, $ah, $categories, $affectations, $corps);

        $indicateurs['nbCrepVisesAgent'] = $crepRepository->getNbCreps($campagne, $perimetresRlc, $perimetresBrhp, array(EnumStatutCrep::VISE_AGENT), $shd, $ah, $categories, $affectations, $corps);

        $indicateurs['nbCrepSignesAh'] = $crepRepository->getNbCreps($campagne, $perimetresRlc, $perimetresBrhp, array(EnumStatutCrep::SIGNE_AH), $shd, $ah, $categories, $affectations, $corps);

        $indicateurs['nbCrepNotifies'] = $crepRepository->getNbCreps($campagne, $perimetresRlc, $perimetresBrhp, array(EnumStatutCrep::NOTIFIE_AGENT), $shd, $ah, $categories, $affectations, $corps);

        $indicateurs['nbCrepRefusNotification'] = $crepRepository->getNbCreps($campagne, $perimetresRlc, $perimetresBrhp, array(EnumStatutCrep::REFUS_NOTIFICATION_AGENT), $shd, $ah, $categories, $affectations, $corps);

        $indicateurs['nbCrepModifieShd'] = $crepRepository->getNbCreps($campagne, $perimetresRlc, $perimetresBrhp, array(EnumStatutCrep::MODIFIE_SHD), $shd, $ah, $categories, $affectations, $corps);

        $indicateurs['nbCrepRefusVisas'] = $crepRepository->getNbCreps($campagne, $perimetresRlc, $perimetresBrhp, array(EnumStatutCrep::REFUS_VISA_AGENT), $shd, $ah, $categories, $affectations, $corps);

        $indicateurs['nbCrepNonRenseignes'] = $indicateurs['nbCrep']
            - $indicateurs['nbCrepSignesShd']
            - $indicateurs['nbCrepVisesAgent']
            - $indicateurs['nbCrepSignesAh']
            - $indicateurs['nbCrepNotifies']
            - $indicateurs['nbCrepRefusNotification']
            - $indicateurs['nbCrepModifieShd']
            - $indicateurs['nbCrepRefusVisas'];

        /************** Statistiques sur les recours **************/

        $indicateurs['nbTotalRecours'] = $recoursRepository->getNbRecours($campagne, $perimetresRlc, $perimetresBrhp, null, $shd, $ah, null, $categories, $affectations, $corps);

        $indicateurs['nbRecoursHierarchique'] = $recoursRepository->getNbRecours($campagne, $perimetresRlc, $perimetresBrhp, EnumTypeRecours::RECOURS_HIERARCHIQUE, $shd, $ah, null, $categories, $affectations, $corps);

        $indicateurs['nbRecoursEnCAP'] = $recoursRepository->getNbRecours($campagne, $perimetresRlc, $perimetresBrhp, EnumTypeRecours::RECOURS_CAP, $shd, $ah, null, $categories, $affectations, $corps);

        $indicateurs['nbRecoursAuTA'] = $recoursRepository->getNbRecours($campagne, $perimetresRlc, $perimetresBrhp, EnumTypeRecours::RECOURS_TRIBUNAL_ADMINISTRATIF, $shd, $ah, null, $categories, $affectations, $corps);

        //@param string $distinctCrep : pour avoir le nombre de CREP en mention de recours
        $indicateurs['nbCrepEnRecours'] = $recoursRepository->getNbRecours($campagne, $perimetresRlc, $perimetresBrhp, null, $shd, $ah, true, $categories, $affectations, $corps);

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

        $utilisateur = $this->tokenStorage->getToken()->getUser();

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

    /**
     * Methode qui permet d'exporter les CREP PDF sous forme de flux http (stream)
     *
     * @param array $tableauDonneesAgentsCreps tableau qui contient les données agents et creps
     */
    public function exporterCrepsFinalises($tableauDonneesAgentsCreps)
    {
        $streamedResponse = new StreamedResponse(function() use($tableauDonneesAgentsCreps)
        {
            $zip = new ZipStream('Export_CREPs_finalises.zip');
            $crepNom = "";

            /* @var $agent Agent */
            foreach ($tableauDonneesAgentsCreps as $donneeAgentCrep) {
                if ($donneeAgentCrep['crepPapier_path']) {
                    // CREPs papier
                    /* @var $crep Crep */
                    $crep = $this->em->getRepository(Crep::class)->find($donneeAgentCrep['crep_id']);
                    $crepPath = $crep->getCrepPapier()->getAbsolutePath();
                    $crepNom = $crep->getPdfFileName();
                } else {
                    // CREPs finalisés dans ESTEVE
                    $crepPath = __DIR__.'/../../../web/documents/'.$donneeAgentCrep['crepPdf_path'];
                    $crepNom = $donneeAgentCrep['crepPdf_nom'];
                }

                $sousDossier = 'Autre';

                if ($donneeAgentCrep['agent_corps']) {
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

                    $sousDossier = preg_replace('/[\\\\\/:*?\"<>|]/', '_', $donneeAgentCrep['agent_corps']);
                }

                try {
                    $streamRead = fopen($crepPath, 'r');
                    $zip->addFileFromStream($sousDossier.'/'.$crepNom, $streamRead);
                }catch (ContextErrorException $e ){
                    // TODO : logger une erreur sur l'ouverture du fichier CREP
                }
            }

            $zip->finish();
        });

        return $streamedResponse;
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
