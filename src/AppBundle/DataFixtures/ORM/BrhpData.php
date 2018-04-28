<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Brhp;
use AppBundle\EnumTypes\EnumCivilite;

class BrhpData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
//     	$brhp1Paris = new Brhp();
//     	$brhp1Paris->setCivilite(EnumCivilite::MONSIEUR)
// 	    	->setEmail("brhp1.paris@spm.fr")
// 	    	->setMinistere($this->getReference('ministere12'))
// 	    	->setNom("brhp1.paris.spm")
// 	    	->setPrenom("brhp1.paris.spm")
// 	    	->addPerimetresBrhp($this->getReference('perimetreBrhpParis'))
// 	    	->setUtilisateur($this->getReference('brhp1Spm'));

//     	$manager->persist($brhp1Paris);

//     	$brhp2Paris = new Brhp();
//     	$brhp2Paris->setCivilite(EnumCivilite::MONSIEUR)
// 	    	->setEmail("brhp2.paris@spm.fr")
// 	    	->setMinistere($this->getReference('ministere12'))
// 	    	->setNom("brhp2.paris.spm")
// 	    	->setPrenom("brhp2.paris.spm")
// 	    	->addPerimetresBrhp($this->getReference('perimetreBrhpParis'))
// 	    	->setUtilisateur($this->getReference('brhp2Spm'));

//     	$manager->persist($brhp2Paris);

//     	$brhp1Cergy = new Brhp();
//     	$brhp1Cergy->setCivilite(EnumCivilite::MONSIEUR)
// 	    	->setEmail("brhp1.cergy@spm.fr")
// 	    	->setMinistere($this->getReference('ministere12'))
// 	    	->setNom("brhp1.cergy.spm")
// 	    	->setPrenom("brhp1.cergy.spm")
// 	    	->addPerimetresBrhp($this->getReference('perimetreBrhpCergy'))
// 	    	->setUtilisateur($this->getReference('brhp3Spm'));

//     	$manager->persist($brhp1Cergy);

//     	$brhp2Cergy = new Brhp();
//     	$brhp2Cergy->setCivilite(EnumCivilite::MONSIEUR)
// 	    	->setEmail("brhp2.cergy@spm.fr")
// 	    	->setMinistere($this->getReference('ministere12'))
// 	    	->setNom("brhp2.cergy.spm")
// 	    	->setPrenom("brhp2.cergy.spm")
// 	    	->addPerimetresBrhp($this->getReference('perimetreBrhpCergy'))
// 	    	->setUtilisateur($this->getReference('brhp4Spm'));

//     	$manager->persist($brhp2Cergy);

//     	$brhp1Tours = new Brhp();
//     	$brhp1Tours->setCivilite(EnumCivilite::MONSIEUR)
// 	    	->setEmail("brhp1.tours@cdc.fr")
// 	    	->setMinistere($this->getReference('ministere2'))
// 	    	->setNom("brhp1.tours.cdc")
// 	    	->setPrenom("brhp1.tours.cdc")
// 	    	->addPerimetresBrhp($this->getReference('perimetreBrhpTours'))
// 	    	->setUtilisateur($this->getReference('brhp1Cdc'));

//     	$manager->persist($brhp1Tours);

//     	$brhp2Tours = new Brhp();
//     	$brhp2Tours->setCivilite(EnumCivilite::MONSIEUR)
// 	    	->setEmail("brhp2.tours@cdc.fr")
// 	    	->setMinistere($this->getReference('ministere2'))
// 	    	->setNom("brhp2.tours.cdc")
// 	    	->setPrenom("brhp2.tours.cdc")
// 	    	->addPerimetresBrhp($this->getReference('perimetreBrhpTours'))
// 	    	->setUtilisateur($this->getReference('brhp2Cdc'));

//     	$manager->persist($brhp2Tours);

//     	$brhp1Orleans = new Brhp();
//     	$brhp1Orleans->setCivilite(EnumCivilite::MONSIEUR)
// 	    	->setEmail("brhp1.Orleans@cdc.fr")
// 	    	->setMinistere($this->getReference('ministere2'))
// 	    	->setNom("brhp1.Orleans.cdc")
// 	    	->setPrenom("brhp1.Orleans.cdc")
// 	    	->addPerimetresBrhp($this->getReference('perimetreBrhpOrleans'))
// 	    	->setUtilisateur($this->getReference('brhp3Cdc'));

//     	$manager->persist($brhp1Orleans);

//     	$brhp2Orleans = new Brhp();
//     	$brhp2Orleans->setCivilite(EnumCivilite::MONSIEUR)
// 	    	->setEmail("brhp2.Orleans@cdc.fr")
// 	    	->setMinistere($this->getReference('ministere2'))
// 	    	->setNom("brhp2.Orleans.cdc")
// 	    	->setPrenom("brhp2.Orleans.cdc")
// 	    	->addPerimetresBrhp($this->getReference('perimetreBrhpOrleans'))
// 	    	->setUtilisateur($this->getReference('brhp4Cdc'));

//     	$manager->persist($brhp2Orleans);

//         $manager->flush();

//         $this->addReference('Brhp1Paris', $brhp1Paris);
//         $this->addReference('Brhp2Paris', $brhp2Paris);
//         $this->addReference('Brhp1Cergy', $brhp1Cergy);
//         $this->addReference('Brhp2Cergy', $brhp2Cergy);
//         $this->addReference('Brhp1Tours', $brhp1Tours);
//         $this->addReference('Brhp2Tours', $brhp2Tours);
//         $this->addReference('Brhp1Orleans', $brhp1Orleans);
//         $this->addReference('Brhp2Orleans', $brhp2Orleans);
    }

    public function getOrder()
    {
        return 7;
    }
}
