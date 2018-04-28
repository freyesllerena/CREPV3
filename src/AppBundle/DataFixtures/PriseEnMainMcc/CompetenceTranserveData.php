<?php

namespace AppBundle\DataFixtures\PriseEnMainMcc;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\CompetenceTransverse;

class CompetenceTransverseData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
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

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
