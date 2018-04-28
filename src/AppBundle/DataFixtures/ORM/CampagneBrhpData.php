<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\CampagneBrhp;
use AppBundle\EnumTypes\EnumStatutCampagne;

class CampagneBrhpData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        return;
        // 		$campagne1 = $this->createNewCampagne('CampagneBrhp1', new \DateTime('2016-01-01'), new \DateTime('2016-10-30'), EnumStatutCampagne::CREEE, "perimetreBrhpParis", "CampagneRlc1");
// 		$manager->persist ( $campagne1 );

// 		$campagne2 = $this->createNewCampagne('CampagneBrhp2', new \DateTime('2016-01-12'), new \DateTime('2016-02-26'),EnumStatutCampagne::CREEE, "perimetreBrhpCergy", "CampagneRlc1");
// 		$manager->persist ( $campagne2 );

// 		$campagne3 = $this->createNewCampagne('CampagneBrhp3', new \DateTime('2016-01-12'), new \DateTime('2016-11-26'), EnumStatutCampagne::CREEE, "perimetreBrhpTours", "CampagneRlc2");
// 		$manager->persist ( $campagne3 );

// 		$manager->flush();

// 		$this->addReference('CampagneBrhp1', $campagne1);
// 		$this->addReference('CampagneBrhp2', $campagne2);
// 		$this->addReference('CampagneBrhp3', $campagne3);
    }

    public function getOrder()
    {
        return 8;
    }

    private function createNewCampagne($libelle, $dateDebut, $dateFin, $statut, $perimetre_brhp, $campagne_rlc)
    {
        $campagneBrhp = new CampagneBrhp();
        $campagneBrhp->setLibelle($libelle);
        $campagneBrhp->setDateDebut($dateDebut);
        $campagneBrhp->setDateFin($dateFin);
        $campagneBrhp->setStatut($statut);
        $campagneBrhp->setPerimetreBrhp($this->getReference($perimetre_brhp));
        $campagneBrhp->setCampagneRlc($this->getReference($campagne_rlc));

        return $campagneBrhp;
    }
}
