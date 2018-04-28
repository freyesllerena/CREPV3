<?php

namespace AppBundle\DataFixtures\rec;

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

        // Modèle MIDEF campagne 2018
        for ($i = 1; $i <= $nbModeles; ++$i) {
            $modele = new ModeleCrep();
            $modele
            ->setActif(1)
            ->setMinistere($this->getReference('ministere'.$i))
            ->setLibelle('Modèle Ministère des armées')
            ->setTypeEntity('CrepMindef01');
            $manager->persist($modele);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
