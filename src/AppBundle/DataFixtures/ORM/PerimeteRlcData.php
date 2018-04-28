<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\PerimetreRlc;

class PerimeteRlcData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        return;
//     	$perimeteRlcIdf = new PerimetreRlc();
//     	$perimeteRlcIdf->setLibelle("IDF")
//     	->setMinistere($this->getReference('ministere12'));
//     	$manager->persist($perimeteRlcIdf);

//     	$perimeteRlcRhone = new PerimetreRlc();
//     	$perimeteRlcRhone->setLibelle("Rhône")
//     	->setMinistere($this->getReference('ministere2'));
//     	$manager->persist($perimeteRlcRhone);

//     	$perimeteRlcCentre = new PerimetreRlc();
//     	$perimeteRlcCentre->setLibelle("Centre")
//     	->setMinistere($this->getReference('ministere2'));
//     	$manager->persist($perimeteRlcCentre);

//         $manager->flush();

//         $this->addReference('perimetreRlcIDF', $perimeteRlcIdf);
//         $this->addReference('perimetreRlcCentre', $perimeteRlcCentre);
//         $this->addReference('perimeteRlcRhone', $perimeteRlcRhone);
    }

    public function getOrder()
    {
        return 3;
    }
}
