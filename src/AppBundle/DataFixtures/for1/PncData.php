<?php

namespace AppBundle\DataFixtures\for1;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Ministere;
use AppBundle\EnumTypes\EnumCivilite;
use AppBundle\Entity\Utilisateur;

class PncData extends AbstractFixture implements OrderedFixtureInterface
{
    protected $nb = 10;

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= $this->nb; ++$i) {
            $pnc = new Utilisateur();

            $pnc->setUsername('pnc'.$i.'@yopmail.com')
                ->setEmail('pnc'.$i.'@yopmail.com')
                ->setCivilite(EnumCivilite::MONSIEUR)
                ->setNom('PNC')
                ->setPrenom('Martin'.$i)
                ->setMinistere($this->getReference('ministere'.$i))
                ->setRoles(array('ROLE_PNC'))
                ->setEnabled(1)
                ->setPlainPassword('Crep.2016');

            $manager->persist($pnc);

            $this->addReference('pnc'.$i, $pnc);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
