<?php

namespace AppBundle\DataFixtures\ORM;

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
        $nbModeles = 30;

        // Modèle MIDEF campagne 2018
        for ($i = 1; $i <= $nbModeles; ++$i) {
            $modele = new ModeleCrep();
            $modele
            ->setActif(1)
            ->setMinistere($this->getReference('ministere'.$i))
            ->setLibelle('Modèle Ministère des armées')
            ->setTypeEntity('CrepMindef01');
            $manager->persist($modele);

            $modele = new ModeleCrep();
            $modele
            ->setActif(1)
            ->setMinistere($this->getReference('ministere'.$i.'bis'))
            ->setLibelle('Modèle Ministère des armées')
            ->setTypeEntity('CrepMindef01');
            $manager->persist($modele);
        }
        $manager->flush();

        return;

        // Modèle AC
        for ($i = 1; $i <= $nbModeles; ++$i) {
            $modele = new ModeleCrep();
            $modele
            ->setActif(true)
            ->setMinistere($this->getReference('ministere'.$i))
            ->setLibelle('Modèle Finances Administrateur Civil')
            ->setTypeEntity('CrepAc');
            $manager->persist($modele);
        }
        $manager->flush();

        // Modèle MINEFI A, B, C
        for ($i = 1; $i <= $nbModeles; ++$i) {
            $modele = new ModeleCrep();
            $modele
            ->setActif(true)
            ->setMinistere($this->getReference('ministere'.$i))
            ->setLibelle('Modèle Finances A, B, C');
            $manager->persist($modele);
        }
        $manager->flush();

        return;

        $modele1 = new ModeleCrep();
        $modele1
            ->setActif(1)
            ->setMinistere($this->getReference('ministere4'))
            ->setLibelle('Modèle MINDEF 01')
            ->setTypeEntity('CrepMindef01');

        $modele4 = new ModeleCrep();
        $modele4
        ->setActif(1)
        ->setMinistere($this->getReference('ministere8'))
        ->setLibelle('Modèle Minef ABC')
        ->setTypeEntity('CrepMinefAbc');

        $modele5 = new ModeleCrep();
        $modele5
        ->setActif(1)
        ->setMinistere($this->getReference('ministere8'))
        ->setLibelle('Modèle AC')
        ->setTypeEntity('CrepAc');

        $modele6 = new ModeleCrep();
        $modele6
        ->setActif(1)
        ->setMinistere($this->getReference('ministere3'))
        ->setLibelle('Modèle MCC')
        ->setTypeEntity('CrepMcc');

        // Modèle SCL
        $modele = new ModeleCrep();
        $modele
        ->setActif(true)
        ->setMinistere($this->getReference('ministere13'))
        ->setLibelle('Modèle SCL')
        ->setTypeEntity('CrepScl');
        $manager->persist($modele);

        $this->addReference('CrepScl', $modele);

        $manager->persist($modele1);
        $manager->persist($modele4);
        $manager->persist($modele5);
        $manager->persist($modele6);

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
