<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\CampagneRlc;
use AppBundle\EnumTypes\EnumStatutCampagne;

class CampagneRlcData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        return;
        // 		$campagne1 = $this->createNewCampagne('CampagneRlc1', new \DateTime('2016-01-01'), new \DateTime('2016-10-30'), EnumStatutCampagne::CREEE, "perimetreRlcIDF","CampagnePnc1");
// 		$manager->persist ( $campagne1 );

// 		$campagne2 = $this->createNewCampagne('CampagneRlc2', new \DateTime('2016-01-10'), new \DateTime('2016-02-26'),EnumStatutCampagne::CREEE, "perimetreRlcIDF","CampagnePnc1");
// 		$manager->persist ( $campagne2 );

// 		$campagne3 = $this->createNewCampagne('CampagneRlc3', new \DateTime('2016-01-12'), new \DateTime('2016-11-26'), EnumStatutCampagne::CREEE, "perimetreRlcCentre","CampagnePnc3");
// 		$manager->persist ( $campagne3 );

// 		$manager->flush();

// 		$this->addReference('CampagneRlc1', $campagne1);
// 		$this->addReference('CampagneRlc2', $campagne2);
// 		$this->addReference('CampagneRlc3', $campagne3);
    }

    public function getOrder()
    {
        return 7;
    }

    private function createNewCampagne($libelle, $dateDebut, $dateFin, $statut, $perimetre_rlc, $campagne_pnc)
    {
        $campagneRlc = new CampagneRlc();
        $campagneRlc->setLibelle($libelle);
        $campagneRlc->setDateDebut($dateDebut);
        $campagneRlc->setDateFin($dateFin);
        $campagneRlc->setStatut($statut);
        $campagneRlc->setPerimetreRlc($this->getReference($perimetre_rlc));
        $campagneRlc->setCampagnePnc($this->getReference($campagne_pnc));

        return $campagneRlc;
    }
}
