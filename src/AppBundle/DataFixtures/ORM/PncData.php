<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Ministere;
use AppBundle\EnumTypes\EnumCivilite;
use AppBundle\Entity\Utilisateur;

class PncData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        return;
        $nbPnc = 15;
        for ($i = 1; $i <= $nbPnc; ++$i) {
            $pnc = new Utilisateur();
            $pnc->setUsername('pnc'.$i.'@yopmail.com')
            ->setEmail('pnc'.$i.'@yopmail.com')
            ->setCivilite(EnumCivilite::MONSIEUR)
            ->setNom('PNC')
            ->setPrenom('Martin')
            ->setMinistere($this->getReference('ministere'.$i))
            ->setRoles(array('ROLE_PNC'))
            ->setEnabled(1)
            ->setPlainPassword('Crep.2016');
            $manager->persist($pnc);

            $this->addReference('pnc'.$i, $pnc);
        }

//         $pnc1Def = new Utilisateur();
//         $pnc1Def->setUsername('pnc@yopmail.com')
//                 ->setEmail('pnc@yopmail.com')
//                 ->setCivilite(EnumCivilite::MONSIEUR)
//                 ->setNom('PNC')
//                 ->setPrenom('PNC')
//                 ->setMinistere($this->getReference('ministere4'))
//                 ->setRoles(array('ROLE_PNC'))
//                 ->setEnabled(1)
//                 ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('thierry.chaves@yopmail.com')
//         ->setEmail('thierry.chaves@yopmail.com')
//         ->setCivilite(EnumCivilite::MONSIEUR)
//         ->setNom('CHAVES')
//         ->setPrenom('Thierry')
//         ->setMinistere($this->getReference('ministere1'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('jean-luc.delamarre@yopmail.com')
//         ->setEmail('jean-luc.delamarre@yopmail.com')
//         ->setCivilite(EnumCivilite::MONSIEUR)
//         ->setNom('DELAMARRE')
//         ->setPrenom('Jean-Luc')
//         ->setMinistere($this->getReference('ministere1'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('murielle.faridi@yopmail.com')
//         ->setEmail('murielle.faridi@yopmail.com')
//         ->setCivilite(EnumCivilite::MADAME)
//         ->setNom('FARIDI')
//         ->setPrenom('Murielle')
//         ->setMinistere($this->getReference('ministere2'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('christian.karsenty@yopmail.com')
//         ->setEmail('christian.karsenty@yopmail.com')
//         ->setCivilite(EnumCivilite::MONSIEUR)
//         ->setNom('KARSENTY')
//         ->setPrenom('Christian')
//         ->setMinistere($this->getReference('ministere2'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('jacqueline.merlaud@yopmail.com')
//         ->setEmail('jacqueline.merlaud@yopmail.com')
//         ->setCivilite(EnumCivilite::MADAME)
//         ->setNom('MERLAUD')
//         ->setPrenom('Jacqueline')
//         ->setMinistere($this->getReference('ministere3'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('hari.althea@yopmail.com')
//         ->setEmail('hari.althea@yopmail.com')
//         ->setCivilite(EnumCivilite::MONSIEUR)
//         ->setNom('ALTHEA')
//         ->setPrenom('Hari')
//         ->setMinistere($this->getReference('ministere3'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('luc.bice@yopmail.com')
//         ->setEmail('luc.bice@yopmail.com')
//         ->setCivilite(EnumCivilite::MONSIEUR)
//         ->setNom('BICE')
//         ->setPrenom('Luc')
//         ->setMinistere($this->getReference('ministere4'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('cindy.briallen@yopmail.com')
//         ->setEmail('cindy.briallen@yopmail.com')
//         ->setCivilite(EnumCivilite::MADAME)
//         ->setNom('BRIALLEN')
//         ->setPrenom('Cindy')
//         ->setMinistere($this->getReference('ministere4'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('gregory.david@yopmail.com')
//         ->setEmail('gregory.david@yopmail.com')
//         ->setCivilite(EnumCivilite::MONSIEUR)
//         ->setNom('DAVID')
//         ->setPrenom('Gregory')
//         ->setMinistere($this->getReference('ministere5'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('marceline.deshaun@yopmail.com')
//         ->setEmail('marceline.deshaun@yopmail.com')
//         ->setCivilite(EnumCivilite::MADAME)
//         ->setNom('DESHAUN')
//         ->setPrenom('Marceline')
//         ->setMinistere($this->getReference('ministere5'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('tiago.bai@yopmail.com')
//         ->setEmail('tiago.bai@yopmail.com')
//         ->setCivilite(EnumCivilite::MONSIEUR)
//         ->setNom('BAI')
//         ->setPrenom('Tiago')
//         ->setMinistere($this->getReference('ministere6'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('florentine.dipali@yopmail.com')
//         ->setEmail('florentine.dipali@yopmail.com')
//         ->setCivilite(EnumCivilite::MADAME)
//         ->setNom('DIPALI')
//         ->setPrenom('Florentine')
//         ->setMinistere($this->getReference('ministere6'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('calliope.fardoos@yopmail.com')
//         ->setEmail('calliope.fardoos@yopmail.com')
//         ->setCivilite(EnumCivilite::MADAME)
//         ->setNom('FARDOOS')
//         ->setPrenom('Calliope')
//         ->setMinistere($this->getReference('ministere7'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('howard.gawahir@yopmail.com')
//         ->setEmail('howard.gawahir@yopmail.com')
//         ->setCivilite(EnumCivilite::MONSIEUR)
//         ->setNom('GAWAHIR')
//         ->setPrenom('Howard')
//         ->setMinistere($this->getReference('ministere7'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('juliette.gemariah@yopmail.com')
//         ->setEmail('juliette.gemariah@yopmail.com')
//         ->setCivilite(EnumCivilite::MADAME)
//         ->setNom('GEMARIAH')
//         ->setPrenom('Juliette')
//         ->setMinistere($this->getReference('ministere8'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('arnaud.aureliano@yopmail.com')
//         ->setEmail('arnaud.aureliano@yopmail.com')
//         ->setCivilite(EnumCivilite::MONSIEUR)
//         ->setNom('AURELIANO')
//         ->setPrenom('Arnaud')
//         ->setMinistere($this->getReference('ministere8'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('chance.cuisinier@yopmail.com')
//         ->setEmail('chance.cuisinier@yopmail.com')
//         ->setCivilite(EnumCivilite::MADAME)
//         ->setNom('CUISINIER')
//         ->setPrenom('Chance')
//         ->setMinistere($this->getReference('ministere9'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('frida.ena@yopmail.com')
//         ->setEmail('frida.ena@yopmail.com')
//         ->setCivilite(EnumCivilite::MADAME)
//         ->setNom('ENA')
//         ->setPrenom('Frida')
//         ->setMinistere($this->getReference('ministere9'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('robert.festwick@yopmail.com')
//         ->setEmail('robert.festwick@yopmail.com')
//         ->setCivilite(EnumCivilite::MONSIEUR)
//         ->setNom('FESTWICK')
//         ->setPrenom('Robert')
//         ->setMinistere($this->getReference('ministere10'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('bernard.merle@yopmail.com')
//         ->setEmail('bernard.merle@yopmail.com')
//         ->setCivilite(EnumCivilite::MONSIEUR)
//         ->setNom('MERLE')
//         ->setPrenom('Bernard')
//         ->setMinistere($this->getReference('ministere10'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('marie-claude.fedon@yopmail.com')
//         ->setEmail('marie-claude.fedon@yopmail.com')
//         ->setCivilite(EnumCivilite::MADAME)
//         ->setNom('FEDON')
//         ->setPrenom('Marie-Claude')
//         ->setMinistere($this->getReference('ministere11'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('anne-marie.giron@yopmail.com')
//         ->setEmail('anne-marie.giron@yopmail.com')
//         ->setCivilite(EnumCivilite::MADAME)
//         ->setNom('GIRON')
//         ->setPrenom('Anne-Marie')
//         ->setMinistere($this->getReference('ministere11'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('dominique. gutfreund@yopmail.com')
//         ->setEmail('dominique. gutfreund@yopmail.com')
//         ->setCivilite(EnumCivilite::MADAME)
//         ->setNom('GUTFREUND')
//         ->setPrenom('Dominique')
//         ->setMinistere($this->getReference('ministere12'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('martine.ottolava@yopmail.com')
//         ->setEmail('martine.ottolava@yopmail.com')
//         ->setCivilite(EnumCivilite::MADAME)
//         ->setNom('OTTOLAVA')
//         ->setPrenom('Martine')
//         ->setMinistere($this->getReference('ministere12'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('nathalie.roulet@yopmail.com')
//         ->setEmail('nathalie.roulet@yopmail.com')
//         ->setCivilite(EnumCivilite::MADAME)
//         ->setNom('ROULET')
//         ->setPrenom('Nathalie')
//         ->setMinistere($this->getReference('ministere13'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('marc.amellal@yopmail.com')
//         ->setEmail('marc.amellal@yopmail.com')
//         ->setCivilite(EnumCivilite::MONSIEUR)
//         ->setNom('AMELLAL')
//         ->setPrenom('Marc')
//         ->setMinistere($this->getReference('ministere13'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('jeremie.dorleans@yopmail.com')
//         ->setEmail('jeremie.dorleans@yopmail.com')
//         ->setCivilite(EnumCivilite::MONSIEUR)
//         ->setNom('DORLEANS')
//         ->setPrenom('Jérémie')
//         ->setMinistere($this->getReference('ministere14'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('annie.duroc@yopmail.com')
//         ->setEmail('annie.duroc@yopmail.com')
//         ->setCivilite(EnumCivilite::MADAME)
//         ->setNom('DUROC')
//         ->setPrenom('Annie')
//         ->setMinistere($this->getReference('ministere14'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('ludovic.freyssinet@yopmail.com')
//         ->setEmail('ludovic.freyssinet@yopmail.com')
//         ->setCivilite(EnumCivilite::MONSIEUR)
//         ->setNom('FREYSSINET')
//         ->setPrenom('Ludovic')
//         ->setMinistere($this->getReference('ministere15'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('gislaine.ghaffar@yopmail.com')
//         ->setEmail('gislaine.ghaffar@yopmail.com')
//         ->setCivilite(EnumCivilite::MADAME)
//         ->setNom('GHAFFAR')
//         ->setPrenom('Ghislaine')
//         ->setMinistere($this->getReference('ministere15'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('edmondo.beminsola@yopmail.com')
//         ->setEmail('edmondo.beminsola@yopmail.com')
//         ->setCivilite(EnumCivilite::MONSIEUR)
//         ->setNom('BEMINSOLA')
//         ->setPrenom('Edmondo')
//         ->setMinistere($this->getReference('ministere16'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('armel.boulot@yopmail.com')
//         ->setEmail('armel.boulot@yopmail.com')
//         ->setCivilite(EnumCivilite::MADAME)
//         ->setNom('BOULOT')
//         ->setPrenom('Armel')
//         ->setMinistere($this->getReference('ministere16'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('jean-michel.daniel@yopmail.com')
//         ->setEmail('jean-michel.daniel@yopmail.com')
//         ->setCivilite(EnumCivilite::MONSIEUR)
//         ->setNom('DANIEL')
//         ->setPrenom('Jean-Michel')
//         ->setMinistere($this->getReference('ministere17'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('isra.fadil@yopmail.com')
//         ->setEmail('isra.fadil@yopmail.com')
//         ->setCivilite(EnumCivilite::MADAME)
//         ->setNom('FADIL')
//         ->setPrenom('Isra')
//         ->setMinistere($this->getReference('ministere17'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('matthew.sommers@yopmail.com')
//         ->setEmail('matthew.sommers@yopmail.com')
//         ->setCivilite(EnumCivilite::MONSIEUR)
//         ->setNom('SOMMERS')
//         ->setPrenom('Matthew')
//         ->setMinistere($this->getReference('ministere18'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('bernard.colum@yopmail.com')
//         ->setEmail('bernard.colum@yopmail.com')
//         ->setCivilite(EnumCivilite::MONSIEUR)
//         ->setNom('COLUM')
//         ->setPrenom('Bernard')
//         ->setMinistere($this->getReference('ministere18'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('ed.constantina@yopmail.com')
//         ->setEmail('ed.constantina@yopmail.com')
//         ->setCivilite(EnumCivilite::MONSIEUR)
//         ->setNom('CONSTANTINA')
//         ->setPrenom('Ed')
//         ->setMinistere($this->getReference('ministere19'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('lucette.emery@yopmail.com')
//         ->setEmail('lucette.emery@yopmail.com')
//         ->setCivilite(EnumCivilite::MADAME)
//         ->setNom('EMERY')
//         ->setPrenom('Lucette')
//         ->setMinistere($this->getReference('ministere19'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('lydia.hizir@yopmail.com')
//         ->setEmail('lydia.hizir@yopmail.com')
//         ->setCivilite(EnumCivilite::MADAME)
//         ->setNom('HIZIR')
//         ->setPrenom('Lydia')
//         ->setMinistere($this->getReference('ministere20'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('bassim.imbali@yopmail.com')
//         ->setEmail('bassim.imbali@yopmail.com')
//         ->setCivilite(EnumCivilite::MONSIEUR)
//         ->setNom('IMBALI')
//         ->setPrenom('Bassim')
//         ->setMinistere($this->getReference('ministere20'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('aymeric.egreve@yopmail.com')
//         ->setEmail('aymeric.egreve@yopmail.com')
//         ->setCivilite(EnumCivilite::MADAME)
//         ->setNom('EGREVE')
//         ->setPrenom('Aymeric')
//         ->setMinistere($this->getReference('ministere21'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('brigitte.frisa@yopmail.com')
//         ->setEmail('brigitte.frisa@yopmail.com')
//         ->setCivilite(EnumCivilite::MADAME)
//         ->setNom('FRISA')
//         ->setPrenom('Brigitte')
//         ->setMinistere($this->getReference('ministere21'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('anne.marti@yopmail.com')
//         ->setEmail('anne.marti@yopmail.com')
//         ->setCivilite(EnumCivilite::MADAME)
//         ->setNom('MARTI')
//         ->setPrenom('Anne')
//         ->setMinistere($this->getReference('ministere22'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('juliette.nicolle@yopmail.com')
//         ->setEmail('juliette.nicolle@yopmail.com')
//         ->setCivilite(EnumCivilite::MADAME)
//         ->setNom('NICOLLE')
//         ->setPrenom('Juliette')
//         ->setMinistere($this->getReference('ministere22'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('annie.pavard@yopmail.com')
//         ->setEmail('annie.pavard@yopmail.com')
//         ->setCivilite(EnumCivilite::MADAME)
//         ->setNom('PAVARD')
//         ->setPrenom('Annie')
//         ->setMinistere($this->getReference('ministere23'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('elisabeth.bensimon@yopmail.com')
//         ->setEmail('elisabeth.bensimon@yopmail.com')
//         ->setCivilite(EnumCivilite::MADAME)
//         ->setNom('BENSIMON')
//         ->setPrenom('Elisabeth')
//         ->setMinistere($this->getReference('ministere23'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('isabelle.deshayes@yopmail.com')
//         ->setEmail('isabelle.deshayes@yopmail.com')
//         ->setCivilite(EnumCivilite::MADAME)
//         ->setNom('DESHAYES')
//         ->setPrenom('Isabelle')
//         ->setMinistere($this->getReference('ministere24'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('juliette.ktorza@yopmail.com')
//         ->setEmail('juliette.ktorza@yopmail.com')
//         ->setCivilite(EnumCivilite::MADAME)
//         ->setNom('KTORZA')
//         ->setPrenom('Juliette')
//         ->setMinistere($this->getReference('ministere24'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('delphine.lee@yopmail.com')
//         ->setEmail('delphine.lee@yopmail.com')
//         ->setCivilite(EnumCivilite::MADAME)
//         ->setNom('LEE')
//         ->setPrenom('Delphine')
//         ->setMinistere($this->getReference('ministere25'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('marie-cecile.marquez@yopmail.com')
//         ->setEmail('marie-cecile.marquez@yopmail.com')
//         ->setCivilite(EnumCivilite::MADAME)
//         ->setNom('MARQUEZ')
//         ->setPrenom('Marie-Cécile')
//         ->setMinistere($this->getReference('ministere25'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('jean-pierre.angonin@yopmail.com')
//         ->setEmail('jean-pierre.angonin@yopmail.com')
//         ->setCivilite(EnumCivilite::MONSIEUR)
//         ->setNom('ANGONIN')
//         ->setPrenom('Jean-Pierre')
//         ->setMinistere($this->getReference('ministere26'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('emmanuel.binet@yopmail.com')
//         ->setEmail('emmanuel.binet@yopmail.com')
//         ->setCivilite(EnumCivilite::MONSIEUR)
//         ->setNom('BINET')
//         ->setPrenom('Emmanuel')
//         ->setMinistere($this->getReference('ministere26'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('orianne.boudart@yopmail.com')
//         ->setEmail('orianne.boudart@yopmail.com')
//         ->setCivilite(EnumCivilite::MADAME)
//         ->setNom('BOUDART')
//         ->setPrenom('Orianne')
//         ->setMinistere($this->getReference('ministere27'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('gilbert.bovero@yopmail.com')
//         ->setEmail('gilbert.bovero@yopmail.com')
//         ->setCivilite(EnumCivilite::MONSIEUR)
//         ->setNom('BOVERO')
//         ->setPrenom('Gilbert')
//         ->setMinistere($this->getReference('ministere27'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('paulo.fernandez@yopmail.com')
//         ->setEmail('paulo.fernandez@yopmail.com')
//         ->setCivilite(EnumCivilite::MONSIEUR)
//         ->setNom('FERNANDEZ')
//         ->setPrenom('Paulo')
//         ->setMinistere($this->getReference('ministere28'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('nadia.crombez@yopmail.com')
//         ->setEmail('nadia.crombez@yopmail.com')
//         ->setCivilite(EnumCivilite::MADAME)
//         ->setNom('CROMBEZ')
//         ->setPrenom('Nadia')
//         ->setMinistere($this->getReference('ministere28'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('laetitia.dong@yopmail.com')
//         ->setEmail('laetitia.dong@yopmail.com')
//         ->setCivilite(EnumCivilite::MADAME)
//         ->setNom('DONG')
//         ->setPrenom('Laetitia')
//         ->setMinistere($this->getReference('ministere29'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('mireille.fauquier@yopmail.com')
//         ->setEmail('mireille.fauquier@yopmail.com')
//         ->setCivilite(EnumCivilite::MADAME)
//         ->setNom('FAUQUIER')
//         ->setPrenom('Mireille')
//         ->setMinistere($this->getReference('ministere29'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('joelle.herbe@yopmail.com')
//         ->setEmail('joelle.herbe@yopmail.com')
//         ->setCivilite(EnumCivilite::MADAME)
//         ->setNom('HERBE')
//         ->setPrenom('Joelle')
//         ->setMinistere($this->getReference('ministere30'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

//         $pnc1Def = new Utilisateur();$pnc1Def->setUsername('clara.laforet@yopmail.com')
//         ->setEmail('clara.laforet@yopmail.com')
//         ->setCivilite(EnumCivilite::MADAME)
//         ->setNom('LAFORET')
//         ->setPrenom('Clara')
//         ->setMinistere($this->getReference('ministere30'))
//         ->setRoles(array('ROLE_PNC'))
//         ->setEnabled(1)
//         ->setPlainPassword('Crep.2016');
//         $manager->persist($pnc1Def);

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
