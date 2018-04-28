<?php

namespace AppBundle\DataFixtures\rec;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\CompetenceTransverse;

class CompetenceTransverseData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $competenceTransverse1 = new CompetenceTransverse();
        $competenceTransverse1
            ->setLibelle('Capacité à travailler en équipe (M183)')
            ->setModeleCrep('CrepMindef');

        $manager->persist($competenceTransverse1);

        $competenceTransverse2 = new CompetenceTransverse();
        $competenceTransverse2
            ->setLibelle("Esprit d'initiative - autonomie (M015)")
            ->setModeleCrep('CrepMindef');

        $manager->persist($competenceTransverse2);

        $competenceTransverse3 = new CompetenceTransverse();
        $competenceTransverse3
            ->setLibelle("Capacité d'analyse (M001)")
            ->setModeleCrep('CrepMindef');

        $manager->persist($competenceTransverse3);

        $competenceTransverse4 = new CompetenceTransverse();
        $competenceTransverse4
            ->setLibelle('Capacité de synthèse (M160)')
            ->setModeleCrep('CrepMindef');

        $manager->persist($competenceTransverse4);

        $competenceTransverse5 = new CompetenceTransverse();
        $competenceTransverse5
            ->setLibelle('Rigueur (M249)')
            ->setModeleCrep('CrepMindef');

        $manager->persist($competenceTransverse5);

        $competenceTransverse6 = new CompetenceTransverse();
        $competenceTransverse6
            ->setLibelle('Expression écrite (M080)')
            ->setModeleCrep('CrepMindef');

        $manager->persist($competenceTransverse6);

        $competenceTransverse7 = new CompetenceTransverse();
        $competenceTransverse7
            ->setLibelle('Expression orale (M082)')
            ->setModeleCrep('CrepMindef');

        $manager->persist($competenceTransverse7);

//     	$competenceTransverse8 = new CompetenceTransverse();
//     	$competenceTransverse8
//     	->setLibelle("Connaissance du poste")
//     	->setModeleCrep("CrepMeem");

//     	$manager->persist($competenceTransverse8);

//     	$competenceTransverse9 = new CompetenceTransverse();
//     	$competenceTransverse9
//     	->setLibelle("Connaissance de l'environnement professionnel")
//     	->setModeleCrep("CrepMeem");

//     	$manager->persist($competenceTransverse9);

//     	$competenceTransverse10 = new CompetenceTransverse();
//     	$competenceTransverse10
//     	->setLibelle("Qualités rédactionnelles")
//     	->setModeleCrep("CrepMeem");

//     	$manager->persist($competenceTransverse10);

//     	$competenceTransverse11 = new CompetenceTransverse();
//     	$competenceTransverse11
//     	->setLibelle("Qualités relationnelles")
//     	->setModeleCrep("CrepMeem");

//     	$manager->persist($competenceTransverse11);

//     	$competenceTransverse12 = new CompetenceTransverse();
//     	$competenceTransverse12
//     	->setLibelle("Qualité d'expression orale")
//     	->setModeleCrep("CrepMeem");

//     	$manager->persist($competenceTransverse12);

//     	$competenceTransverse13 = new CompetenceTransverse();
//     	$competenceTransverse13
//     	->setLibelle("Capacité d'adaptation aux évolutions techniques et professionnelles")
//     	->setModeleCrep("CrepMeem");

//     	$manager->persist($competenceTransverse13);

//     	$competenceTransverse14 = new CompetenceTransverse();
//     	$competenceTransverse14
//     	->setLibelle("Capacité à assurer le suivi des dossiers")
//     	->setModeleCrep("CrepMeem");

//     	$manager->persist($competenceTransverse14);

        //////////////////////////////////////////////////////////////////////////////////////////////
        //                           MINDEF01                                                       //
        //                                                                                         //
        /////////////////////////////////////////////////////////////////////////////////////////////

        $competenceTransverse15 = new CompetenceTransverse();
        $competenceTransverse15
        ->setLibelle('Juridique')
        ->setModeleCrep('CrepMindef01')
        ->setTypeCompetence('Domaine');

        $manager->persist($competenceTransverse15);

        $competenceTransverse16 = new CompetenceTransverse();
        $competenceTransverse16
        ->setLibelle('Budgétaire et financier')
        ->setModeleCrep('CrepMindef01')
        ->setTypeCompetence('Domaine');

        $manager->persist($competenceTransverse16);

        $competenceTransverse17 = new CompetenceTransverse();
        $competenceTransverse17
        ->setLibelle('Achats publics')
        ->setModeleCrep('CrepMindef01')
        ->setTypeCompetence('Domaine');

        $manager->persist($competenceTransverse17);

        $competenceTransverse18 = new CompetenceTransverse();
        $competenceTransverse18
        ->setLibelle('International')
        ->setModeleCrep('CrepMindef01')
        ->setTypeCompetence('Domaine');

        $manager->persist($competenceTransverse18);

        $competenceTransverse19 = new CompetenceTransverse();
        $competenceTransverse19
        ->setLibelle('Organisationnel(1)')
        ->setModeleCrep('CrepMindef01')
        ->setTypeCompetence('Domaine');

        $manager->persist($competenceTransverse19);

        $competenceTransverse20 = new CompetenceTransverse();
        $competenceTransverse20
        ->setLibelle('Ressources humaines')
        ->setModeleCrep('CrepMindef01')
        ->setTypeCompetence('Domaine');

        $manager->persist($competenceTransverse20);

        $competenceTransverse21 = new CompetenceTransverse();
        $competenceTransverse21
        ->setLibelle('Action et politique sociale')
        ->setModeleCrep('CrepMindef01')
        ->setTypeCompetence('Domaine');

        $manager->persist($competenceTransverse21);

        $competenceTransverse22 = new CompetenceTransverse();
        $competenceTransverse22
        ->setLibelle('Nouvelles technologies')
        ->setModeleCrep('CrepMindef01')
        ->setTypeCompetence('Domaine');

        $manager->persist($competenceTransverse22);

        $competenceTransverse23 = new CompetenceTransverse();
        $competenceTransverse23
        ->setLibelle('Conduite de projet')
        ->setModeleCrep('CrepMindef01')
        ->setTypeCompetence('Domaine');

        $manager->persist($competenceTransverse23);

        $competenceTransverse24 = new CompetenceTransverse();
        $competenceTransverse24
        ->setLibelle('Accueil du public')
        ->setModeleCrep('CrepMindef01')
        ->setTypeCompetence('Domaine');

        $manager->persist($competenceTransverse24);

        $competenceTransverse25 = new CompetenceTransverse();
        $competenceTransverse25
        ->setLibelle('Secrétariat')
        ->setModeleCrep('CrepMindef01')
        ->setTypeCompetence('Domaine');

        $manager->persist($competenceTransverse25);

        $competenceTransverse26 = new CompetenceTransverse();
        $competenceTransverse26
        ->setLibelle('Travail en équipe')
        ->setModeleCrep('CrepMindef01')
        ->setTypeCompetence('Savoir Faire');

        $manager->persist($competenceTransverse26);

        $competenceTransverse27 = new CompetenceTransverse();
        $competenceTransverse27
        ->setLibelle('Esprit de synthèse')
        ->setModeleCrep('CrepMindef01')
        ->setTypeCompetence('Savoir Faire');

        $manager->persist($competenceTransverse27);

        $competenceTransverse28 = new CompetenceTransverse();
        $competenceTransverse28
        ->setLibelle("Sens de l'analyse")
        ->setModeleCrep('CrepMindef01')
        ->setTypeCompetence('Savoir Faire');

        $manager->persist($competenceTransverse28);

        $competenceTransverse29 = new CompetenceTransverse();
        $competenceTransverse29
        ->setLibelle("Capacité d'expertise et de conseil auprès du commandement")
        ->setModeleCrep('CrepMindef01')
        ->setTypeCompetence('Savoir Faire');

        $manager->persist($competenceTransverse29);

        $competenceTransverse30 = new CompetenceTransverse();
        $competenceTransverse30
        ->setLibelle('Créativité et innovation ')
        ->setModeleCrep('CrepMindef01')
        ->setTypeCompetence('Savoir Faire');

        $manager->persist($competenceTransverse30);

        $competenceTransverse31 = new CompetenceTransverse();
        $competenceTransverse31
        ->setLibelle("Capacité d'écoute")
        ->setModeleCrep('CrepMindef01')
        ->setTypeCompetence('Savoir Faire');

        $manager->persist($competenceTransverse31);

        $competenceTransverse32 = new CompetenceTransverse();
        $competenceTransverse32
        ->setLibelle('Négociation')
        ->setModeleCrep('CrepMindef01')
        ->setTypeCompetence('Savoir Faire');

        $manager->persist($competenceTransverse32);

        $competenceTransverse33 = new CompetenceTransverse();
        $competenceTransverse33
        ->setLibelle('Expression écrite')
        ->setModeleCrep('CrepMindef01')
        ->setTypeCompetence('Savoir Faire');

        $manager->persist($competenceTransverse33);

        $competenceTransverse34 = new CompetenceTransverse();
        $competenceTransverse34
        ->setLibelle('Expression orale')
        ->setModeleCrep('CrepMindef01')
        ->setTypeCompetence('Savoir Faire');

        $manager->persist($competenceTransverse34);

        $competenceTransverse35 = new CompetenceTransverse();
        $competenceTransverse35
        ->setLibelle('Implication personnelle')
        ->setModeleCrep('CrepMindef01')
        ->setTypeCompetence('Savoir Etre');

        $manager->persist($competenceTransverse35);

        $competenceTransverse36 = new CompetenceTransverse();
        $competenceTransverse36
        ->setLibelle('Sens du service public')
        ->setModeleCrep('CrepMindef01')
        ->setTypeCompetence('Savoir Etre');

        $manager->persist($competenceTransverse36);

        $competenceTransverse37 = new CompetenceTransverse();
        $competenceTransverse37
        ->setLibelle('Qualités relationnelles')
        ->setModeleCrep('CrepMindef01')
        ->setTypeCompetence('Savoir Etre');

        $manager->persist($competenceTransverse37);

        $competenceTransverse38 = new CompetenceTransverse();
        $competenceTransverse38
        ->setLibelle("Capacité d'adaptation")
        ->setModeleCrep('CrepMindef01')
        ->setTypeCompetence('Savoir Etre');

        $manager->persist($competenceTransverse38);

        $competenceTransverse39 = new CompetenceTransverse();
        $competenceTransverse39
        ->setLibelle("Esprit d'initiative et capacité de proposition")
        ->setModeleCrep('CrepMindef01')
        ->setTypeCompetence('Savoir Etre');

        $manager->persist($competenceTransverse39);

        $competenceTransverse40 = new CompetenceTransverse();
        $competenceTransverse40
        ->setLibelle('Réactivité')
        ->setModeleCrep('CrepMindef01')
        ->setTypeCompetence('Savoir Etre');

        $manager->persist($competenceTransverse40);

        //////////////////////////////////////////////////////////////////////////////////////////////
        //                          FIN MINDEF01                                                    //
        //                                                                                         //
        /////////////////////////////////////////////////////////////////////////////////////////////

        //////////////////////////////////////////////////////////////////////////////////////////////
        //                           MINEFABC                                                       //
        //                                                                                         //
        /////////////////////////////////////////////////////////////////////////////////////////////

        $competenceMinefAbc1 = new CompetenceTransverse();
        $competenceMinefAbc1
        ->setLibelle('Connaissances professionnelles')
        ->setModeleCrep('CrepMinefAbc')
        ->setTypeCompetence('Valeur professionnelle');

        $manager->persist($competenceMinefAbc1);

        $competenceMinefAbc2 = new CompetenceTransverse();
        $competenceMinefAbc2
        ->setLibelle('Compétences personnelles')
        ->setModeleCrep('CrepMinefAbc')
        ->setTypeCompetence('Valeur professionnelle');

        $manager->persist($competenceMinefAbc2);

        $competenceMinefAbc3 = new CompetenceTransverse();
        $competenceMinefAbc3
        ->setLibelle('Implication professionnelle')
        ->setModeleCrep('CrepMinefAbc')
        ->setTypeCompetence('Manière de servir');

        $manager->persist($competenceMinefAbc3);

        $competenceMinefAbc4 = new CompetenceTransverse();
        $competenceMinefAbc4
        ->setLibelle('Sens du service public')
        ->setModeleCrep('CrepMinefAbc')
        ->setTypeCompetence('Manière de servir');

        $manager->persist($competenceMinefAbc4);

        //////////////////////////////////////////////////////////////////////////////////////////////
        //                          FIN MINEFABC                                                    //
        //                                                                                         //
        /////////////////////////////////////////////////////////////////////////////////////////////

        //////////////////////////////////////////////////////////////////////////////////////////////
        //                           SCL                                                           //
        //                                                                                         //
        /////////////////////////////////////////////////////////////////////////////////////////////

        $competenceScl1 = new CompetenceTransverse();
        $competenceScl1
        ->setLibelle("Connaissances professionnelles dans l'emploi occupé")
        ->setModeleCrep('CrepScl')
        ->setTypeCompetence('Générale');

        $manager->persist($competenceScl1);

        $competenceScl2 = new CompetenceTransverse();
        $competenceScl2
        ->setLibelle('Compétences personnelles')
        ->setModeleCrep('CrepScl')
        ->setTypeCompetence('Générale');

        $manager->persist($competenceScl1);

        $competenceScl3 = new CompetenceTransverse();
        $competenceScl3
        ->setLibelle('Implication professionnelle')
        ->setModeleCrep('CrepScl')
        ->setTypeCompetence('Générale');

        $manager->persist($competenceScl3);

        $competenceScl4 = new CompetenceTransverse();
        $competenceScl4
        ->setLibelle('Sens du service public')
        ->setModeleCrep('CrepScl')
        ->setTypeCompetence('Générale');

        $manager->persist($competenceScl4);

        $competenceScl5 = new CompetenceTransverse();
        $competenceScl5
        ->setLibelle('Capacité à organiser et animer une équipe')
        ->setModeleCrep('CrepScl')
        ->setTypeCompetence('Encadrement');

        $manager->persist($competenceScl5);

        $competenceScl6 = new CompetenceTransverse();
        $competenceScl6
        ->setLibelle('Capacité à définir et à évaluer des objectifs')
        ->setModeleCrep('CrepScl')
        ->setTypeCompetence('Encadrement');

        $manager->persist($competenceScl6);

        //////////////////////////////////////////////////////////////////////////////////////////////
        //                          FIN SCL                                                         //
        //                                                                                         //
        /////////////////////////////////////////////////////////////////////////////////////////////

        //////////////////////////////////////////////////////////////////////////////////////////////
        //                           MCC                                                       //
        //                                                                                         //
        /////////////////////////////////////////////////////////////////////////////////////////////

        $competenceMcc1_1 = new CompetenceTransverse();
        $competenceMcc1_1->setLibelle("Connaissance du domaine d'intervention")
        ->setModeleCrep('CrepMcc')
        ->setTypeCompetence("Critères d'appréciation");
        $manager->persist($competenceMcc1_1);

        $competenceMcc1 = new CompetenceTransverse();
        $competenceMcc1->setLibelle("Capacité d'analyse")
            ->setModeleCrep('CrepMcc')
            ->setTypeCompetence("Critères d'appréciation");
        $manager->persist($competenceMcc1);

        $competenceMcc2 = new CompetenceTransverse();
        $competenceMcc2->setLibelle('Capacité de synthèse')
            ->setModeleCrep('CrepMcc')
            ->setTypeCompetence("Critères d'appréciation");
        $manager->persist($competenceMcc2);

        $competenceMcc3 = new CompetenceTransverse();
        $competenceMcc3->setLibelle("Capacité d'adaptation aux exigences du poste et du contexte")
            ->setModeleCrep('CrepMcc')
            ->setTypeCompetence("Critères d'appréciation");
        $manager->persist($competenceMcc3);

        $competenceMcc4 = new CompetenceTransverse();
        $competenceMcc4->setLibelle('Réactivité face aux sollicitations professionnelles')
            ->setModeleCrep('CrepMcc')
            ->setTypeCompetence("Critères d'appréciation");
        $manager->persist($competenceMcc4);

        $competenceMcc5 = new CompetenceTransverse();
        $competenceMcc5->setLibelle('Capacité à dialoguer et à coopérer avec les partenaires professionnels externes et internes')
            ->setModeleCrep('CrepMcc')
            ->setTypeCompetence("Critères d'appréciation");
        $manager->persist($competenceMcc5);

        $competenceMcc6 = new CompetenceTransverse();
        $competenceMcc6->setLibelle('Qualité rédactionnelle')
            ->setModeleCrep('CrepMcc')
            ->setTypeCompetence("Critères d'appréciation");
        $manager->persist($competenceMcc6);

        $competenceMcc7 = new CompetenceTransverse();
        $competenceMcc7->setLibelle('Qualité de l’expression orale')
            ->setModeleCrep('CrepMcc')
            ->setTypeCompetence("Critères d'appréciation");
        $manager->persist($competenceMcc7);

        $competenceMcc8 = new CompetenceTransverse();
        $competenceMcc8->setLibelle('Sens du service public (par référence aux obligations de l’agent-e public)')
            ->setModeleCrep('CrepMcc')
            ->setTypeCompetence("Critères d'appréciation");
        $manager->persist($competenceMcc8);

        $competenceMcc9 = new CompetenceTransverse();
        $competenceMcc9->setLibelle('Capacité à utiliser les outils bureautiques')
            ->setModeleCrep('CrepMcc')
            ->setTypeCompetence("Critères d'appréciation");
        $manager->persist($competenceMcc9);

        $competenceMcc10 = new CompetenceTransverse();
        $competenceMcc10->setLibelle('Capacité à travailler en équipe')
            ->setModeleCrep('CrepMcc')
            ->setTypeCompetence("Critères d'appréciation");
        $manager->persist($competenceMcc10);

        $competenceMcc19 = new CompetenceTransverse();
        $competenceMcc19->setLibelle('Connaissance et respect des règles d’hygiène et sécurité')
            ->setModeleCrep('CrepMcc')
            ->setTypeCompetence("Critères d'appréciation");
        $manager->persist($competenceMcc19);

        //////

        $competence11 = new CompetenceTransverse();
        $competence11->setLibelle('Capacité d’organisation, de pilotage')
            ->setModeleCrep('CrepMcc')
            ->setTypeCompetence("Responsabilité d'encadrement");
        $manager->persist($competence11);

        $competence12 = new CompetenceTransverse();
        $competence12->setLibelle('Capacité à fixer des objectifs cohérents')
             ->setModeleCrep('CrepMcc')
             ->setTypeCompetence("Responsabilité d'encadrement");
        $manager->persist($competence12);

        $competence13 = new CompetenceTransverse();
        $competence13->setLibelle('Aptitude à la prise de décision')
            ->setModeleCrep('CrepMcc')
            ->setTypeCompetence("Responsabilité d'encadrement");
        $manager->persist($competence13);

        $competence14 = new CompetenceTransverse();
        $competence14->setLibelle('Capacité à déléguer')
             ->setModeleCrep('CrepMcc')
             ->setTypeCompetence("Responsabilité d'encadrement");
        $manager->persist($competence14);

        $competence15 = new CompetenceTransverse();
        $competence15->setLibelle('Aptitude à prévenir, arbitrer et gérer les conflits')
            ->setModeleCrep('CrepMcc')
            ->setTypeCompetence("Responsabilité d'encadrement");
        $manager->persist($competence15);

        $competence16 = new CompetenceTransverse();
        $competence16->setLibelle('Aptitude à mobiliser et valoriser les compétences')
             ->setModeleCrep('CrepMcc')
             ->setTypeCompetence("Responsabilité d'encadrement");
        $manager->persist($competence16);

        $competence17 = new CompetenceTransverse();
        $competence17->setLibelle('Capacité à favoriser le développement professionnel de ses collaborateurs')
            ->setModeleCrep('CrepMcc')
            ->setTypeCompetence("Responsabilité d'encadrement");
        $manager->persist($competence17);

        $competence18 = new CompetenceTransverse();
        $competence18->setLibelle('Respect de la procédure annuelle de l’entretien professionnel')
          ->setModeleCrep('CrepMcc')
          ->setTypeCompetence("Responsabilité d'encadrement");
        $manager->persist($competence18);

        //////////////////////////////////////////////////////////////////////////////////////////////
        //                         Fin  MCC                                                       //
        //                                                                                         //
        /////////////////////////////////////////////////////////////////////////////////////////////

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
