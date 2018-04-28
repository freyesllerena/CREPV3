<?php

namespace AppBundle\DataFixtures\prod;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\CompetenceManageriale;

class CompetenceManagerialeData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $competenceManageriale1 = new CompetenceManageriale();
        $competenceManageriale1
            ->setLibelle('Capacité à organiser le travail (M116)')
            ->setModeleCrep('CrepMindef');

        $manager->persist($competenceManageriale1);

        $competenceManageriale2 = new CompetenceManageriale();
        $competenceManageriale2
            ->setLibelle('Capacité à déléguer (M194)')
            ->setModeleCrep('CrepMindef');

        $manager->persist($competenceManageriale2);

        $competenceManageriale3 = new CompetenceManageriale();
        $competenceManageriale3
            ->setLibelle('Capacité à la prise de décision (M196)')
            ->setModeleCrep('CrepMindef');

        $manager->persist($competenceManageriale3);

        $competenceManageriale4 = new CompetenceManageriale();
        $competenceManageriale4
            ->setLibelle('Capacité à assiter et à conseiller sa hiérachie (M036)')
            ->setModeleCrep('CrepMindef');

        $manager->persist($competenceManageriale4);

        $competenceManageriale5 = new CompetenceManageriale();
        $competenceManageriale5
            ->setLibelle('Capacité à impulser et à animer une dynamique (M099)')
            ->setModeleCrep('CrepMindef');

        $manager->persist($competenceManageriale5);

        $competenceManageriale6 = new CompetenceManageriale();
        $competenceManageriale6
            ->setLibelle('Attention porté au développement professionnel des collaborateurs (M218)')
            ->setModeleCrep('CrepMindef');

        $manager->persist($competenceManageriale6);

        $competenceManageriale7 = new CompetenceManageriale();
        $competenceManageriale7
            ->setLibelle('Capacité à gérer un projet (M087)')
            ->setModeleCrep('CrepMindef');

        $manager->persist($competenceManageriale7);

        $competenceManageriale8 = new CompetenceManageriale();
        $competenceManageriale8
            ->setLibelle('Capacité à négocier (M110)')
            ->setModeleCrep('CrepMindef');

        $manager->persist($competenceManageriale8);

//     	$competenceManageriale9 = new CompetenceManageriale();
//     	$competenceManageriale9
//     	->setLibelle("Capacité à déléguer")
//     	->setModeleCrep("CrepMeem");

//     	$manager->persist($competenceManageriale9);

//     	$competenceManageriale10 = new CompetenceManageriale();
//     	$competenceManageriale10
//     	->setLibelle("Capacité à assurer le suivi des dossiers")
//     	->setModeleCrep("CrepMeem");

//     	$manager->persist($competenceManageriale10);

//     	$competenceManageriale11 = new CompetenceManageriale();
//     	$competenceManageriale11
//     	->setLibelle("Aptitudes à former des collaborateurs")
//     	->setModeleCrep("CrepMeem");

//     	$manager->persist($competenceManageriale11);

//     	$competenceManageriale12 = new CompetenceManageriale();
//     	$competenceManageriale12
//     	->setLibelle("Aptitude à la prise de décision")
//     	->setModeleCrep("CrepMeem");

//     	$manager->persist($competenceManageriale12);

//     	$competenceManageriale13 = new CompetenceManageriale();
//     	$competenceManageriale13
//     	->setLibelle("Sens de l'organisation d'une équipe")
//     	->setModeleCrep("CrepMeem");

//     	$manager->persist($competenceManageriale13);

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //                                                                                                          //
        //      CREP MINDEF01                                                                                       //
        //                                                                                                         //
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $competenceManageriale14 = new CompetenceManageriale();
        $competenceManageriale14
        ->setLibelle('Capacité à mobiliser et valoriser les compétences')
        ->setModeleCrep('CrepMindef01');

        $manager->persist($competenceManageriale14);

        $competenceManageriale15 = new CompetenceManageriale();
        $competenceManageriale15
        ->setLibelle('Capacité à déléguer')
        ->setModeleCrep('CrepMindef01');

        $manager->persist($competenceManageriale15);

        $competenceManageriale16 = new CompetenceManageriale();
        $competenceManageriale16
        ->setLibelle("Capacité d'organisation, de pilotage")
        ->setModeleCrep('CrepMindef01');

        $manager->persist($competenceManageriale16);

        $competenceManageriale17 = new CompetenceManageriale();
        $competenceManageriale17
        ->setLibelle('Capacité à évaluer ses collaborateurs')
        ->setModeleCrep('CrepMindef01');

        $manager->persist($competenceManageriale17);

        $competenceManageriale18 = new CompetenceManageriale();
        $competenceManageriale18
        ->setLibelle("Capacité à impulser et à animer une dynamique d'équipe")
        ->setModeleCrep('CrepMindef01');

        $manager->persist($competenceManageriale18);

        $competenceManageriale19 = new CompetenceManageriale();
        $competenceManageriale19
        ->setLibelle('Attention portée au développement professionnel des collaborateurs')
        ->setModeleCrep('CrepMindef01');

        $manager->persist($competenceManageriale19);

        $competenceManageriale20 = new CompetenceManageriale();
        $competenceManageriale20
        ->setLibelle('Capacité à prévenir, arbitrer et gérer les conflits')
        ->setModeleCrep('CrepMindef01');

        $manager->persist($competenceManageriale20);

        $competenceManageriale21 = new CompetenceManageriale();
        $competenceManageriale21
        ->setLibelle('Capacité à la prise de décision')
        ->setModeleCrep('CrepMindef01');

        $manager->persist($competenceManageriale21);

        $competenceManageriale22 = new CompetenceManageriale();
        $competenceManageriale22
        ->setLibelle('Capacité à fixer des objectifs cohérents')
        ->setModeleCrep('CrepMindef01');

        $manager->persist($competenceManageriale22);

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //                                                                                                          //
        //       FIN CREP MINDEF01                                                                                  //
        //                                                                                                         //
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
