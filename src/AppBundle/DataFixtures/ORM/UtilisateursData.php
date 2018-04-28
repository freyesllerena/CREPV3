<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\Utilisateur;
use AppBundle\EnumTypes\EnumCivilite;
use AppBundle\Entity\PerimetreRlc;
use AppBundle\Entity\Rlc;

class UtilisateursData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    protected $nb = 30;

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
            $utilisateur->setUsername('pnc'.$i.'a@yopmail.com')
            ->setEmail('pnc'.$i.'a@yopmail.com')
            ->setCivilite(EnumCivilite::MONSIEUR)
            ->setNom('PNC')
            ->setPrenom('Pierre')
            ->setRoles(array('ROLE_PNC'))
            ->setMinistere($this->getReference('ministere'.$i))
            ->setEnabled(1)
            ->setPlainPassword('Crep.2016');
            $manager->persist($utilisateur);

            $utilisateur = new Utilisateur();
            $utilisateur->setUsername('pnc'.$i.'b@yopmail.com')
            ->setEmail('pnc'.$i.'b@yopmail.com')
            ->setCivilite(EnumCivilite::MONSIEUR)
            ->setNom('PNC')
            ->setPrenom('Paul')
            ->setRoles(array('ROLE_PNC'))
            ->setMinistere($this->getReference('ministere'.$i))
            ->setEnabled(1)
            ->setPlainPassword('Crep.2016');
            $manager->persist($utilisateur);

            $utilisateur = new Utilisateur();
            $utilisateur->setUsername('admin.min'.$i.'@yopmail.com')
            ->setEmail('admin.min'.$i.'@yopmail.com')
            ->setCivilite(EnumCivilite::MONSIEUR)
            ->setNom('ADMIN')
            ->setPrenom('Jacques')
            ->setRoles(array('ROLE_ADMIN_MIN'))
            ->setMinistere($this->getReference('ministere'.$i))
            ->setEnabled(1)
            ->setPlainPassword('Crep.2016');
            $manager->persist($utilisateur);

            $utilisateur = new Utilisateur();
            $utilisateur->setUsername('pnc'.$i.'bis@yopmail.com')
            ->setEmail('pnc'.$i.'bis@yopmail.com')
            ->setCivilite(EnumCivilite::MONSIEUR)
            ->setNom('PNC')
            ->setPrenom('Alain')
            ->setRoles(array('ROLE_PNC'))
            ->setMinistere($this->getReference('ministere'.$i.'bis'))
            ->setEnabled(1)
            ->setPlainPassword('Crep.2016');
            $manager->persist($utilisateur);

            $utilisateur = new Utilisateur();
            $utilisateur->setUsername('admin.min'.$i.'bis@yopmail.com')
            ->setEmail('admin.min'.$i.'bis@yopmail.com')
            ->setCivilite(EnumCivilite::MONSIEUR)
            ->setNom('ADMIN')
            ->setPrenom('Marc')
            ->setRoles(array('ROLE_ADMIN_MIN'))
            ->setMinistere($this->getReference('ministere'.$i.'bis'))
            ->setEnabled(1)
            ->setPlainPassword('Crep.2016');
            $manager->persist($utilisateur);
        }

        $manager->flush();

        //$this->initBaseDeDonnees($manager);

       /*


//         $rlc1Spm = new Utilisateur();
//         $rlc1Spm->setUsername('rlc1.idf@spm.fr')
//         ->setEmail('rlc1.idf@spm.fr')
//         ->setCivilite(EnumCivilite::MONSIEUR)
//         ->setNom('SPMIdf')
//         ->setPrenom('RLC1')
//         ->setRoles(array('ROLE_RLC'))
//         ->setMinistere($this->getReference('ministere12'))
//         ->setEnabled(1)
//         ->setPlainPassword('admin');
//         $manager->persist($rlc1Spm);


//         $rlc2Spm = new Utilisateur();
//         $rlc2Spm->setUsername('rlc2.idf@spm.fr')
//         ->setEmail('rlc2.idf@spm.fr')
//         ->setCivilite(EnumCivilite::MONSIEUR)
//         ->setNom('SPM')
//         ->setPrenom('RLC2')
//         ->setRoles(array('ROLE_RLC'))
//         ->setMinistere($this->getReference('ministere12'))
//         ->setEnabled(1)
//         ->setPlainPassword('admin');
//         $manager->persist($rlc2Spm);

//         $rlc1Cdc = new Utilisateur();
//         $rlc1Cdc->setUsername('rlc1.centre@cdc.fr')
//         ->setEmail('rlc1.centre@cdc.fr')
//         ->setCivilite(EnumCivilite::MONSIEUR)
//         ->setNom('CDC')
//         ->setPrenom('RLC1')
//         ->setRoles(array('ROLE_RLC'))
//         ->setMinistere($this->getReference('ministere2'))
//         ->setEnabled(1)
//         ->setPlainPassword('admin');
//         $manager->persist($rlc1Cdc);


//         $rlc2Cdc = new Utilisateur();
//         $rlc2Cdc->setUsername('rlc2.centre@cdc.fr')
//         ->setEmail('rlc2.centre@cdc.fr')
//         ->setCivilite(EnumCivilite::MONSIEUR)
//         ->setNom('CDC')
//         ->setPrenom('RLC2')
//         ->setRoles(array('ROLE_RLC'))
//         ->setMinistere($this->getReference('ministere2'))
//         ->setEnabled(1)
//         ->setPlainPassword('admin');
//         $manager->persist($rlc2Cdc);





//         $brhp1Spm = new Utilisateur();
//         $brhp1Spm->setUsername('brhp1.paris@spm.fr')
//         ->setEmail('brhp1.paris@spm.fr')
//         ->setCivilite(EnumCivilite::MONSIEUR)
//         ->setNom('SPM')
//         ->setPrenom('BRHP1')
//         ->setRoles(array('ROLE_BRHP'))
//         ->setMinistere($this->getReference('ministere12'))
//         ->setEnabled(1)
//         ->setPlainPassword('admin');
//         $manager->persist($brhp1Spm);


//         $brhp2Spm = new Utilisateur();
//         $brhp2Spm->setUsername('brhp2.paris@spm.fr')
//         ->setEmail('brhp2.paris@spm.fr')
//         ->setCivilite(EnumCivilite::MONSIEUR)
//         ->setNom('brhp2.paris.spm')
//         ->setPrenom('brhp2.paris.spm')
//         ->setRoles(array('ROLE_BRHP'))
//         ->setMinistere($this->getReference('ministere12'))
//         ->setEnabled(1)
//         ->setPlainPassword('admin');
//         $manager->persist($brhp2Spm);


//         $brhp3Spm = new Utilisateur();
//         $brhp3Spm->setUsername('brhp1.cergy@spm.fr')
//         ->setEmail('brhp1.cergy@spm.fr')
//         ->setCivilite(EnumCivilite::MONSIEUR)
//         ->setNom('brhp1.cergy.spm')
//         ->setPrenom('brhp1.cergy.spm')
//         ->setRoles(array('ROLE_BRHP'))
//         ->setMinistere($this->getReference('ministere12'))
//         ->setEnabled(1)
//         ->setPlainPassword('admin');
//         $manager->persist($brhp3Spm);


//         $brhp4Spm = new Utilisateur();
//         $brhp4Spm->setUsername('brhp2.cergy@spm.fr')
//         ->setEmail('brhp2.cergy@spm.fr')
//         ->setCivilite(EnumCivilite::MONSIEUR)
//         ->setNom('brhp2.cergy.spm')
//         ->setPrenom('brhp2.cergy.spm')
//         ->setRoles(array('ROLE_BRHP'))
//         ->setMinistere($this->getReference('ministere12'))
//         ->setEnabled(1)
//         ->setPlainPassword('admin');
//         $manager->persist($brhp4Spm);


//         $brhp1Cdc = new Utilisateur();
//         $brhp1Cdc->setUsername('brhp1.tours@cdc.fr')
//         ->setEmail('brhp1.tours@cdc.fr')
//         ->setCivilite(EnumCivilite::MONSIEUR)
//         ->setNom('brhp1.tour.cdc')
//         ->setPrenom('brhp1.tour.cdc')
//         ->setRoles(array('ROLE_BRHP'))
//         ->setMinistere($this->getReference('ministere2'))
//         ->setEnabled(1)
//         ->setPlainPassword('admin');
//         $manager->persist($brhp1Cdc);


//         $brhp2Cdc = new Utilisateur();
//         $brhp2Cdc->setUsername('brhp2.tours@cdc.fr')
//         ->setEmail('brhp2.tours@cdc.fr')
//         ->setCivilite(EnumCivilite::MONSIEUR)
//         ->setNom('brhp2.tour.cdc')
//         ->setPrenom('brhp2.tour.cdc')
//         ->setRoles(array('ROLE_BRHP'))
//         ->setMinistere($this->getReference('ministere2'))
//         ->setEnabled(1)
//         ->setPlainPassword('admin');
//         $manager->persist($brhp2Cdc);


//         $brhp3Cdc = new Utilisateur();
//         $brhp3Cdc->setUsername('brhp1.Orleans@cdc.fr')
//         ->setEmail('brhp1.Orleans@cdc.fr')
//         ->setCivilite(EnumCivilite::MONSIEUR)
//         ->setNom('brhp1.Orleans.cdc')
//         ->setPrenom('brhp1.Orleans.cdc')
//         ->setRoles(array('ROLE_BRHP'))
//         ->setMinistere($this->getReference('ministere2'))
//         ->setEnabled(1)
//         ->setPlainPassword('admin');
//         $manager->persist($brhp3Cdc);


//         $brhp4Cdc = new Utilisateur();
//         $brhp4Cdc->setUsername('brhp2.Orleans@cdc.fr')
//         ->setEmail('brhp2.Orleans@cdc.fr')
//         ->setCivilite(EnumCivilite::MONSIEUR)
//         ->setNom('brhp2.Orleans.cdc')
//         ->setPrenom('brhp2.Orleans.cdc')
//         ->setRoles(array('ROLE_BRHP'))
//         ->setMinistere($this->getReference('ministere2'))
//         ->setEnabled(1)
//         ->setPlainPassword('admin');
//         $manager->persist($brhp4Cdc);
        */

//         $manager->flush();

//         $this->addReference('rlc1.idf', $rlc1Spm);
//         $this->addReference('rlc2.idf', $rlc2Spm);
//         $this->addReference('rlc1.centre', $rlc1Cdc);
//         $this->addReference('rlc2.centre', $rlc2Cdc);
//         $this->addReference('brhp1Spm', $brhp1Spm);
//         $this->addReference('brhp2Spm', $brhp2Spm);
//         $this->addReference('brhp3Spm', $brhp3Spm);
//         $this->addReference('brhp4Spm', $brhp4Spm);
//         $this->addReference('brhp1Cdc', $brhp1Cdc);
//         $this->addReference('brhp2Cdc', $brhp2Cdc);
//         $this->addReference('brhp3Cdc', $brhp3Cdc);
//         $this->addReference('brhp4Cdc', $brhp4Cdc);
    }

    public function getOrder()
    {
        return 3;
    }

    private function initBaseDeDonnees($manager)
    {
        $nbPerimetreRlc = $this->nb;

        for ($i = 1; $i <= $nbPerimetreRlc; ++$i) {
            $ministere = $this->getReference('ministere'.$i);

            $perimetreRlc = new PerimetreRlc();
            $perimetreRlc->setLibelle('Finances')
            ->setMinistere($ministere);

            $manager->persist($perimetreRlc);
            $this->addReference('perimetreRlc'.$i, $perimetreRlc);
        }

        $manager->flush();

        $nbRlc = $this->nb;

        for ($i = 1; $i <= $nbRlc; ++$i) {
            $ministere = $this->getReference('ministere'.$i);
            $perimetreRlc = $this->getReference('perimetreRlc'.$i);
            $utilisateur = $this->getReference('pnc'.$i);

            $rlc = new Rlc();
            $rlc->setCivilite(EnumCivilite::MONSIEUR)
                ->setEmail('pnc'.$i.'@yopmail.com')
                ->setMinistere($ministere)
                ->setNom('Rlc')
                ->setPrenom('Rlc')
                ->addPerimetresRlc($perimetreRlc)
                ->setUtilisateur($utilisateur);

            $manager->persist($rlc);
            $this->addReference('rlc'.$i, $rlc);
        }

        $manager->flush();
    }
}
