<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Rlc;
use AppBundle\EnumTypes\EnumCivilite;

class RlcData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        return;
//     	$rlc1Idf = new Rlc();
//     	$rlc1Idf->setCivilite(EnumCivilite::MONSIEUR)
//     	->setEmail("rlc1.idf@spm.fr")
//     	->setMinistere($this->getReference('ministere12'))
//     	->setNom("Rlc1")
//     	->setPrenom("Idf")
//     	->addPerimetresRlc($this->getReference('perimetreRlcIDF'))
//     	->setUtilisateur($this->getReference('rlc1.idf'));
//     	$manager->persist($rlc1Idf);

//     	$rlc2Idf = new Rlc();
//     	$rlc2Idf->setCivilite(EnumCivilite::MONSIEUR)
//     	->setEmail("rlc2.idf@spm.fr")
//     	->setMinistere($this->getReference('ministere12'))
//     	->setNom("Rlc2")
//     	->setPrenom("Idf")
//     	->addPerimetresRlc($this->getReference('perimetreRlcIDF'))
//     	->setUtilisateur($this->getReference('rlc2.idf'));
//     	$manager->persist($rlc2Idf);

//     	$rlc1Centre = new Rlc();
//     	$rlc1Centre->setCivilite(EnumCivilite::MONSIEUR)
//     	->setEmail("rlc1.centre@cdc.fr")
//     	->setMinistere($this->getReference('ministere2'))
//     	->setNom("rlc1.centre.cdc")
//     	->setPrenom("rlc1.centre.cdc")
//     	->addPerimetresRlc($this->getReference('perimetreRlcCentre'))
//     	->setUtilisateur($this->getReference('rlc1.centre'));

//     	$manager->persist($rlc1Centre);

//     	$rlc2Centre = new Rlc();
//     	$rlc2Centre->setCivilite(EnumCivilite::MONSIEUR)
//     	->setEmail("rlc2.centre@cdc.fr")
//     	->setMinistere($this->getReference('ministere2'))
//     	->setNom("rlc2.centre.cdc")
//     	->setPrenom("rlc2.centre.cdc")
//     	->addPerimetresRlc($this->getReference('perimetreRlcCentre'))
//     	->setUtilisateur($this->getReference('rlc2.centre'));
//     	$manager->persist($rlc2Centre);

//         $manager->flush();

//         $this->addReference('Rlc1IdfSpm', $rlc1Idf);
//         $this->addReference('Rlc2IdfSpm', $rlc2Idf);
//         $this->addReference('Rlc1CentreCdc', $rlc1Centre);
//         $this->addReference('Rlc2CentreCdc', $rlc2Centre);
    }

    public function getOrder()
    {
        return 6;
    }
}
