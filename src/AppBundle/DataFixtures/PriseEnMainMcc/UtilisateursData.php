<?php

namespace AppBundle\DataFixtures\PriseEnMainMcc;

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
    protected $nb = 10;

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

        for ($i = 1; $i <= $this->nb; ++$i) {
            $utilisateur = new Utilisateur();
            $utilisateur->setUsername('dominique.herondelle'.$i.'@yopmail.com')
            ->setEmail('dominique.herondelle'.$i.'@yopmail.com')
            ->setCivilite(EnumCivilite::MONSIEUR)
            ->setNom('HERONDELLE')
            ->setPrenom('Dominique')
            ->setRoles(array('ROLE_PNC'))
            ->setMinistere($this->getReference('ministere'.$i))
            ->setEnabled(1)
            ->setPlainPassword('Crep.2016');
            $manager->persist($utilisateur);

            $utilisateur = new Utilisateur();
            $utilisateur->setUsername('gwannaelle.leconte'.$i.'@yopmail.com')
            ->setEmail('gwannaelle.leconte'.$i.'@yopmail.com')
            ->setCivilite(EnumCivilite::MADAME)
            ->setNom('LECONTE')
            ->setPrenom('Gwennaëlle')
            ->setRoles(array('ROLE_ADMIN_MIN'))
            ->setMinistere($this->getReference('ministere'.$i))
            ->setEnabled(1)
            ->setPlainPassword('Crep.2016');
            $manager->persist($utilisateur);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}
