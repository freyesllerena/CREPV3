<?php

namespace AppBundle\DataFixtures\for1;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Ministere;
use AppBundle\EnumTypes\EnumCivilite;
use AppBundle\Entity\Utilisateur;

class AdminMinData extends AbstractFixture implements OrderedFixtureInterface
{
    protected $nb = 10;

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= $this->nb; ++$i) {
            $utilisateur = new Utilisateur();

            $utilisateur->setUsername('admin.min'.$i.'@yopmail.com')
                        ->setEmail('admin.min'.$i.'@yopmail.com')
                        ->setCivilite(EnumCivilite::MONSIEUR)
                        ->setNom('ADMIN')
                        ->setPrenom('Jacques'.$i)
                        ->setRoles(array('ROLE_ADMIN_MIN'))
                        ->setMinistere($this->getReference('ministere'.$i))
                        ->setEnabled(1)
                        ->setPlainPassword('Crep.2016');

            $manager->persist($utilisateur);
            $this->addReference('admin_min'.$i, $utilisateur);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
