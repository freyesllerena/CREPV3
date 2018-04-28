<?php

namespace AppBundle\DataFixtures\rec;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Ministere;
use AppBundle\Entity\PerimetreRlc;

class PerimeteRlcData extends AbstractFixture implements OrderedFixtureInterface
{
    // un perimetre RLC par ministere
    protected $nb = 10;

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= $this->nb; ++$i) {
            $perimeteRlc = new PerimetreRlc();

            $perimeteRlc->setLibelle('CMG LUTECE (ministere '.$i.')')
                           ->setMinistere($this->getReference('ministere'.$i));

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
