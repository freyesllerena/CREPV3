<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\EnumTypes\EnumRole;
use AppBundle\Entity\CampagnePnc;
use AppBundle\Entity\CampagneBrhp;
use AppBundle\Entity\Utilisateur;
use AppBundle\EnumTypes\EnumStatutCampagne;
use AppBundle\Entity\CampagneRlc;
use AppBundle\EnumTypes\EnumStatutCrep;
use AppBundle\Repository\CampagneBrhpRepository;

class CampagneController extends Controller
{
    public function campagnesRecentesAction($max = 10)
    {
        $em = $this->getDoctrine()->getManager();

        //récupérer le role de l'utilisateur
        $roleUtilisateur = $this->get('session')->get('selectedRole');

        /* @var $utilisateurCourant Utilisateur  */
        $utilisateurCourant = $this->getUser();
        $ministere = $utilisateurCourant->getMinistere();

        $indicateurs = array();

        switch ($roleUtilisateur) {
            case EnumRole::ROLE_ADMIN:
                $campagnes = $em->getRepository('AppBundle:CampagnePnc')->findCampagnesRecentes($utilisateurCourant, $max);
                $vue = 'campagneAdmin/campagnesRecentes.html.twig';
                break;

            case EnumRole::ROLE_ADMIN_MIN:
                    $repository = $em->getRepository('AppBundle:CampagnePnc');
                    $campagnes = $repository->findCampagnesRecentesAdminMin($utilisateurCourant, $max);
                    $vue = 'campagneAdminMin/campagnesRecentes.html.twig';
                    /* Indicateurs du tableau de bord */
                    $indicateurs['nbCampagnesCreees'] = $repository->countCampagnesPnc($ministere, EnumStatutCampagne::CREEE);
                    $indicateurs['nbCampagnesOuvertes'] = $repository->countCampagnesPnc($ministere, EnumStatutCampagne::OUVERTE);
                    $indicateurs['nbCampagnesCloturees'] = $repository->countCampagnesPnc($ministere, EnumStatutCampagne::CLOTUREE);
                    $indicateurs['nbCampagnesTerminees'] = $repository->countCampagnesPnc($ministere, EnumStatutCampagne::FERMEE);
                    break;
            case EnumRole::ROLE_PNC:
                $repository = $em->getRepository('AppBundle:CampagnePnc');
                $campagnes = $repository->findCampagnesRecentes($utilisateurCourant, $max);
                $vue = 'campagnePnc/campagnesRecentes.html.twig';
                /* Indicateurs du tableau de bord */
                $indicateurs['nbCampagnesCreees'] = $repository->countCampagnesPnc($ministere, EnumStatutCampagne::CREEE);
                $indicateurs['nbCampagnesOuvertes'] = $repository->countCampagnesPnc($ministere, EnumStatutCampagne::OUVERTE);
                $indicateurs['nbCampagnesCloturees'] = $repository->countCampagnesPnc($ministere, EnumStatutCampagne::CLOTUREE);
                $indicateurs['nbCampagnesTerminees'] = $repository->countCampagnesPnc($ministere, EnumStatutCampagne::FERMEE);
                break;

            case EnumRole::ROLE_RLC:
                /* @var $repository CampagneRlc */
                $repository = $em->getRepository('AppBundle:CampagneRlc');
                $campagnes = $repository->findCampagnesRecentes($utilisateurCourant, $max);
                $vue = 'campagneRlc/campagnesRecentes.html.twig';
                /* Indicateurs du tableau de bord */
                $indicateurs['nbCampagnesInitialisees'] = $repository->countCampagnesRlc($utilisateurCourant, EnumStatutCampagne::INITIALISEE);
                $indicateurs['nbCampagnesCreees'] = $repository->countCampagnesRlc($utilisateurCourant, EnumStatutCampagne::CREEE);
                $indicateurs['nbCampagnesOuvertes'] = $repository->countCampagnesRlc($utilisateurCourant, EnumStatutCampagne::OUVERTE);
                $indicateurs['nbCampagnesTerminees'] = $repository->countCampagnesRlc($utilisateurCourant, EnumStatutCampagne::FERMEE);

                break;

            case EnumRole::ROLE_BRHP:
            case EnumRole::ROLE_BRHP_CONSULT:
                /* @var $repository CampagneBrhp */
                $repository = $em->getRepository('AppBundle:CampagneBrhp');
                $campagnes = $repository->findCampagnesRecentesBrhp($utilisateurCourant, $this->get('session')->get('selectedRole'), $max);
                $vue = 'campagneBrhp/campagnesRecentes.html.twig';

                break;

            case EnumRole::ROLE_SHD:
                /* @var $repository CampagneBrhpRepository */ 
                $repository = $em->getRepository('AppBundle:CampagneBrhp');
                $campagnes = $repository->findCampagnesRecentesShd($utilisateurCourant, $this->get('session')->get('selectedRole'), $max);
                $vue = 'campagneShd/campagnesRecentes.html.twig';
                /* Indicateurs du tableau de bord */
                $indicateurs['nbCampagnesOuvertes'] = $repository->countCampagnesShd($utilisateurCourant, EnumStatutCampagne::OUVERTE);
                $indicateurs['nbCampagnesCloturees'] = $repository->countCampagnesShd($utilisateurCourant, EnumStatutCampagne::CLOTUREE);
                $indicateurs['nbCampagnesTerminees'] = $repository->countCampagnesShd($utilisateurCourant, EnumStatutCampagne::FERMEE);

                break;

            case EnumRole::ROLE_AH:
                /* @var $repository CampagneBrhp */
                $repository = $em->getRepository('AppBundle:CampagneBrhp');
                $campagnes = $repository->findCampagnesRecentesAh($utilisateurCourant, $this->get('session')->get('selectedRole'), $max);
                $vue = 'campagneAh/campagnesRecentes.html.twig';
                /* Indicateurs du tableau de bord */
                $indicateurs['nbCampagnesOuvertes'] = $repository->countCampagnesAh($utilisateurCourant, EnumStatutCampagne::OUVERTE);
                $indicateurs['nbCampagnesCloturees'] = $repository->countCampagnesAh($utilisateurCourant, EnumStatutCampagne::CLOTUREE);
                $indicateurs['nbCampagnesTerminees'] = $repository->countCampagnesAh($utilisateurCourant, EnumStatutCampagne::FERMEE);

                break;

          case EnumRole::ROLE_AGENT:
                $campagnes = $em->getRepository('AppBundle:CampagneBrhp')->findCampagnesRecentesAgent($utilisateurCourant, $max);
                $crepRepository = $em->getRepository('AppBundle:Crep');
                $vue = 'campagneAgent/campagnesRecentes.html.twig';
                /* Indicateurs du tableau de bord */
                $indicateurs['nbCrepsVises'] = $crepRepository->getNbCrepsAgent($utilisateurCourant, EnumStatutCrep::VISE_AGENT);
                $indicateurs['nbCrepsRefusVisa'] = $crepRepository->getNbCrepsAgent($utilisateurCourant, EnumStatutCrep::REFUS_VISA_AGENT);
                $indicateurs['nbCrepsNotifies'] = $crepRepository->getNbCrepsAgent($utilisateurCourant, EnumStatutCrep::NOTIFIE_AGENT);
                $indicateurs['nbCrepsRefusNotification'] = $crepRepository->getNbCrepsAgent($utilisateurCourant, EnumStatutCrep::REFUS_NOTIFICATION_AGENT);

                break;

            default: $this->createAccessDeniedException();
        }

        return $this->render($vue, array('campagnes' => $campagnes, 'indicateurs' => $indicateurs));
    }
}
