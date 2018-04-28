<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\CampagnePnc;
use AppBundle\EnumTypes\EnumStatutCampagne;

class CampagnePncData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        return;
        // 		$campagne1 = $this->createNewCampagne('CampagnePnc1', 'ministere12', '2016', new \DateTime('2016-01-01'), new \DateTime('2016-10-30'), EnumStatutCampagne::CREEE, array("perimetreRlcIDF"));
// 		$manager->persist ( $campagne1 );

// 		$campagne2 = $this->createNewCampagne('CampagnePnc2', 'ministere12', '2016', new \DateTime('2016-01-10'), new \DateTime('2016-02-26'),EnumStatutCampagne::CREEE, array("perimetreRlcIDF"));
// 		$manager->persist ( $campagne2 );

// 		$campagne3 = $this->createNewCampagne('CampagnePnc3', 'ministere12', '2016', new \DateTime('2016-01-12'), new \DateTime('2016-11-26'), EnumStatutCampagne::CREEE, array("perimetreRlcCentre"));
// 		$manager->persist ( $campagne3 );

// 		$campagne3 = $this->createNewCampagne('CampagnePnc3', 'ministere12', '2016', new \DateTime('2016-01-12'), new \DateTime('2016-11-26'), EnumStatutCampagne::CREEE, array("perimetreRlcCentre","perimeteRlcRhone"));
// 		$manager->persist ( $campagne3 );

// 		$manager->flush();

// 		$this->addReference('CampagnePnc1', $campagne1);
// 		$this->addReference('CampagnePnc2', $campagne2);
// 		$this->addReference('CampagnePnc3', $campagne3);
    }

    public function getOrder()
    {
        return 4;
    }

    private function createNewCampagne($libelle, $ministere, $anneeEvaluee, $dateDebut, $dateFin, $statut, $perimetresRlc)
    {
        $campagnePnc = new CampagnePnc();
        $campagnePnc->setLibelle($libelle);
        $campagnePnc->setMinistere($this->getReference($ministere));
        $campagnePnc->setAnneeEvaluee($anneeEvaluee);
        $campagnePnc->setDateDebut($dateDebut);
        $campagnePnc->setDateFin($dateFin);
        $campagnePnc->setStatut($statut);

        foreach ($perimetresRlc as $perimetre_rlc) {
            $campagnePnc->addPerimetresRlc($this->getReference($perimetre_rlc));
        }

        return $campagnePnc;
    }
}
