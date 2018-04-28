<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\PerimetreBrhp;

class PerimeteBrhpData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        return;
//     	$perimeteBrhpParis = new PerimetreBrhp();
//     	$perimeteBrhpParis->setLibelle("Paris")
//     	->setPerimetreRlc($this->getReference('perimetreRlcIDF'));
//     	$manager->persist($perimeteBrhpParis);

//     	$perimeteBrhpCergy = new PerimetreBrhp();
//     	$perimeteBrhpCergy->setLibelle("Cergy")
//     	->setPerimetreRlc($this->getReference('perimetreRlcIDF'));
//     	$manager->persist($perimeteBrhpCergy);

//     	$perimeteBrhpTours = new PerimetreBrhp();
//     	$perimeteBrhpTours->setLibelle("Tours")
//     	->setPerimetreRlc($this->getReference('perimetreRlcCentre'));
//     	$manager->persist($perimeteBrhpTours);

//     	$perimeteBrhpOrleans = new PerimetreBrhp();
//     	$perimeteBrhpOrleans->setLibelle("Orléans")
//     	->setPerimetreRlc($this->getReference('perimetreRlcCentre'));
//     	$manager->persist($perimeteBrhpOrleans);

//         $manager->flush();

//         $this->addReference('perimetreBrhpParis', $perimeteBrhpParis);
//         $this->addReference('perimetreBrhpCergy', $perimeteBrhpCergy);
//         $this->addReference('perimetreBrhpTours', $perimeteBrhpTours);
//         $this->addReference('perimetreBrhpOrleans', $perimeteBrhpOrleans);
    }

    public function getOrder()
    {
        return 4;
    }
}
