<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Formation;

class FormationData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        return;

        //**************************** Test extrait référentiel formations Finances ****************************//

        $formation1 = new Formation();
        $formation1->setLibelle('Rédiger des courriers professionnels')
        ->setCode('23')
        ->setDuree(1)
        ->setMinistere($manager->getRepository('AppBundle:Ministere')->find(8))
        ->setDateFinValidite(new \DateTime('2999-12-31'));
        $manager->persist($formation1);

        $formation2 = new Formation();
        $formation2->setLibelle("S'initier à l'accueil (téléphonique et visiteurs)")
        ->setCode('28')
        ->setDuree(1)
        ->setMinistere($manager->getRepository('AppBundle:Ministere')->find(8))
        ->setDateFinValidite(new \DateTime('2999-12-31'));
        $manager->persist($formation2);

        $formation3 = new Formation();
        $formation3->setLibelle('Anglais économique et financier')
        ->setCode('30')
        ->setDuree(1)
        ->setMinistere($manager->getRepository('AppBundle:Ministere')->find(8))
        ->setDateFinValidite(new \DateTime('2999-12-31'));
        $manager->persist($formation3);

        $formation4 = new Formation();
        $formation4->setLibelle('Prendre la parole en public')
        ->setCode('33')
        ->setDuree(1)
        ->setMinistere($manager->getRepository('AppBundle:Ministere')->find(8))
        ->setDateFinValidite(new \DateTime('2999-12-31'));
        $manager->persist($formation4);

        //**************************** Fin test extrait référentiel formations Finances ****************************//

//         $formation1 = new Formation();
//         $formation1->setLibelle("Java")
//         ->setCode('J001')
//         ->setDuree(1)
//         ->setMinistere($manager->getRepository('AppBundle:Ministere')->find(4))
//         ->setDateFinValidite(new \DateTime('2999-12-31'));
//         $manager->persist($formation1);

//         $formation2 = new Formation();
//         $formation2->setLibelle("C++")
//         ->setCode('C001')
//         ->setDuree(1)
//         ->setMinistere($manager->getRepository('AppBundle:Ministere')->find(4))
//         ->setDateFinValidite(new \DateTime('2999-12-31'));
//         $manager->persist($formation2);

//         $formation1 = new Formation();
//         $formation1->setLibelle("Java")
//         ->setCode('J001')
//         ->setDuree(1)
//         ->setMinistere($manager->getRepository('AppBundle:Ministere')->find(4))
//         ->setDateFinValidite(new \DateTime('2999-12-31'));
//         $manager->persist($formation1);

//         $formation2 = new Formation();
//         $formation2->setLibelle("C++")
//         ->setCode('C001')
//         ->setDuree(1)
//         ->setMinistere($manager->getRepository('AppBundle:Ministere')->find(4))
//         ->setDateFinValidite(new \DateTime('2999-12-31'));
//         $manager->persist($formation2);

        $manager->flush();
    }

    public function getOrder()
    {
        return 7;
    }
}
