<?php

namespace AppBundle\Service;

use FOS\UserBundle\Mailer\MailerInterface as FOSMailerInterface;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use AppBundle\Entity\Utilisateur;
use AppBundle\Entity\CampagnePnc;
use AppBundle\Entity\PerimetreRlc;
use AppBundle\Entity\Rlc;
use AppBundle\Entity\CampagneRlc;
use AppBundle\Entity\Brhp;
use AppBundle\Entity\PerimetreBrhp;
use AppBundle\Entity\CampagneBrhp;
use AppBundle\Entity\Agent;
use AppBundle\Entity\Crep;
use AppBundle\Repository\UtilisateurRepository;
use AppBundle\Entity\Campagne;
use AppBundle\Repository\AgentRepository;
use AppBundle\Repository\CampagneRlcRepository;
use AppBundle\EnumTypes\EnumStatutCampagne;
use AppBundle\Twig\AppExtension;
use AppBundle\Repository\CampagneBrhpRepository;
use Symfony\Component\Routing\RouterInterface;
use AppBundle\Service\ConstanteManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Templating\EngineInterface;

class AppMailer extends Mailer implements FOSMailerInterface
{
    protected $roleService;
    protected $em;
    protected $repository;
    protected $templating;
    protected $kernelRootDir;
    protected $router;

    public function __construct(\Swift_Mailer $mailer, EngineInterface $templating, RouterInterface $router, EntityManagerInterface $em, ConstanteManager $constanteManager)
    {
        $this->companyName = $constanteManager->getCompanyName();
        $this->from = $constanteManager->getFromAddress();
        $this->reply = $constanteManager->getReplyAddress();
        $this->em = $em;
        $this->repository = $this->em->getRepository('AppBundle:Utilisateur');
        $this->templating = $templating;
        $this->kernelRootDir = $constanteManager->getKernelRootDir();
        $this->appName = $constanteManager->getAppName();
        $this->router = $router;
        $this->mailer = $mailer;
    }

    /* Notification des RLC de l'ouverture de la campagne PNC */
    public function notifierOuvrirCampagnePnc(CampagnePnc $campagnePnc, $rlcs = [])
    {
        $repositoryCampagneRlc = $this->em->getRepository('AppBundle:CampagneRlc');
        $subject = $campagnePnc->getLibelle().' ouverte aux acteurs de niveau local ';
        $template = 'email/campagnePnc/ouvertureCampagne.html.twig';

        $rlcsIds = array();
        foreach ($rlcs as $rlc) {
            $rlcsIds[$rlc->getId()] = $rlc->getId();
        }

        /* @var $perimetreRlc PerimetreRlc */
        foreach ($campagnePnc->getPerimetresRlc() as $perimetreRlc) {
            // Récupérer la campagneRlc de chaque rlc, pour générer l'url show dans le template
            $campagneRlc = $repositoryCampagneRlc->findOneBy(array('campagnePnc' => $campagnePnc, 'perimetreRlc' => $perimetreRlc));

            /*@var $rlc Rlc */
            foreach ($perimetreRlc->getRlcs() as $rlc) {
                if (empty($rlcs) || isset($rlcsIds[$rlc->getId()])) {
                    $body = $this->templating->render($template, array(
                                                        'campagnePnc' => $campagnePnc,
                                                        'campagne' => $campagneRlc,
                                                        'perimetre' => $perimetreRlc,
                                                        'destinataire' => $rlc->getUtilisateur(),
                                                        'subject' => $subject,
                                                ));

                    // Envoyer le mail d'ouverture de campagne
                    $this->sendMessage($rlc->getUtilisateur(), $subject, $body);
                }
            }
        }

        /* @var $repositoryUtilisateur UtilisateurRepository */
        $repositoryUtilisateur = $this->em->getRepository('AppBundle:Utilisateur');
        $adminsMins = $repositoryUtilisateur->getAdminsMin($campagnePnc->getMinistere());
        $template = 'email/campagnePnc/ouvertureCampagneAdminMin.html.twig';
        $subject = $campagnePnc->getLibelle().' ouverte';

        foreach ($adminsMins as $adminMin) {
            $body = $this->templating->render($template, array(
                    'campagnePnc' => $campagnePnc,
                    'destinataire' => $adminMin,
                    'subject' => $subject,
            ));

            // Envoyer le mail d'ouverture de campagne
            $this->sendMessage($adminMin, $subject, $body);
        }
    }

    /* Notification des BRHP et BRHP consultation de l'ouverture de la campagne RLC */
    public function notifierOuvrirCampagneRlc(CampagneRlc $campagneRlc)
    {
        /* @var $repositoryCampagneBrhp CampagneBrhpRepository */
        $repositoryCampagneBrhp = $this->em->getRepository('AppBundle:CampagneBrhp');
        $template = 'email/campagneRlc/ouvertureCampagne.html.twig';

        /* @var $perimetreBrhp PerimetreBrhp */
        foreach ($campagneRlc->getPerimetresBrhp() as $perimetreBrhp) {
            // Récupérer la campagneBRHP de chaque brhp, pour générer l'url show dans le template
            $campagneBrhp = $repositoryCampagneBrhp->findOneBy(array('campagneRlc' => $campagneRlc, 'perimetreBrhp' => $perimetreBrhp));

            // Notification des BRHP
            /*@var $brhp Brhp */
            foreach ($perimetreBrhp->getBrhps() as $brhp) {
                $destinataire = $brhp->getUtilisateur();

                if ($brhp->getUtilisateur()->isEnabled()) {
                    $subject = $campagneRlc->getLibelle().' ouverte aux acteurs de niveau proximité pour le périmètre '.$perimetreBrhp->getLibelle();
                    $body = $this->templating->render($template, array(
                            'campagneRlc' => $campagneRlc,
                            'campagne' => $campagneBrhp,
                            'perimetre' => $perimetreBrhp,
                            'destinataire' => $destinataire,
                            'subject' => $subject,
                    ));

                    // Envoyer le mail d'ouverture de campagne
                    $this->sendMessage($destinataire, $subject, $body);
                }
            }

            // Notification des BRHP consultation
            /*@var $brhp Brhp */
            foreach ($perimetreBrhp->getBrhpsConsult() as $brhpConsult) {
                $destinataire = $brhpConsult->getUtilisateur();

                if ($brhpConsult->getUtilisateur()->isEnabled()) {
                    $subject = $campagneRlc->getLibelle().' ouverte aux acteurs de niveau proximité pour le périmètre '.$perimetreBrhp->getLibelle();
                    $body = $this->templating->render($template, array(
                            'campagneRlc' => $campagneRlc,
                            'campagne' => $campagneBrhp,
                            'perimetre' => $perimetreBrhp,
                            'destinataire' => $destinataire,
                            'subject' => $subject,
                    ));

                    // Envoyer le mail d'ouverture de campagne
                    $this->sendMessage($destinataire, $subject, $body);
                }
            }
        }
    }

    public function notifierAjoutPerimetresBrhp(CampagneRlc $campagneRlc, $perimetres = [])
    {
        $repositoryCampagneBrhp = $this->em->getRepository('AppBundle:CampagneBrhp');
        $template = 'email/campagneRlc/ouvertureCampagne.html.twig';

        /*@var $perimetres PerimetreBrhp */
        foreach ($perimetres as $perimetre) {
            // Récupérer la campagneBRHP de chaque brhp, pour générer l'url show dans le template
            $campagneBrhp = $repositoryCampagneBrhp->findOneBy(array('campagneRlc' => $campagneRlc, 'perimetreBrhp' => $perimetre));

            /*@var $brhp Brhp */
            foreach ($perimetre->getBrhps() as $brhp) {
                $destinataire = $brhp->getUtilisateur();

                if ($destinataire->isEnabled()) {
                    $subject = $campagneRlc->getLibelle().' ouverte aux acteurs de niveau proximité pour le périmètre '.$perimetre->getLibelle();
                    $body = $this->templating->render($template, array(
                        'campagneRlc' => $campagneRlc,
                        'campagne' => $campagneBrhp,
                        'perimetre' => $perimetre,
                        'destinataire' => $destinataire,
                        'subject' => $subject,
                    ));

                    // Envoyer le mail d'ouverture de campagne
                    $this->sendMessage($destinataire, $subject, $body);
                }
            }
        }
    }

    public function notifierAjoutPerimetresRlc(CampagnePnc $campagnePnc, $perimetres = [])
    {
        $repositoryCampagneRlc = $this->em->getRepository('AppBundle:CampagneRlc');
        $template = 'email/campagnePnc/ouvertureCampagne.html.twig';

        /*@var $perimetres PerimetreRlc */
        foreach ($perimetres as $perimetre) {
            // Récupérer la campagneBRHP de chaque brhp, pour générer l'url show dans le template
            $campagneRlc = $repositoryCampagneRlc->findOneBy(array('campagnePnc' => $campagnePnc, 'perimetreRlc' => $perimetre));

            /*@var $rlc Rlc */
            foreach ($perimetre->getRlcs() as $rlc) {
                $destinataire = $rlc->getUtilisateur();
                if ($destinataire->isEnabled()) {
                    $subject = $campagneRlc->getLibelle().' ouverte aux acteurs de niveau local pour le périmètre '.$perimetre->getLibelle();
                    $body = $this->templating->render($template, array(
                        'campagnePnc' => $campagnePnc,
                        'campagne' => $campagneRlc,
                        'perimetre' => $perimetre,
                        'destinataire' => $destinataire,
                        'subject' => $subject,
                    ));

                    // Envoyer le mail d'ouverture de campagne
                    $this->sendMessage($destinataire, $subject, $body);
                }
            }
        }
    }

    /* Notification des N+1 de l'ouverture de la campagne BRHP et diffusion des listes d'agents à évaluer */
    public function notifierOuvrirShd(CampagneBrhp $campagneBrhp)
    {
        $template = 'email/campagneBrhp/ouvrirShd.html.twig';

        /* @var $repositoryAgent AgentRepository */
        $repositoryAgent = $this->em->getRepository('AppBundle:Agent');

        $shds = $repositoryAgent->getShdsByCampagneBrhp($campagneBrhp);

        foreach ($shds as $shd) {
            $destinataire = $shd->getUtilisateur();
            /* @var $destinataire Utilisateur */
            if ($destinataire->isEnabled()) {
                $subject = $campagneBrhp->getLibelle()." : Diffusion de la population d'agents du périmètre ".$campagneBrhp->getPerimetreBrhp()->getLibelle();
                $body = $this->templating->render($template, array(
                             'campagne' => $campagneBrhp,
                             'perimetre' => $campagneBrhp->getPerimetreBrhp(),
                             'destinataire' => $destinataire,
                            'subject' => $subject,
                     ));

                // Envoyer le mail de diffusion des listes d'agents
                $this->sendMessage($destinataire, $subject, $body);
            }
        }
    }

    /* Notification au N+1 de 'ouverture de campagne BRHP */
    public function notifierOuvrirCampagneBrhp(CampagneBrhp $campagneBrhp)
    {
        $repositoryAgent = $this->em->getRepository('AppBundle:Agent');
        $agents = $repositoryAgent->getAgentsEvaluables($campagneBrhp);

        //Notification aux Agents
        /* @var $agent Agent */
        foreach ($agents as $agent) {
            $destinataire = $agent->getUtilisateur();
            /* @var $destinataire Utilisateur */
            if ($destinataire->isEnabled()) {
                $subject = $campagneBrhp->getLibelle().' ouverte aux agents';
                $template = 'email/campagneBrhp/ouvertureCampagneAgent.html.twig';
                $body = $this->templating->render($template, array(
                                                                    'campagne' => $campagneBrhp,
                                                                    'destinataire' => $destinataire,
                                                                    'subject' => $subject,
                                          ));

                // Envoyer le mail d'ouverture de campagne
                $message = $this->sendMessage($destinataire, $subject, $body, [], false);
                $this->em->persist($message);
            }
        }

        //Notification aux N+1
        $template = 'email/campagneBrhp/ouvertureCampagneShd.html.twig';
        $Shds = $repositoryAgent->getShds($campagneBrhp);

        /* @var $Shd Agent */
        foreach ($Shds as $Shd) {
            $destinataire = $Shd->getUtilisateur();

            /* @var $destinataire Utilisateur */
            if ($destinataire->isEnabled()) {
                $subject = $campagneBrhp->getLibelle().' ouverte aux responsables N+1 pour le périmètre '.$campagneBrhp->getPerimetreBrhp()->getLibelle();
                $body = $this->templating->render($template, array(
                                                                      'campagne' => $campagneBrhp,
                                                                      'destinataire' => $destinataire,
                                                                      'perimetre' => $campagneBrhp->getPerimetreBrhp(),
                                                                      'subject' => $subject,
                                           ));

                // Envoyer le mail d'ouverture de campagne
                $message = $this->sendMessage($destinataire, $subject, $body, [], false);
                $this->em->persist($message);
            }
        }

        //Notification aux N+2
        $template = 'email/campagneBrhp/ouvertureCampagneAh.html.twig';
        $Ahs = $repositoryAgent->getAhByCampagneBrhp($campagneBrhp);

        /* @var $Ah Agent */
        foreach ($Ahs as $Ah) {
            $destinataire = $Ah->getUtilisateur();

            /* @var $destinataire Utilisateur */
            if ($destinataire->isEnabled()) {
                $subject = $campagneBrhp->getLibelle().' ouverte aux responsables N+2 pour le périmètre '.$campagneBrhp->getPerimetreBrhp()->getLibelle();
                $body = $this->templating->render($template, array(
                                                                      'campagne' => $campagneBrhp,
                                                                      'destinataire' => $destinataire,
                                                                      'perimetre' => $campagneBrhp->getPerimetreBrhp(),
                                                                      'subject' => $subject,
                                                ));

                // Envoyer le mail d'ouverture de campagne
                $message = $this->sendMessage($destinataire, $subject, $body, [], false);
                $this->em->persist($message);
            }
        }
        $this->em->flush();
    }

    /* Notification à l'agent que le crep a été signé par le N+1 */
    public function notifierSignatureShd(Crep $crep)
    {
        $agent = $crep->getAgent();
        $destinataire = $agent->getUtilisateur();

        /* @var $destinataire Utilisateur */
        if ($destinataire && $destinataire->isEnabled()) {
            $shd = $crep->getShd();
            $nomPrenomShd = ucfirst($shd->getPrenom()).' '.mb_strtoupper($shd->getNom(), 'UTF-8');
            $campagne = $crep->getAgent()->getCampagneBrhp();

            $subject = $campagne->getLibelle()." : Signature du compte rendu d'évaluation professionnelle par votre N+1 (".$nomPrenomShd.')';
            $template = 'email/crep/signatureShd.html.twig';
            $body = $this->templating->render($template, array(
                                                'campagne' => $campagne,
                                                'crep' => $crep,
                                                'shd' => $shd,
                                                'destinataire' => $destinataire,
                                                'subject' => $subject,
                                              ));

            //Envoyer le mail de signature de crep par le N+1
            $this->sendMessage($destinataire, $subject, $body);
        }
    }

    /* Notification au N+1 de demande de révision du crep */
    public function notifierRenvoiAgentShd(Crep $crep)
    {
        $shd = $crep->getShd();
        $destinataire = $shd->getUtilisateur();

        /* @var $destinataire Utilisateur */
        if ($destinataire->isEnabled()) {
            $agent = $crep->getAgent();
            $nomPrenomAgent = ucfirst($agent->getPrenom()).' '.mb_strtoupper($agent->getNom(), 'UTF-8');

            $campagne = $crep->getAgent()->getCampagneBrhp();
            $subject = $campagne->getLibelle()." : Compte rendu d'évaluation professionnelle de ".$nomPrenomAgent.' à réviser.';

            //Envoyer le mail au N+1 de souhait de revision du crep
            $template = 'email/crep/renvoiAgentShd.html.twig';
            $body = $this->templating->render($template, array(
                                                'campagne' => $campagne,
                                                'crep' => $crep,
                                                'agent' => $agent,
                                                'destinataire' => $destinataire,
                                                'subject' => $subject,
                                               ));

            $this->sendMessage($destinataire, $subject, $body);
        }
    }

    /* Notification au N+1 & N+2 que le crep a été visé par l'agent */
    public function notifierVisaAgent(Crep $crep)
    {
        $ah = $crep->getAh();
        $destinataire1 = $ah->getUtilisateur();

        /* @var $destinataire Utilisateur */
        if ($destinataire1->isEnabled()) {
            $agent = $crep->getAgent();

            $nomPrenomAgent = ucfirst($agent->getPrenom()).' '.mb_strtoupper($agent->getNom(), 'UTF-8');
            $campagne = $crep->getAgent()->getCampagneBrhp();

            $subject = $campagne->getLibelle()." : Compte rendu d'évaluation professionnelle visé par ".$nomPrenomAgent;

            //Envoyer le mail au N+2 de visa du crep par l'agent
            $template = 'email/crep/visaAgentAh.html.twig';
            $body = $this->templating->render($template, array(
                    'campagne' => $campagne,
                    'crep' => $crep,
                    'agent' => $agent,
                    'destinataire' => $destinataire1,
                    'subject' => $subject,
            ));

            $this->sendMessage($destinataire1, $subject, $body);
        }

        //Envoyer le mail au N+1 de visa du crep par l'agent
        //On verifie que le N+2 n'est pas aussi le N+1
        $shd = $crep->getShd();
        $destinataire2 = $shd->getUtilisateur();

        if ($destinataire1->getId() != $destinataire2->getId()) {
            /* @var $destinataire Utilisateur */
            if ($destinataire2->isEnabled()) {
                $template = 'email/crep/visaAgentShd.html.twig';
                $body = $this->templating->render($template, array(
                    'campagne' => $campagne,
                    'crep' => $crep,
                    'agent' => $agent,
                    'destinataire' => $destinataire2,
                    'subject' => $subject,
                ));

                $this->sendMessage($destinataire2, $subject, $body);
            }
        }
    }

    public function notifierRefusVisaAgent(Crep $crep)
    {
        $shd = $crep->getShd();
        $agent = $crep->getAgent();
        $nomPrenomAgent = ucfirst($agent->getPrenom()).' '.mb_strtoupper($agent->getNom(), 'UTF-8');

        $campagne = $crep->getAgent()->getCampagneBrhp();
        $subject = $campagne->getLibelle()." : Visa de compte rendu d'évaluation professionnelle refusé par ".$nomPrenomAgent;

        //Envoyer le mail au N+2 du refus de visa du crep de l'agent
        $ah = $crep->getAh();
        $destinataire = $ah->getUtilisateur();

        /* @var $destinataire Utilisateur */
        if ($destinataire && $destinataire->isEnabled()) {
            $template = 'email/crep/refusVisaAgentAh.html.twig';
            $body = $this->templating->render($template, array(
                                                'campagne' => $campagne,
                                                'crep' => $crep,
                                                'shd' => $shd,
                                                'agent' => $agent,
                                                'destinataire' => $destinataire,
                                                'subject' => $subject,
                                            ));

            $this->sendMessage($destinataire, $subject, $body);
        }
        //Envoyer le mail a l'agent de son refus de visa du crep
        $destinataire = $agent->getUtilisateur();
        /* @var $destinataire Utilisateur */
        if ($destinataire && $destinataire->isEnabled()) {
            $template = 'email/crep/refusVisaAgent.html.twig';
            $body = $this->templating->render($template, array(
                                                'campagne' => $campagne,
                                                'crep' => $crep,
                                                'shd' => $shd,
                                                'agent' => $agent,
                                                'destinataire' => $destinataire,
                                                'subject' => $subject,
                                            ));

            $this->sendMessage($destinataire, $subject, $body);
        }
    }

    /* Notification au N+1 de la demande de révision du crep, par le N+2 */
    public function notifierRenvoieAhShd(Crep $crep)
    {
        $shd = $crep->getShd();
        $destinataire = $shd->getUtilisateur();

        //Envoyer le mail de demande de révision du crep par le N+2, au N+1

        /* @var $destinataire Utilisateur */
        if ($destinataire->isEnabled()) {
            $ah = $crep->getAh();
            $nomPrenomAh = ucfirst($ah->getPrenom()).' '.mb_strtoupper($ah->getNom());

            $agent = $crep->getAgent();
            $nomPrenomAgent = ucfirst($agent->getPrenom()).' '.mb_strtoupper($agent->getNom(), 'UTF-8');

            $template = 'email/crep/renvoiAhShd.html.twig';
            $campagne = $crep->getAgent()->getCampagneBrhp();
            $subject = $campagne->getLibelle()." : Demande de révision du compte rendu d'évaluation professionnelle de ".$nomPrenomAgent.', par son N+2 ('.$nomPrenomAh.')';
            $body = $this->templating->render($template, array(
                                                    'campagne' => $campagne,
                                                    'crep' => $crep,
                                                    'ah' => $ah,
                                                    'agent' => $agent->getUtilisateur(),
                                                    'destinataire' => $destinataire,
                                                    'subject' => $subject,
                                                ));
            $this->sendMessage($destinataire, $subject, $body);
        }
    }

    public function notifierSignatureAh(Crep $crep)
    {
        $agent = $crep->getAgent();
        $destinataire1 = $agent->getUtilisateur();
        $ah = $crep->getAh();
        $shd = $crep->getShd();
        $destinataire2 = $shd->getUtilisateur();

        $nomPrenomAgent = ucfirst($agent->getPrenom()).' '.mb_strtoupper($agent->getNom(), 'UTF-8');
        $nomPrenomAh = ucfirst($ah->getPrenom()).' '.mb_strtoupper($ah->getNom());
        $campagne = $crep->getAgent()->getCampagneBrhp();

        //Envoyer le mail de signature de crep par le N+2 à l'agent
        /* @var $destinataire Utilisateur */
        if ($destinataire1->isEnabled()) {
            $template = 'email/crep/signatureAhAgent.html.twig';
            $subject = $campagne->getLibelle()." : Signature du compte rendu d'évaluation professionnelle par votre N+2 (".$nomPrenomAh.')';
            $body = $this->templating->render($template, array(
                'campagne' => $campagne,
                'crep' => $crep,
                'ah' => $ah->getUtilisateur(),
                'destinataire' => $destinataire1,
                'subject' => $subject,
            ));

            $this->sendMessage($destinataire1, $subject, $body);
        }

        //Envoyer le mail de signature de crep par le N+2 au N+1
        //On verifie que le N+2 n'est pas aussi le N+1
        if ($ah->getUtilisateur()->getId() != $destinataire2->getId()) {
            /* @var $destinataire Utilisateur */
            if ($destinataire2->isEnabled()) {
                $template = 'email/crep/signatureAhShd.html.twig';
                $subject = $campagne->getLibelle()." : Signature du compte rendu d'évaluation professionnelle par le N+2 (".$nomPrenomAh.') de votre agent ('.$nomPrenomAgent.')';
                $body = $this->templating->render($template, array(
                    'campagne' => $campagne,
                    'crep' => $crep,
                    'ah' => $ah,
                    'agent' => $destinataire1,
                    'destinataire' => $destinataire2,
                    'subject' => $subject,
                ));

                $this->sendMessage($destinataire2, $subject, $body);
            }
        }
    }

    /* Notification aux N+1 & N+2 de la notification du CREP par l'agent */
    public function notifierSignatureAgent(Crep $crep)
    {
        $agent = $crep->getAgent();
        $nomPrenomAgent = ucfirst($agent->getPrenom()).' '.mb_strtoupper($agent->getNom(), 'UTF-8');
        $campagne = $agent->getCampagneBrhp();

        $subject = $campagne->getLibelle()." : Signature du compte rendu d'évaluation professionnelle par votre agent (".$nomPrenomAgent.')';

        //Envoyer le mail de refus de notification du crep aux BRHPs de la campagne
        $template = 'email/crep/signatureAgentBrhp.html.twig';

        /* @var $brhp Brhp */
        foreach ($campagne->getPerimetreBrhp()->getBrhps() as $brhp) {
            /* @var $destinataire1 Utilisateur */
            $destinataire1 = $brhp->getUtilisateur();

            if ($destinataire1->isEnabled()) {
                $body = $this->templating->render($template, array(
                    'campagne' => $campagne,
                    'crep' => $crep,
                    'agent' => $agent->getUtilisateur(),
                    'destinataire' => $destinataire1,
                    'subject' => $subject,
                ));
                $this->sendMessage($destinataire1, $subject, $body);
            }
        }

        $ah = $agent->getAh();

        //Si l'agent possède un N+2 : Envoyer le mail de notification du crep au N+2
        if ($ah) {
            /* @var $destinataire2 Utilisateur */
            $destinataire2 = $ah->getUtilisateur();
            if ($destinataire2->isEnabled()) {
                $template = 'email/crep/signatureAgentAh.html.twig';
                $body = $this->templating->render($template, array(
                    'campagne' => $campagne,
                    'crep' => $crep,
                    'agent' => $agent->getUtilisateur(),
                    'destinataire' => $ah->getUtilisateur(),
                    'subject' => $subject,
                ));
                $this->sendMessage($destinataire2, $subject, $body);
            }
        }

        //Envoyer le mail de notification du crep au N+1
        $shd = $agent->getShd();
        /* @var $destinataire3 Utilisateur */
        $destinataire3 = $shd->getUtilisateur();

        //On verifie que le N+2 existe et qu'il n'est pas en même temps le N+1 de l'agent
        if ($agent->getSansAh() || ($ah && $destinataire3->getId() != $ah->getUtilisateur()->getId())) {
            if ($destinataire3->isEnabled()) {
                $template = 'email/crep/signatureAgentShd.html.twig';
                $body = $this->templating->render($template, array(
                    'campagne' => $campagne,
                    'crep' => $crep,
                    'agent' => $agent->getUtilisateur(),
                    'destinataire' => $destinataire3,
                    'subject' => $subject,
                ));
                $this->sendMessage($destinataire3, $subject, $body);
            }
        }
    }

    public function notifierImportCrepPapier(Agent $agent)
    {
        $nomPrenomAgent = ucfirst($agent->getPrenom()).' '.mb_strtoupper($agent->getNom(), 'UTF-8');
        $campagne = $agent->getCampagneBrhp();

        $subject = $campagne->getLibelle()." : Compte rendu d'évaluation professionnelle importé pour l'agent (".$nomPrenomAgent.')';
        $template = 'email/crep/importCrepPapier.html.twig';

        //Envoyer le mail d'import du crep papier à l'agent concerné
        /* @var $destinataire1 Utilisateur */
        $destinataire = $agent->getUtilisateur();
        if ($destinataire && $destinataire->isEnabled()) {
            $body = $this->templating->render($template, array(
                'campagne' => $campagne,
                'agent' => $agent,
                'subject' => $subject,
            ));
            $this->sendMessage($destinataire, $subject, $body);
        }

        //Envoyer le mail d'import du crep papier aux BRHPs de la campagne
        /* @var $brhp Brhp */
        foreach ($campagne->getPerimetreBrhp()->getBrhps() as $brhp) {
            /* @var $destinataire1 Utilisateur */
            $destinataire1 = $brhp->getUtilisateur();

            if ($destinataire1->isEnabled()) {
                $body = $this->templating->render($template, array(
                    'campagne' => $campagne,
                    'agent' => $agent,
                    'subject' => $subject,
                ));
                $this->sendMessage($destinataire1, $subject, $body);
            }
        }

        $ah = $agent->getAh();

        //Si l'agent possède un N+2 : Envoyer le mail d'import du crep papier au N+2
        if ($ah) {
            /* @var $destinataire2 Utilisateur */
            $destinataire2 = $ah->getUtilisateur();
            if ($destinataire2 && $destinataire2->isEnabled()) {
                $body = $this->templating->render($template, array(
                    'campagne' => $campagne,
                    'agent' => $agent,
                    'subject' => $subject,
                ));
                $this->sendMessage($destinataire2, $subject, $body);
            }
        }

        //Envoyer le mail d'import du crep papier au N+1
        $shd = $agent->getShd();

        //Si l'agent possède un N+1 : Envoyer le mail d'import du crep papier au N+1
        if ($shd) {
            /* @var $destinataire3 Utilisateur */
            $destinataire3 = $shd->getUtilisateur();

            //On verifie que le N+2 existe et qu'il n'est pas en même temps le N+1 de l'agent
            if ($agent->getSansAh() || ($ah && $ah->getUtilisateur() && $destinataire3->getId() != $ah->getUtilisateur()->getId())) {
                if ($destinataire3->isEnabled()) {
                    $body = $this->templating->render($template, array(
                        'campagne' => $campagne,
                        'agent' => $agent,
                        'subject' => $subject,
                    ));
                    $this->sendMessage($destinataire3, $subject, $body);
                }
            }
        }
    }

    /* Notification aux N+1 & N+2 du refus de l'agent de notifier le CREP */
    public function notifierRefusSignatureAgent(Crep $crep)
    {
        $shd = $crep->getShd();
        $agent = $crep->getAgent();
        $nomPrenomAgent = ucfirst($agent->getPrenom()).' '.mb_strtoupper($agent->getNom(), 'UTF-8');

        $campagne = $agent->getCampagneBrhp();
        $subject = $campagne->getLibelle()." : Refus de signature du compte rendu d'évaluation professionnelle par votre agent (".$nomPrenomAgent.')';

        //Envoyer le mail de refus de notification du crep aux BRHPs de la campagne
        $template = 'email/crep/refusSignatureAgentBrhp.html.twig';

        /* @var $brhp Brhp */
        foreach ($campagne->getPerimetreBrhp()->getBrhps() as $brhp) {
            /* @var $destinataire1 Utilisateur */
            $destinataire1 = $brhp->getUtilisateur();

            if ($destinataire1->isEnabled()) {
                $body = $this->templating->render($template, array(
                    'campagne' => $campagne,
                    'crep' => $crep,
                    'shd' => $shd,
                    'agent' => $agent->getUtilisateur(),
                    'destinataire' => $destinataire1,
                    'subject' => $subject,
                ));
                $this->sendMessage($destinataire1, $subject, $body);
            }
        }

        $ah = $agent->getAh();

        //Si l'agent possède un N+2 : Envoyer le mail de refus de notification du crep au N+2
        if ($ah) {
            /* @var $destinataire2 Utilisateur */
            $destinataire2 = $ah->getUtilisateur();

            if ($destinataire2->isEnabled()) {
                $template = 'email/crep/refusSignatureAgentAh.html.twig';
                $body = $this->templating->render($template, array(
                    'campagne' => $campagne,
                    'crep' => $crep,
                    'shd' => $shd,
                    'agent' => $agent->getUtilisateur(),
                    'destinataire' => $destinataire2,
                    'subject' => $subject,
                ));
                $this->sendMessage($destinataire2, $subject, $body);
            }
        }

        //Envoyer le mail de refus de signature du crep à l'agent
        $destinataire3 = $agent->getUtilisateur();

        /* @var $destinataire Utilisateur */
        if ($destinataire3->isEnabled()) {
            $template = 'email/crep/refusSignatureAgent.html.twig';
            $body = $this->templating->render($template, array(
                'campagne' => $campagne,
                'crep' => $crep,
                'shd' => $shd,
                'destinataire' => $destinataire3,
                'subject' => $subject,
            ));
            $this->sendMessage($destinataire3, $subject, $body);
        }
    }

    /* Notification aux N+1 qu'un nouvel agent lui a été rattaché */
    public function notifierAjoutAgentDansListe(Agent $agent)
    {
        $destinataire = $agent->getShd()->getUtilisateur();
        /* @var $destinataire Utilisateur */
        if ($destinataire->isEnabled()) {
            $subject = $agent->getCampagneBrhp()->getLibelle()." : Rattachement d'un nouvel agent";
            $template = 'email/campagneBrhp/ajoutAgentDansListe.html.twig';

            $body = $this->templating->render($template, array(
                    'agent' => $agent,
                    'subject' => $subject,
            ));
            $this->sendMessage($destinataire, $subject, $body);
        }
    }

    /* Notification de l'agent que son CREP a été rappelé par le N+1 */
    public function notifierRappelAgentShd(Crep $crep)
    {
        $agent = $crep->getAgent();

        $nomPrenomShd = AppExtension::identite($agent->getShd());
        $campagne = $crep->getAgent()->getCampagnePnc();

        //Envoyer le mail de rappel du crep par le N+1
        $template = 'email/crep/rappelAgentShd_agent.html.twig';
        $subject = $campagne->getLibelle()." : Rappel du compte rendu d'évaluation professionnelle par votre N+1 (".$nomPrenomShd.')';
        $body = $this->templating->render($template, array(
                'campagne' => $campagne,
                'crep' => $crep,
                'shd' => $agent->getShd()->getUtilisateur(),
                'destinataire' => $agent->getUtilisateur(),
                'subject' => $subject,
        ));

        $this->sendMessage($agent->getUtilisateur(), $subject, $body);
    }

    /* Notification de l'agent et du N+1 que le CREP a été rappelé par le N+2 */
    public function notifierRappelAgentAh(Crep $crep)
    {
        $shd = $crep->getShd();
        $ah = $crep->getAh();
        $agent = $crep->getAgent();

        $nomPrenomAgent = ucfirst($agent->getPrenom()).' '.mb_strtoupper($agent->getNom(), 'UTF-8');
        $nomPrenomAh = ucfirst($ah->getPrenom()).' '.mb_strtoupper($ah->getNom());
        $campagne = $crep->getAgent()->getCampagneBrhp();

        //Envoyer le mail de rappel du crep par le N+2
        $template = 'email/crep/rappelAgentAh_agent.html.twig';
        $subject = $campagne->getLibelle()." : Rappel du compte rendu d'évaluation professionnelle par votre N+2 (".$nomPrenomAh.')';
        $body = $this->templating->render($template, array(
            'campagne' => $campagne,
            'crep' => $crep,
            'ah' => $ah->getUtilisateur(),
            'destinataire' => $agent->getUtilisateur(),
            'subject' => $subject,
        ));

        $this->sendMessage($agent->getUtilisateur(), $subject, $body);

        //Envoyer le mail de rappel du crep par le N+2 au N+1
        //On verifie que le N+2 n'est pas aussi le N+1
        if ($ah->getUtilisateur()->getId() != $shd->getUtilisateur()->getId()) {
            $template = 'email/crep/rappelAgentAh_shd.html.twig';
            $subject = $campagne->getLibelle()." : Rappel du compte rendu d'évaluation professionnelle par le N+2 (".$nomPrenomAh.') de votre agent ('.$nomPrenomAgent.')';
            $body = $this->templating->render($template, array(
                'campagne' => $campagne,
                'crep' => $crep,
                'ah' => $ah,
                'agent' => $agent->getUtilisateur(),
                'destinataire' => $shd->getUtilisateur(),
                'subject' => $subject,
            ));

            $this->sendMessage($shd->getUtilisateur(), $subject, $body);
        }
    }

    public function notifierCloturerCampagnePnc(CampagnePnc $campagnePnc)
    {
        //On notifie uniquement que la chaine RH : PNC, RLC, BRHP et l'adminMin
        $destinataires = $this->getActeursCampagnePnc($campagnePnc, true, true, true, true, false);

        $template = 'email/campagnePnc/clotureCampagne.html.twig';
        $subject = $campagnePnc->getLibelle().' clôturée';

        foreach ($destinataires as $destinataire) {
            $body = $this->templating->render($template, array(
                'campagnePnc' => $campagnePnc,
                'destinataire' => $destinataire,
                'subject' => $subject,
            ));

            $this->sendMessage($destinataire, $subject, $body);
        }
    }

    /*
     * Cette fonction est appelée pour rouvrir une campagne pnc ou rlc
     */
    public function notifierRouvrirCampagne(Campagne $campagne)
    {
        if ($campagne instanceof CampagnePnc) {
            // Récupérer les pnc, rlc et admins ministériels pour les notifier
            $destinataires = $this->getActeursCampagnePnc($campagne, true, true, true, false, false);
        } elseif ($campagne instanceof  CampagneRlc) {
            // Si c'est une campagne Rlc, notifier les brhps uniquement
            $destinataires = $this->getActeursCampagnePnc($campagne->getCampagnePnc(), false, false, false, true, false);
        } else {
            throw new \Exception('Type de campagne inconnu !');
        }

        $subject = $campagne->getLibelle().' rouverte';
        $template = 'email/campagnePnc/reouvertureCampagne.html.twig';

        foreach ($destinataires as $destinataire) {
            $body = $this->templating->render($template, array(
                'campagne' => $campagne,
                'destinataire' => $destinataire,
                'subject' => $subject,
            ));

            $this->sendMessage($destinataire, $subject, $body);
        }
    }

    public function notifierFermerCampagnePnc(CampagnePnc $campagnePnc)
    {
        $destinataires = $this->getActeursCampagnePnc($campagnePnc, true, true, true, true, false);
        $template = 'email/campagnePnc/fermetureCampagne.html.twig';
        $subject = $campagnePnc->getLibelle().' fermée';

        foreach ($destinataires as $destinataire) {
            $body = $this->templating->render($template, array(
                'campagnePnc' => $campagnePnc,
                'destinataire' => $destinataire,
                'subject' => $subject,
            ));

            $this->sendMessage($destinataire, $subject, $body);
        }
    }

    public function notifierAbsenceVisaAgent(Crep $crep)
    {
        $destinataire = $crep->getShd()->getUtilisateur();
        $template = 'email/crep/absenceVisaAgentShd.html.twig';
        $subject = 'Dépassement du délai de visa';

        $body = $this->templating->render($template, array(
                'campagne' => $crep->getAgent()->getCampagnePnc(),
                'agent' => $crep->getAgent(),
                'crep' => $crep,
                'destinataire' => $destinataire,
                'subject' => $subject,
            ));

        $this->sendMessage($destinataire, $subject, $body);
    }

    private function getActeursCampagnePnc(CampagnePnc $campagnePnc, $getPncs = true, $getAdminsMin = true, $getRlcs = true, $getBrhps = true, $getAgents = true)
    {
        $destinataires = array();

        /* @var $utilisateurRepository UtilisateurRepository */
        $utilisateurRepository = $this->em->getRepository('AppBundle:Utilisateur');

        // Récupération des PNC actifs
        if ($getPncs) {
            $pncs = $utilisateurRepository->getPnc($campagnePnc->getMinistere());

            /* @var $utilisateur Utilisateur */
            foreach ($pncs as $utilisateur) {
                $destinataires[$utilisateur->getEmail()] = $utilisateur;
            }
        }

        // Récupération des Admin Min actifs
        if ($getAdminsMin) {
            $adminsMin = $utilisateurRepository->getAdminsMin($campagnePnc->getMinistere());

            /* @var $utilisateur Utilisateur */
            foreach ($adminsMin as $utilisateur) {
                $destinataires[$utilisateur->getEmail()] = $utilisateur;
            }
        }

        // Récupération des RLC actifs
        $perimetresRlc = $campagnePnc->getPerimetresRlc();
        if ($getRlcs) {
            /* @var $perimetreRlc PerimetreRlc */
            foreach ($perimetresRlc as $perimetreRlc) {
                $rlcs = $perimetreRlc->getRlcs();

                foreach ($rlcs as $rlc) {
                    if ($rlc->getUtilisateur() && $rlc->getUtilisateur()->isEnabled()) {
                        $utilisateur = $rlc->getUtilisateur();
                        $destinataires[$utilisateur->getEmail()] = $utilisateur;
                    }
                }
            }
        }

        // Récupération des BRHP actifs
        if ($getBrhps) {
            foreach ($perimetresRlc as $perimetreRlc) {
                $perimetresBrhp = $perimetreRlc->getPerimetresBrhp();

                foreach ($perimetresBrhp as $perimetreBrhp) {
                    $brhps = $perimetreBrhp->getBrhps();
                    foreach ($brhps as $brhp) {
                        if ($brhp->getUtilisateur() && $brhp->getUtilisateur()->isEnabled()) {
                            $utilisateur = $brhp->getUtilisateur();
                            $destinataires[$utilisateur->getEmail()] = $utilisateur;
                        }
                    }
                }
            }
        }

        // Récupération des N+1, N+2 et Agents actifs
        if ($getAgents) {
            $agents = $campagnePnc->getAgents();

            foreach ($agents as $agent) {
                if ($agent->getUtilisateur() && $agent->getUtilisateur()->isEnabled()) {
                    $utilisateur = $agent->getUtilisateur();
                    $destinataires[$utilisateur->getEmail()] = $utilisateur;
                }
            }
        }

        return $destinataires;
    }

    public function notifierDiffuserPopulation(CampagnePnc $campagnePnc)
    {
        $destinataires = array();

        /* @var $utilisateurRepository UtilisateurRepository */
        $utilisateurRepository = $this->em->getRepository('AppBundle:Utilisateur');

        /* @var $campagneRlcRepository CampagneRlcRepository */
        $campagneRlcRepository = $this->em->getRepository('AppBundle:CampagneRlc');

        // Récupération des Administrateurs Ministériels
        $adminsMin = $utilisateurRepository->getAdminsMin($campagnePnc->getMinistere());

        /* @var $utilisateur Utilisateur */
        foreach ($adminsMin as $utilisateur) {
            $destinataires[$utilisateur->getEmail()] = $utilisateur;
        }

        // Récupération des PNC
        $pncs = $utilisateurRepository->getPnc($campagnePnc->getMinistere());

        /* @var $utilisateur Utilisateur */
        foreach ($pncs as $utilisateur) {
            $destinataires[$utilisateur->getEmail()] = $utilisateur;
        }

        // Récupération des RLC et des BRHP
        if (EnumStatutCampagne::OUVERTE == $campagnePnc->getStatut()) {
            /* @var $perimetreRlc PerimetreRlc */
            foreach ($campagnePnc->getPerimetresRlc() as $perimetreRlc) {
                // Récupération des RLC
                $rlcs = $perimetreRlc->getRlcs();

                foreach ($rlcs as $rlc) {
                    if ($rlc->getUtilisateur() && $rlc->getUtilisateur()->isEnabled()) {
                        $destinataires[$rlc->getUtilisateur()->getEmail()] = $rlc->getUtilisateur();
                    }
                }

                // Récupération des BRHP
                /* @var $campagneRlc CampagneRlc */
                $campagneRlc = $campagneRlcRepository->getCampagneRlc($campagnePnc, $perimetreRlc);

                if ($campagneRlc && EnumStatutCampagne::OUVERTE == $campagneRlc->getStatut()) {
                    foreach ($campagneRlc->getPerimetresBrhp() as $perimetreBrhp) {
                        $brhps = $perimetreBrhp->getBrhps();

                        foreach ($brhps as $brhp) {
                            if ($brhp->getUtilisateur() && $brhp->getUtilisateur()->isEnabled()) {
                                $destinataires[$brhp->getUtilisateur()->getEmail()] = $brhp->getUtilisateur();
                            }
                        }
                    }
                }
            }
        }

        // Notification

        $template = 'email/campagneAdminMin/diffusionPopulation.html.twig';
        $subject = $campagnePnc->getLibelle().' : population chargée';

        foreach ($destinataires as $destinataire) {
            $body = $this->templating->render($template, array(
                    'campagne' => $campagnePnc,
                    'destinataire' => $destinataire,
                    'subject' => $subject,
            ));

            $this->sendMessage($destinataire, $subject, $body);
        }
    }

    /**
     * Notifier les admins min d'un ministère de la fin du chargement du fichier d'agents en arrière plan (échec ou succès en fonction du paramètre $succesChargement).
     *
     * @param CampagnePnc $campagnePnc
     * @param bool        $succesChargement : si égale à true, envoyer une notification de succès, sinon une notification d'échec
     */
    public function notifierFinChargementPopulation(CampagnePnc $campagnePnc, $succesChargement)
    {
        /* @var $repositoryUtilisateur UtilisateurRepository */
        $repositoryUtilisateur = $this->em->getRepository('AppBundle:Utilisateur');

        // Récupérer les admin min actifs du ministère
        $adminsMin = $repositoryUtilisateur->getAdminsMin($campagnePnc->getMinistere());

        $template = 'email/chargementFichierPopulation/';
        $template .= $succesChargement ? 'succesLecture.html.twig' : 'echecLecture.html.twig';

        $subject = $campagnePnc->getLibelle().' : ';
        $subject .= $succesChargement ? 'Chargement du fichier d\'agents' : 'Échec du chargement du fichier d\'agents';

        /*@var $perimetres PerimetreBrhp */
        foreach ($adminsMin as $destinataire) {
            $body = $this->templating->render($template, array(
                    'campagne' => $campagnePnc,
                    'destinataire' => $destinataire,
                    'subject' => $subject,
                    'classColorEmail' => $succesChargement ? 'success' : 'danger', // couleur des boutons dans le mail : rouge en cas d'échec du chargement, vert sinon
            ));

            // Envoyer le mail d'ouverture de campagne
            $this->sendMessage($destinataire, $subject, $body);
        }
    }

    /*
     * (non-PHPdoc)
     * @see \FOS\UserBundle\Mailer\MailerInterface::sendConfirmationEmailMessage()
     */
    public function sendConfirmationEmailMessage(UserInterface $user)
    {
        $template = 'email/confirmation_registration.email.twig'; // $this->parameters['confirmation.template'];
        $subject = 'Confirmation de création de compte';

        $url = $this->router->generate('fos_user_resetting_reset', array(
                'token' => $user->getConfirmationToken(),
        ), UrlGeneratorInterface::ABSOLUTE_URL);

        $rendered = $this->templating->render($template, array(
                            'destinataire' => $user,
                            'confirmationUrl' => $url,
                            'subject' => $subject,
        ));

        $this->sendMessage($user, $subject, $rendered);
    }

    /*
     * (non-PHPdoc)
     * @see \FOS\UserBundle\Mailer\MailerInterface::sendResettingEmailMessage()
     */
    public function sendResettingEmailMessage(UserInterface $user)
    {
        if ($user->isEnabled()) {
            $template = 'email/password_resetting.email.twig';
            $subject = 'Oubli de votre mot de passe ';
            $url = $this->router->generate('fos_user_resetting_reset', array(
                    'token' => $user->getConfirmationToken(),
            ), UrlGeneratorInterface::ABSOLUTE_URL);

            $rendered = $this->templating->render($template, array(
                    'destinataire' => $user,
                    'confirmationUrl' => $url,
                    'subject' => $subject,
            ));
            $this->sendMessage($user, $subject, $rendered);
        }
    }
}
