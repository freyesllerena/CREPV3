<?php

namespace AppBundle\DataFixtures\rec;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Ministere;
use AppBundle\Entity\PerimetreRlc;
use AppBundle\Entity\Rlc;
use AppBundle\EnumTypes\EnumCivilite;
use AppBundle\Entity\Utilisateur;

class RlcData extends AbstractFixture implements OrderedFixtureInterface
{
    // un seul RLC par ministere
    protected $nb = 10;

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= $this->nb; ++$i) {
            $rlcUser = new Utilisateur();
            $rlcUser->setUsername('rlc@ministere'.$i.'.com')
                    ->setEmail('rlc@ministere'.$i.'.com')
                    ->setCivilite(EnumCivilite::MONSIEUR)
                    ->setNom('RLC')
                    ->setPrenom('RLC'.$i)
                    ->setMinistere($this->getReference('ministere'.$i))
                    ->setRoles(array('ROLE_RLC'))
                    ->setEnabled(1)
                    ->setPlainPassword('Crep.2016');

            $rlc = new Rlc();
            $rlc->setCivilite(EnumCivilite::MONSIEUR)
                ->setEmail('rlc@ministere'.$i.'.com')
                ->setMinistere($this->getReference('ministere'.$i))
                ->setNom('RLC')
                ->setPrenom('RLC'.$i)
                ->addPerimetresRlc($this->getReference('perimetreRlc'.$i))
                ->setUtilisateur($rlcUser);

            $manager->persist($rlcUser);
            $manager->persist($rlc);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }
}
