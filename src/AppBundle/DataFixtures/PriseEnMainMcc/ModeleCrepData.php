<?php

namespace AppBundle\DataFixtures\PriseEnMainMcc;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\ModeleCrep;

class ModeleCrepData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $nbModeles = 10;

        for ($i = 1; $i <= $nbModeles; ++$i) {
            $modele = new ModeleCrep();
            $modele
            ->setActif(true)
            ->setMinistere($this->getReference('ministere'.$i))
            ->setLibelle('Modèle MCC')
            ->setTypeEntity('CrepMcc');
            $manager->persist($modele);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
