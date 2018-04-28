<?php

namespace AppBundle\DataFixtures\PriseEnMainMcc;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Ministere;
use AppBundle\Entity\PerimetreRlc;
use AppBundle\Entity\Rlc;
use AppBundle\EnumTypes\EnumCivilite;

class RlcData extends AbstractFixture implements OrderedFixtureInterface
{
    protected $nb = 10;

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= $this->nb; ++$i) {
            $rlc = new Rlc();
            $rlc->setCivilite(EnumCivilite::MONSIEUR)
                ->setEmail('benoit.prouvost'.$i.'@yopmail.com')
                ->setMinistere($this->getReference('ministere'.$i))
                ->setNom('PROUVOST')
                ->setPrenom('Benoît')
                ->addPerimetresRlc($this->getReference('perimetreRlc'.$i));

            $manager->persist($rlc);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }
}
