<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Ministere;

class MinistereData extends AbstractFixture implements OrderedFixtureInterface
{
    protected $nb = 30;

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= $this->nb; ++$i) {
            $ministere = new Ministere();
            $ministere->setLibelleCourt('Ministère '.$i)
            ->setLibelleLong('Ministère '.$i)
            ->setLibelleOfficiel('Ministère '.$i);
            $manager->persist($ministere);
            $this->addReference('ministere'.$i, $ministere);

            $ministere = new Ministere();
            $ministere->setLibelleCourt('Ministère '.$i.' bis')
            ->setLibelleLong('Ministère '.$i.' bis')
            ->setLibelleOfficiel('Ministère '.$i.' bis');
            $manager->persist($ministere);
            $this->addReference('ministere'.$i.'bis', $ministere);
        }
        $manager->flush();

        return;

        $ministere1 = new Ministere();
        $ministere1->setLibelleCourt('Agriculture')
        ->setLibelleLong("Ministère de l'agriculture")
        ->setLibelleOfficiel("Ministère de l'agriculture, de l'agroalimentaire et de la forêt");
        $manager->persist($ministere1);

        $ministere2 = new Ministere();
        $ministere2->setLibelleCourt('CDC')
        ->setLibelleLong('Caisse des dépôts et consignations')
        ->setLibelleOfficiel('Caisse des dépôts et consignations');
        $manager->persist($ministere2);

        $ministere3 = new Ministere();
        $ministere3->setLibelleCourt('Culture')
        ->setLibelleLong('Ministère de la culture')
        ->setLibelleOfficiel('Ministère de la culture et de la communication');
        $manager->persist($ministere3);

        $ministere4 = new Ministere();
        $ministere4->setLibelleCourt('Défense')
        ->setLibelleLong('Ministère des armées')
        ->setLibelleOfficiel('Ministère des armées');
        $manager->persist($ministere4);

        $ministere5 = new Ministere();
        $ministere5->setLibelleCourt('DGAC')
        ->setLibelleLong("Direction générale de l'aviation civile")
        ->setLibelleOfficiel("Ministère de l'environnement, de l'énergie et de la mer, ministère de l'aménagement du territoire, de la ruralité  et des collectivités territoriales, ministère du logement et de l'habitat durable / Direction générale de l'aviation civile");
        $manager->persist($ministere5);

        $ministere6 = new Ministere();
        $ministere6->setLibelleCourt('Ecologie')
        ->setLibelleLong("Ministère de l'écologie")
        ->setLibelleOfficiel("Ministère de l'environnement, de l'énergie et de la mer, ministère de l'aménagement du territoire, de la ruralité et des collectivités territoriales, ministère du logement et de l'habitat durable");
        $manager->persist($ministere6);

        $ministere7 = new Ministere();
        $ministere7->setLibelleCourt('Education')
        ->setLibelleLong("Ministère de l'éducation nationale")
        ->setLibelleOfficiel("Ministère de l'éducation nationale, de l'enseignement supérieur et de la recherche");
        $manager->persist($ministere7);

        $ministere8 = new Ministere();
        $ministere8->setLibelleCourt('Finances')
        ->setLibelleLong('Ministères économiques et financiers')
        ->setLibelleOfficiel("Ministère des finances et des comptes publics, ministère de l'économie, de l'industrie et du numérique, ministère de la fonction publique");
        $manager->persist($ministere8);

        $ministere9 = new Ministere();
        $ministere9->setLibelleCourt('Intérieur')
        ->setLibelleLong("Ministère de l'intérieur")
        ->setLibelleOfficiel("Ministère de l'intérieur, ministère des outre mer");
        $manager->persist($ministere9);

        $ministere10 = new Ministere();
        $ministere10->setLibelleCourt('Justice')
        ->setLibelleLong('Ministère de la justice')
        ->setLibelleOfficiel('Ministère de la justice');
        $manager->persist($ministere10);

        $ministere11 = new Ministere();
        $ministere11->setLibelleCourt('Sociaux')
        ->setLibelleLong('Ministères sociaux')
        ->setLibelleOfficiel("Ministère des affaires sociales et de la santé, ministère du travail, de l'emploi, de la formation professionnelle et du dialogue social, ministère de la famille, de l'enfance et des droits des femmes, ministère de la ville, de la jeunesse et des sports");
        $manager->persist($ministere11);

        $ministere12 = new Ministere();
        $ministere12->setLibelleCourt('SPM')
        ->setLibelleLong('Services du Premier ministre')
        ->setLibelleOfficiel('Services du Premier ministre');
        $manager->persist($ministere12);

        $manager->flush();

        $this->addReference('ministere1', $ministere1);
        $this->addReference('ministere2', $ministere2);
        $this->addReference('ministere3', $ministere3);
        $this->addReference('ministere4', $ministere4);
        $this->addReference('ministere5', $ministere5);
        $this->addReference('ministere6', $ministere6);
        $this->addReference('ministere7', $ministere7);
        $this->addReference('ministere8', $ministere8);
        $this->addReference('ministere9', $ministere9);
        $this->addReference('ministere10', $ministere10);
        $this->addReference('ministere11', $ministere11);
        $this->addReference('ministere12', $ministere12);
    }

    public function getOrder()
    {
        return 1;
    }
}
