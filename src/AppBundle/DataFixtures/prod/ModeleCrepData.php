<?php

namespace AppBundle\DataFixtures\prod;

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
        // Modèle MIDEF campagne 2018
        $modele = new ModeleCrep();
        $modele
            ->setActif(1)
            ->setMinistere($this->getReference('ministere4'))
            ->setLibelle('Modèle Ministère des armées')
            ->setTypeEntity('CrepMindef01');
        $manager->persist($modele);

        $this->addReference('CrepMindef01', $modele);

        // Modèle AC
        $modele = new ModeleCrep();
        $modele
            ->setActif(true)
            ->setMinistere($this->getReference('ministere8'))
            ->setLibelle('Modèle Finances Administrateur Civil')
            ->setTypeEntity('CrepAc');
        $manager->persist($modele);

        $this->addReference('CrepAc', $modele);

        // Modèle MINEFI A, B, C
        $modele = new ModeleCrep();
        $modele
            ->setActif(true)
            ->setMinistere($this->getReference('ministere8'))
            ->setLibelle('Modèle Finances A, B, C')
            ->setTypeEntity('CrepMinefAbc');
        $manager->persist($modele);

        $this->addReference('CrepMinefAbc', $modele);

        // Modèle SCL
        $modele = new ModeleCrep();
        $modele
            ->setActif(true)
            ->setMinistere($this->getReference('ministere13'))
            ->setLibelle('Modèle SCL')
            ->setTypeEntity('CrepScl');
        $manager->persist($modele);

        $this->addReference('CrepScl', $modele);

        // Modèle MCC
        $modele = new ModeleCrep();
        $modele
            ->setActif(true)
            ->setMinistere($this->getReference('ministere3'))
            ->setLibelle('Modèle MCC')
            ->setTypeEntity('CrepMcc');
        $manager->persist($modele);

        $this->addReference('CrepMcc', $modele);

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
