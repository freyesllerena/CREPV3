<?php

namespace AppBundle\Service;

use AppBundle\Entity\CampagneBrhp;
use AppBundle\EnumTypes\EnumStatutCampagne;
use AppBundle\Entity\CampagnePnc;
use AppBundle\Entity\CampagneRlc;
use AppBundle\Entity\Statistiques\StatCampagnePnc;
use AppBundle\Entity\Statistiques\StatCampagneRlc;
use AppBundle\Entity\Statistiques\StatCampagneBrhp;
use Doctrine\ORM\EntityManagerInterface;

class StatistiquesManager
{
    /* @var $crepManager CrepManager */
    protected $crepManager;

    protected $em;

    public function __construct(CrepManager $crepManager, EntityManagerInterface $entityManager)
    {
        $this->crepManager = $crepManager;
        $this->entityManager = $entityManager;
    }

    public function calculer()
    {
        $campagnesPnc = $this->em->getRepository('AppBundle:CampagnePnc')->findByStatut(EnumStatutCampagne::OUVERTE);

        foreach ($campagnesPnc as $campagnePnc) {
            $indicateurs = $this->crepManager->calculIndicateurs($campagnePnc);

            $statCampagnePnc = new StatCampagnePnc();

            $statCampagnePnc->setCampagnePnc($campagnePnc);

            $statCampagnePnc
            ->setNbCrep($indicateurs['nbCrep'])
            ->setNbCrepSignesShd($indicateurs['nbCrepSignesShd'])
            ->setNbCrepVisesAgent($indicateurs['nbCrepVisesAgent'])
            ->setNbCrepSignesAh($indicateurs['nbCrepSignesAh'])
            ->setNbCrepNotifiesAgent($indicateurs['nbCrepNotifies'])
            ->setNbCrepRefusNotifAgent($indicateurs['nbCrepRefusNotification'])
            ->setNbCrepModifiesShd($indicateurs['nbCrepModifieShd'])
            ->setNbCrepRefusVisaAgent($indicateurs['nbCrepRefusVisas'])
            ->setNbCrepCasAbsence($indicateurs['nbCrepCasAbsence'])
            ->setNbCrepNonRenseignes($indicateurs['nbCrepNonRenseignes']);

            $this->em->persist($statCampagnePnc);
        }

        $this->em->flush();

        $campagnesRlc = $this->em->getRepository('AppBundle:CampagneRlc')->findByStatut(EnumStatutCampagne::OUVERTE);

        foreach ($campagnesRlc as $campagneRlc) {
            $indicateurs = $this->crepManager->calculIndicateurs($campagneRlc);

            $statCampagneRlc = new StatCampagneRlc();

            $statCampagneRlc->setCampagneRlc($campagneRlc);

            $statCampagneRlc
            ->setNbCrep($indicateurs['nbCrep'])
            ->setNbCrepSignesShd($indicateurs['nbCrepSignesShd'])
            ->setNbCrepVisesAgent($indicateurs['nbCrepVisesAgent'])
            ->setNbCrepSignesAh($indicateurs['nbCrepSignesAh'])
            ->setNbCrepNotifiesAgent($indicateurs['nbCrepNotifies'])
            ->setNbCrepRefusNotifAgent($indicateurs['nbCrepRefusNotification'])
            ->setNbCrepModifiesShd($indicateurs['nbCrepModifieShd'])
            ->setNbCrepRefusVisaAgent($indicateurs['nbCrepRefusVisas'])
            ->setNbCrepCasAbsence($indicateurs['nbCrepCasAbsence'])
            ->setNbCrepNonRenseignes($indicateurs['nbCrepNonRenseignes']);

            $this->em->persist($statCampagneRlc);
        }

        $this->em->flush();

        $campagnesBrhp = $this->em->getRepository('AppBundle:CampagneBrhp')->findByStatut(EnumStatutCampagne::OUVERTE);

        foreach ($campagnesBrhp as $campagneBrhp) {
            $indicateurs = $this->crepManager->calculIndicateurs($campagneBrhp);

            $statCampagneBrhp = new StatCampagneBrhp();

            $statCampagneBrhp->setCampagneBrhp($campagneBrhp);

            $statCampagneBrhp
            ->setNbCrep($indicateurs['nbCrep'])
            ->setNbCrepSignesShd($indicateurs['nbCrepSignesShd'])
            ->setNbCrepVisesAgent($indicateurs['nbCrepVisesAgent'])
            ->setNbCrepSignesAh($indicateurs['nbCrepSignesAh'])
            ->setNbCrepNotifiesAgent($indicateurs['nbCrepNotifies'])
            ->setNbCrepRefusNotifAgent($indicateurs['nbCrepRefusNotification'])
            ->setNbCrepModifiesShd($indicateurs['nbCrepModifieShd'])
            ->setNbCrepRefusVisaAgent($indicateurs['nbCrepRefusVisas'])
            ->setNbCrepCasAbsence($indicateurs['nbCrepCasAbsence'])
            ->setNbCrepNonRenseignes($indicateurs['nbCrepNonRenseignes']);

            $this->em->persist($statCampagneBrhp);
        }

        $this->em->flush();
    }
}
