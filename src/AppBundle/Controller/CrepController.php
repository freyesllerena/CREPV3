<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Crep;
use AppBundle\Util\Util;
use AppBundle\Security\CrepVoter;
use AppBundle\EnumTypes\EnumStatutCrep;
use Knp\Snappy\Pdf;
use AppBundle\Service\CrepManager;
use AppBundle\Entity\Agent;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use AppBundle\Entity\ModeleCrep;
use AppBundle\Entity\CampagnePnc;
use AppBundle\Security\ModeleCrepVoter;
use AppBundle\Twig\AppExtension;
use AppBundle\Service\CrepConfidentialisationManager;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\EnumTypes\EnumStatutCampagne;

/**
 * Class CrepController
 *
 * @package AppBundle\Controller
 */
class CrepController extends Controller
{
    /**
     * Finds and displays a Crep entity.
     *
     * @param Crep $crep
     * @param CrepConfidentialisationManager $crepConfidentialisationManager
     *
     * @return Response
     */
    public function showAction(Crep $crep, CrepConfidentialisationManager $crepConfidentialisationManager, EntityManagerInterface $em)
    {
        //Voter
        $this->denyAccessUnlessGranted(CrepVoter::VOIR, $crep);

        // Si l'utilisateur est l'agent et qu'il consulte son CREP pour la première fois
        // On enregistre la date de consultation
        if(EnumStatutCrep::SIGNE_SHD == $crep->getStatut() 
        		&& $crep->getAgent()->getUtilisateur() === $this->getUser() 
        		&& null === $crep->getDateConsultationAgent()){
        	$crep->setDateConsultationAgent(new \DateTime());
        	$em->flush();
        }
        
        $repertoireVuesCrep = lcfirst(Util::getClassName($crep));

        $reinitialiserForm = $this->createReinitialiserForm($crep);
        $supprimerForm = $this->createSupprimerForm($crep);
        $refaireForm = $this->createRefaireCrepForm($crep);
        $laisserCrepEnEtatForm = $this->createLaisserCrepEnEtatForm($crep);

        if (!$crep->getCrepPapier()) {
            $role = $this->get('session')->get('selectedRole');
            $role = strtolower(str_replace('ROLE_', '', $role));

            if ('brhp_consult' === $role) {
                $role = 'brhp';
            }

            // Ici nous utilisons le service d'anomysation du crep en fonction du statut du crep
            $crepConfidentialisationManager->confidentialisation($crep, $this->getUser());
            
            $signerShdForm = $this->createEditForm($crep, [
                'action' => $this->generateUrl('crep_signer_shd', ['id' => $crep->getId()]),
                'validation_groups' => ['registration']
            ]);
            
            $refuserVisaForm = $this->creerRefuserVisaForm($crep);
            $refuserNotificationForm = $this->creerRefuserNotificationForm($crep);
            $viserAgentForm = $this->creerViserAgentForm($crep);
            $signerAhForm = $this->creerSignerAhForm($crep);
            $notifierAgentForm = $this->creerNotifierAgentForm($crep);
            $rappelerAgentShdForm = $this->creerRapplerAgentShdForm($crep);
            $rappelerAgentAhForm = $this->creerRapplerAgentAhForm($crep);

            if ('ROLE_ADMIN' == $this->get('session')->get('selectedRole')) {
                $template = 'crep/'.$repertoireVuesCrep.'/show.html.twig';
            } else {
                $template = 'crep/'.$repertoireVuesCrep.'/'.$role.'/show.html.twig';
            }

            return $this->render($template, array(
                    'crep' => $crep,
                    'errors' => null,
                    'signer_shd_form' => $signerShdForm->createView(),
                    'refuser_visa_form' => $refuserVisaForm->createView(),
                    'refuser_notification_form' => $refuserNotificationForm->createView(),
                    'viser_agent_form' => $viserAgentForm->createView(),
                    'signer_ah_form' => $signerAhForm->createView(),
                    'notifier_agent_form' => $notifierAgentForm->createView(),
                    'rappeler_agent_shd_form' => $rappelerAgentShdForm->createView(),
                    'rappeler_agent_ah_form' => $rappelerAgentAhForm->createView(),
                    'reinitialiser_crep_form' => $reinitialiserForm->createView(),
                    'supprimer_crep_form' => $supprimerForm->createView(),
                    'refaire_crep_form' => $refaireForm->createView(),
                    'laisser_crep_en_etat' => $laisserCrepEnEtatForm->createView(),
            ));
        } else {
            return $this->render(
            'crep/showCrepPapier.html.twig',
                             [
                                'crep' => $crep,
                                'reinitialiser_crep_form' => $reinitialiserForm->createView(),
                                'supprimer_crep_form' => $supprimerForm->createView(),
                                'refaire_crep_form' => $refaireForm->createView(),
                                'laisser_crep_en_etat' => $laisserCrepEnEtatForm->createView(),
                             ]
            );
        }
    }

    /**
     * Show Crep Papier Action
     *
     * @param Crep $crep
     *
     * @return Response
     */
    public function showCrepPapierAction(Crep $crep)
    {
        //Voter
        $this->denyAccessUnlessGranted(CrepVoter::VOIR, $crep);
        $filename = $crep->getCrepPapier()->getWebPath();
        $response = new Response(file_get_contents($filename));
//        $disposition = $response->headers->set('Content-Type', 'application/pdf');
        $disposition = $response->headers->makeDisposition(
                ResponseHeaderBag::DISPOSITION_INLINE,
                ''
        );

        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }

    /**
     * @Security("has_role('ROLE_USER')")
     * Displays a form to edit an existing CrepMindef01 entity.
     *
     * @param Request $request
     * @param Crep $crep
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Request $request, Crep $crep)
    {
        //Voter
        $this->denyAccessUnlessGranted(CrepVoter::EDIT, $crep);
        $role = $this->get('session')->get('selectedRole');
        $role = strtolower(str_replace('ROLE_', '', $role));
        
        $editForm = $this->createEditForm($crep, [
            'action' => $this->generateUrl('crep_edit', ['id' => $crep->getId()])
        ]);
        
        $editForm->handleRequest($request);
        
        
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            if (EnumStatutCrep::CREE == $crep->getStatut()) {
                $crep->setStatut(EnumStatutCrep::MODIFIE_SHD);
            }
            
            $em->persist($crep);
            $em->flush();
            $flashbagMessage = 'Le CREP a bien été enregistré !';
            $this->get('session')->getFlashBag()->set('notice', $flashbagMessage);

            return $this->redirectToRoute('crep_show', array(
                    'id' => $crep->getId(),
            ));
        }

        $formErrors = $editForm->getErrors(true);
        $repertoireVuesCrep = lcfirst(Util::getClassName($crep));

        return $this->render('crep/'.$repertoireVuesCrep.'/'.$role.'/edit.html.twig', array(
                'crep' => $crep,
                'form' => $editForm->createView(),
                'action' => 'EDIT',
                'errors' => $formErrors,
        ));
    }

    /**
     * Signer N+1.
     *
     * @Security("has_role('ROLE_SHD')")
     *
     * @param Crep $crep
     * @param CrepManager $crepManager
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function signerShdAction(Request $request, Crep $crep, CrepManager $crepManager)
    {
        //Voter
        $this->denyAccessUnlessGranted(CrepVoter::SIGNER_SHD, $crep);
        
        $editForm = $this->createEditForm($crep, [
            'action' => $this->generateUrl('crep_edit', ['id' => $crep->getId()]),
            'validation_groups' => ['SignatureShd', 'Default']
        ]);
        
        
        $editForm->handleRequest($request);
        
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $crepManager->signerShd($crep);
            $this
            ->get('session')
            ->getFlashBag()
            ->set('notice', "CREP signé et transmis à l'agent !")
            ;
            
            return $this->redirectToRoute('campagne_shd_show', array('id' => $crep->getAgent()->getCampagneBrhp()->getId()));
        }
        
        $role = $this->get('session')->get('selectedRole');
        $role = strtolower(str_replace('ROLE_', '', $role));
        $formErrors = $editForm->getErrors(true);
        $repertoireVuesCrep = lcfirst(Util::getClassName($crep));
        
        return $this->render('crep/'.$repertoireVuesCrep.'/'.$role.'/edit.html.twig', array(
            'crep' => $crep,
            'form' => $editForm->createView(),
            'action' => 'SIGNER_SHD',
            'errors' => $formErrors,
        ));

    }

    /**
     * Viser agent.
     *
     * @Security("has_role('ROLE_AGENT')")
     *
     * @param Crep $crep
     * @param CrepManager $crepManager
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function viserAgentAction(Crep $crep, CrepManager $crepManager)
    {
        //Voter
        $this->denyAccessUnlessGranted(CrepVoter::VISER_AGENT, $crep);
        $crepManager->viserAgent($crep);
        $this
                ->get('session')
                ->getFlashBag()
                ->set('notice', 'CREP visé et transmis au N+2 !')
        ;

        return $this->redirectToRoute('crep_show', array('id' => $crep->getId()));
    }

    /**
     * Signer N+2.
     *
     * @Security("has_role('ROLE_AH')")
     *
     * @param Crep $crep
     * @param CrepManager $crepManager
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function signerAhAction(Crep $crep, CrepManager $crepManager)
    {
        //Voter
        $this->denyAccessUnlessGranted(CrepVoter::SIGNER_AH, $crep);
        $crepManager->signerAh($crep);
        $this
                ->get('session')
                ->getFlashBag()
                ->set('notice', "CREP signé et transmis à l'agent !")
        ;

        return $this->redirectToRoute('campagne_ah_show', array('id' => $crep->getAgent()->getCampagneBrhp()->getId()));
    }

    /**
     * Notifier agent.
     *
     * @Security("has_role('ROLE_AGENT')")
     *
     * @param Crep $crep
     * @param CrepManager $crepManager
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function notifierAgentAction(Crep $crep, CrepManager $crepManager)
    {
        //Voter
        $this->denyAccessUnlessGranted(CrepVoter::NOTIFIER_AGENT, $crep);

        $crepManager->signerDefinitivementAgent($crep);

        $this
                ->get('session')
                ->getFlashBag()
                ->set('notice', 'CREP signé et finalisé !')
        ;

        return $this->redirectToRoute('crep_show', array('id' => $crep->getId()));
    }

    /**
     * Refuser visa.
     *
     * @Security("has_role('ROLE_SHD')")
     *
     * @param Crep $crep
     * @param CrepManager $crepManager
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function refuserVisaAction(Crep $crep, CrepManager $crepManager)
    {
        //Voter
        $this->denyAccessUnlessGranted(CrepVoter::REFUSER_VISA_AGENT, $crep);

        $crepManager->refuserVisa($crep);

        $this->get('session')->getFlashBag()->set('notice', "Refus de visa du CREP par l'agent acté !");

        return $this->redirectToRoute('crep_show', array('id' => $crep->getId()));
    }

    /**
     * Refuser notification.
     *
     * @Security("has_role('ROLE_SHD')")
     *
     * @param Crep $crep
     * @param CrepManager $crepManager
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function refuserNotificationAction(Crep $crep, CrepManager $crepManager)
    {
        //Voter
        $this->denyAccessUnlessGranted(CrepVoter::REFUSER_NOTIFICATION_AGENT, $crep);

        $crepManager->refuserNotification($crep);

        $this->get('session')->getFlashBag()->set('notice', "Refus de notification du CREP par l'agent acté !");

        return $this->redirectToRoute('crep_show', array('id' => $crep->getId()));
    }

    /**
     * Render in a PDF the export_pdf URL.
     *
     * @param Crep $crep
     * @param CrepManager $crepManager
     * @return \AppBundle\Entity\Document|Response
     *
     * @throws \Exception
     */
    public function pdfExportAction(Crep $crep, CrepManager $crepManager)
    {
        //Voter
        $this->denyAccessUnlessGranted(CrepVoter::EXPORTER_PDF, $crep);

        if (in_array($crep->getStatut(), [EnumStatutCrep::NOTIFIE_AGENT, EnumStatutCrep::REFUS_NOTIFICATION_AGENT]) && $crep->getCrepPdf()) {
            $filename = $crep->getCrepPdf()->getWebPath();

            return new Response(
                file_get_contents($filename),

                200,
                    array('Content-Type' => 'application/pdf',
                            'Content-Disposition' => 'attachment; filename="'.$crep->getCrepPdf()->getNom().'"',
                    )
            );
        }

        return $crepManager->genererCrepPdf($crep, 'D');
    }

    /**
     * Action de renvoi du CREP au N+1 quand l'agent n'est pas d'accord avec le contenu du CREP.
     *
     * @Security("has_role('ROLE_AGENT')")
     *
     * @param Request $request
     * @param Crep $crep
     * @param CrepManager $crepManager
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function renvoyerAgentShdAction(Request $request, Crep $crep, CrepManager $crepManager)
    {
        //Voter
        $this->denyAccessUnlessGranted(CrepVoter::RENVOYER_AGENT_SHD, $crep);

        $renvoyerAgentForm = $this->createForm('AppBundle\Form\RenvoiAgentType', $crep);
        $renvoyerAgentForm->handleRequest($request);

        if ($renvoyerAgentForm->isSubmitted() && $renvoyerAgentForm->isValid()) {
            $crepManager->renvoyerAgentShd($crep);

            $this->get('session')->getFlashBag()->set('notice', 'CREP renvoyé au N+1 !');

            return $this->redirectToRoute('crep_show', array('id' => $crep->getId()));
        }

        return $this->render('crep/motifRenvoiAgent.html.twig', array(
                    'renvoyer_agent_form' => $renvoyerAgentForm->createView(),
        ));
    }

    /**
     * Action de renvoi du CREP au N+1 quand le N+2 n'est pas d'accord avec le contenu du CREP.
     *
     * @Security("has_role('ROLE_AH')")
     *
     * @param Request $request
     * @param Crep $crep
     * @param CrepManager $crepManager
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function renvoyerAhShdAction(Request $request, Crep $crep, CrepManager $crepManager)
    {
        //Voter
        $this->denyAccessUnlessGranted(CrepVoter::RENVOYER_AH_SHD, $crep);

        $renvoyerAhForm = $this->createForm('AppBundle\Form\RenvoiAhType', $crep);
        $renvoyerAhForm->handleRequest($request);

        if ($renvoyerAhForm->isSubmitted() && $renvoyerAhForm->isValid()) {
            $crepManager->renvoyerAhShd($crep);

            $this->get('session')->getFlashBag()->set('notice', 'CREP renvoyé au N+1 !');

            return $this->redirectToRoute('crep_show', array('id' => $crep->getId()));
        }

        return $this->render('crep/motifRenvoiAh.html.twig', array(
            'renvoyer_ah_form' => $renvoyerAhForm->createView(),
        ));
    }


    /**
     * Génére le formulaire de refus de visa de l'agent.
     *
     * @param Crep $crep
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    protected function creerRefuserVisaForm(Crep $crep)
    {
        return $this
        ->createFormBuilder()
        ->setAction($this->generateUrl('crep_refuser_visa', array(
            'id' => $crep->getId(),
        )))
        ->setMethod('PUT')
        ->getForm()
        ;
    }

    /**
     * Génére le formulaire de refus de notification de l'agent.
     *
     * @param Crep $crep
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    protected function creerRefuserNotificationForm(Crep $crep)
    {
        return $this
        ->createFormBuilder()
        ->setAction($this->generateUrl('crep_refuser_notification', array(
            'id' => $crep->getId(),
        )))
        ->setMethod('PUT')
        ->getForm()
        ;
    }

    /**
     * Génére le formulaire de rappel du CREP de l'agent vers le N+1.
     *
     * @param Crep $crep
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    protected function creerRapplerAgentShdForm(Crep $crep)
    {
        return $this
        ->createFormBuilder()
        ->setAction($this->generateUrl('crep_rappeler_agent_shd', array(
                'id' => $crep->getId(),
        )))
        ->setMethod('PUT')
        ->getForm()
        ;
    }

    /**
     * Génére le formulaire de rappel du CREP de l'agent vers le N+2.
     *
     * @param Crep $crep
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    protected function creerRapplerAgentAhForm(Crep $crep)
    {
        return $this
        ->createFormBuilder()
        ->setAction($this->generateUrl('crep_rappeler_agent_ah', array(
            'id' => $crep->getId(),
        )))
        ->setMethod('PUT')
        ->getForm()
        ;
    }

    /**
     * Génére le formulaire du visa de l'agent.
     *
     * @param Crep $crep
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    protected function creerViserAgentForm(Crep $crep)
    {
        return $this
                        ->createFormBuilder()
                        ->setAction($this->generateUrl('crep_viser_agent', array(
                                    'id' => $crep->getId(),
                        )))
                        ->setMethod('PUT')
                        ->getForm()
        ;
    }

    /**
     * Génére le formulaire de signature du Ah.
     *
     * @param Crep $crep
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    protected function creerSignerAhForm(Crep $crep)
    {
        return $this
                        ->createFormBuilder()
                        ->setAction($this->generateUrl('crep_signer_ah', array(
                                    'id' => $crep->getId(),
                        )))
                        ->setMethod('PUT')
                        ->getForm()
        ;
    }

    /**
     * Génére le formulaire de notification de l'agent.
     *
     * @param Crep $crep
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    protected function creerNotifierAgentForm(Crep $crep)
    {
        return $this
                    ->createFormBuilder()
                    ->setAction($this->generateUrl('crep_notifier_agent', array(
                                'id' => $crep->getId(),
                    )))
                    ->setMethod('PUT')
                    ->getForm();
    }

    protected function createReinitialiserForm(Crep $crep)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('reinitialiser_crep', array('id' => $crep->getId())))
        ->setMethod('DELETE')
        ->getForm()
        ;
    }

    protected function createSupprimerForm(Crep $crep)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('supprimer_crep', array('id' => $crep->getId())))
        ->setMethod('DELETE')
        ->getForm()
        ;
    }

    protected function createRefaireCrepForm(Crep $crep)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('refaire_crep', array('id' => $crep->getId())))
        ->setMethod('PUT')
        ->getForm()
        ;
    }

    /**
     * @param Crep $crep
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createEditForm(Crep $crep, $options=[])
    {
        $classeCrep = Util::getClassName($crep);

        $role = $this->get('session')->get('selectedRole');
        
        if($role === 'ROLE_SHD'){
            $editForm = $this->createForm('AppBundle\Form\Crep\\'.$classeCrep.'\\'.$classeCrep.'Type', $crep, $options);
        }elseif ($role === 'ROLE_AGENT'){
            $editForm = $this->createForm('AppBundle\Form\Crep\\'.$classeCrep.'\\'.$classeCrep.'AgentType', $crep, $options);
        }elseif ($role === 'ROLE_AH') {
            $editForm = $this->createForm('AppBundle\Form\Crep\\' . $classeCrep . '\\' . $classeCrep . 'AhType', $crep, $options);
        }else{
            throw new \Exception("Le role de l'utilisarteur doit être ROLE_SHD, ROLE_AGENT ou ROLE_AH");
        }

        return $editForm;
    }

    /**
     * Rappeler le CREP de l'agent vers le N+1 (action du N+1).
     *
     * @Security("has_role('ROLE_SHD')")
     *
     * @param Crep $crep
     * @param CrepManager $crepManager
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function rappelerAgentShdAction(Crep $crep, CrepManager $crepManager)
    {
        //Voter
        $this->denyAccessUnlessGranted(CrepVoter::RAPPELER_AGENT_SHD, $crep);

        $crepManager->rappelerAgentShd($crep);

        $this
        ->get('session')
        ->getFlashBag()
        ->set('notice', 'CREP rappelé avec succès !')
        ;

        return $this->redirectToRoute('crep_show', array('id' => $crep->getId()));
    }

    /**
     * Rappeler le CREP de l'agent vers le N+2 (action du N+2).
     *
     * @Security("has_role('ROLE_AH')")
     *
     * @param Crep $crep
     * @param CrepManager $crepManager
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function rappelerAgentAhAction(Crep $crep, CrepManager $crepManager)
    {
        //Voter
        $this->denyAccessUnlessGranted(CrepVoter::RAPPELER_AGENT_AH, $crep);

        $crepManager->rappelerAgentAh($crep);

        $this
        ->get('session')
        ->getFlashBag()
        ->set('notice', 'CREP rappelé avec succès !')
        ;

        return $this->redirectToRoute('crep_show', array('id' => $crep->getId()));
    }

    /**
     * réinitialiser un CREP d'un agent par son SHD, pour lui choisir un autre formulaire.
     *
     * @Security("has_role('ROLE_SHD')")
     *
     * @param Request $request
     * @param Crep $crep
     * @param CrepManager $crepManager
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function reinitialiserCrepAction(Request $request, Crep $crep, CrepManager $crepManager)
    {
        //Voter
        $this->denyAccessUnlessGranted(CrepVoter::REINITIALISER, $crep);

        $form = $this->createReinitialiserForm($crep);
        $form->handleRequest($request);

        if ($form->isValid()) {
            /* @var $agent Agent */
            $agent = $crep->getAgent();
            $campagneBrhp = $agent->getCampagneBrhp();

            $crepManager->supprimerCrep($crep);

            $this->get('session')->getFlashBag()->set('notice', 'Le CREP de '.AppExtension::identite($agent).' a été réinitialisé avec succès !');

            return $this->redirectToRoute('campagne_shd_show', ['id' => $campagneBrhp->getId()]);
        }

        $this->get('session')->getFlashBag()->set('warning', 'Echec de la réinitialisation du CREP');

        return $this->redirectToRoute('crep_show', ['id' => $crep->getId()]);
    }

    /**
     * Supprimer un CREP par le RLC suite à un recours.
     *
     * @param Request $request
     * @param Crep $crep
     * @param CrepManager $crepManager
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function supprimerCrepAction(Request $request, Crep $crep, CrepManager $crepManager)
    {
        //Voter
        $this->denyAccessUnlessGranted(CrepVoter::SUPPRIMER, $crep);

        $form = $this->createSupprimerForm($crep);
        $form->handleRequest($request);

        if ($form->isValid()) {
            /* @var $agent Agent */
            $agent = $crep->getAgent();
            $campagneRlc = $agent->getCampagneRlc();

            $crepManager->supprimerCrep($crep);

            $this->get('session')->getFlashBag()->set('notice', 'Le CREP de '.AppExtension::identite($agent).' a été supprimé avec succès !');

            return $this->redirectToRoute('campagne_rlc_show', ['id' => $campagneRlc->getId()]);
        }

        $this->get('session')->getFlashBag()->set('warning', 'Echec de la réinitialisation du CREP');

        return $this->redirectToRoute('crep_show', ['id' => $crep->getId()]);
    }

    /**
     * Exporter Crep Vierge Action
     *
     * @param ModeleCrep $modele
     * @param CampagnePnc $campagnePnc
     * @param CrepManager $crepManager
     * @return \AppBundle\Entity\Document
     *
     * @throws \Exception
     */
    public function exporterCrepViergeAction(ModeleCrep $modele, CampagnePnc $campagnePnc, CrepManager $crepManager)
    {
        $this->denyAccessUnlessGranted(ModeleCrepVoter::EXPORTER_MODELE_VIERGE, $modele);
        $classe = $modele->getTypeEntity();
        $classPath = 'AppBundle\Entity\Crep\\'.$classe.'\\'.$classe;
        $crep = new $classPath();
        $crep->setModeleCrep($modele);
        $agent = new Agent();
        $agent->setCampagnePnc($campagnePnc);
        $em = $this->getDoctrine()->getManager();
        $crep->initialiser($agent, $em);

        return $crepManager->genererCrepPdf($crep, 'D');
    }

    /**
     * Reefaire Crep Action
     *
     * @param Request $request
     * @param Crep $crep
     * @param CrepManager $crepManager
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function refaireCrepAction(Request $request, Crep $crep, CrepManager $crepManager)
    {
        $this->denyAccessUnlessGranted(CrepVoter::REFAIRE_CREP, $crep);
        $form = $this->createRefaireCrepForm($crep);
        $form->handleRequest($request);

        if ($form->isValid()) {
            // Supprimer les différentes signatures
            $crepManager->devaliderCrep($crep);
            $this->get('session')->getFlashBag()->set('notice', 'Le CREP de '.AppExtension::identite($crep->getAgent()).' a été dévalidé avec succès !');

            return $this->redirectToRoute('campagne_brhp_show', ['id' => $crep->getAgent()->getCampagneBrhp()->getId()]);
        }

        $this->get('session')->getFlashBag()->set('warning', 'Echec de la dévalidation du CREP');

        return $this->redirectToRoute('crep_show', ['id' => $crep->getId()]);
    }

    /**
     * Cette action permet d'acter de laisser un CREP en l'état suite un recours. Cela revient à valider tous les recours liés au CREP.
     *
     * @param Request $request
     * @param Crep $crep
     * @param CrepManager $crepManager
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function laisserCrepEnEtatAction(Request $request, Crep $crep, CrepManager $crepManager)
    {
        $this->denyAccessUnlessGranted(CrepVoter::LAISSER_CREP_EN_ETAT, $crep);

        $form = $this->createLaisserCrepEnEtatForm($crep);
        $form->handleRequest($request);

        if ($form->isValid()) {
            // Valider tous les recours du CREP
            $crepManager->laisserCrepEnEtat($crep);

            $this->get('session')->getFlashBag()->set('notice', 'Le CREP de '.AppExtension::identite($crep->getAgent())." a été laissé en l'état suite à lé décision du recours !");

            return $this->redirectToRoute('crep_show', ['id' => $crep->getId()]);
        }

        $this->get('session')->getFlashBag()->set('warning', 'Action échouée');

        return $this->redirectToRoute('crep_show', ['id' => $crep->getId()]);
    }

    protected function createLaisserCrepEnEtatForm(Crep $crep)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('laisser_crep_en_etat', array('id' => $crep->getId())))
        ->setMethod('PUT')
        ->getForm()
        ;
    }
}
