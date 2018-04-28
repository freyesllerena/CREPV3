<?php

namespace AppBundle\DataFixtures\for1;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\PerimetreRlc;

class PerimeteRlcData extends AbstractFixture implements OrderedFixtureInterface
{
    protected $nb = 50;

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= $this->nb; ++$i) {
            $perimeteRlc = new PerimetreRlc();

            $perimeteRlc->setLibelle('CMG LUTECE '.$i)
                           ->setMinistere($this->getReference('ministere3'));

            $manager->persist($perimeteRlc);

            $this->addReference('perimetreRlc'.$i, $perimeteRlc);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}
