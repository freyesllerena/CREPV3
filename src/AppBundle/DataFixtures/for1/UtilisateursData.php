<?php

namespace AppBundle\DataFixtures\for1;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\Utilisateur;
use AppBundle\EnumTypes\EnumCivilite;

class UtilisateursData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $utilisateur1 = new Utilisateur();
        $utilisateur1->setUsername('admin@free.fr')
            ->setEmail('admin@free.fr')
            ->setCivilite(EnumCivilite::MADAME)
            ->setNom('Admin')
            ->setPrenom('Admin')
            ->setRoles(array('ROLE_ADMIN'))
            ->setMinistere($this->getReference('ministere8'))
            ->setEnabled(1)
            ->setPlainPassword('Crep.2016');
        $manager->persist($utilisateur1);

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
