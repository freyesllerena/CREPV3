<?php

namespace AppBundle\DataFixtures\for1;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Ministere;

class MinistereData extends AbstractFixture implements OrderedFixtureInterface
{
    protected $nb = 10;

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= $this->nb; ++$i) {
            $ministere = new Ministere();
            $ministere->setLibelleCourt('Ministère '.$i)
                      ->setLibelleLong('Ministère '.$i)
                      ->setLibelleOfficiel('Ministère '.$i)
                      ->setDelaiVisa(0);
            $manager->persist($ministere);

            $this->addReference('ministere'.$i, $ministere);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
