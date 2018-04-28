<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use AppBundle\Entity\Agent;
use AppBundle\Entity\CompetenceDeclaree;
use AppBundle\Entity\CompetenceManageriale;
use AppBundle\Entity\CompetencePoste;
use AppBundle\Entity\CompetenceTransverse;
use AppBundle\Entity\CrepMindef;
use AppBundle\Entity\Emploi;
use AppBundle\Entity\EvolutionProfessionnelle;
use AppBundle\Entity\Formation;
use AppBundle\Entity\FormationSuivie;
use AppBundle\Entity\Ministere;
use AppBundle\Entity\MobiliteExterne;
use AppBundle\Entity\MobiliteFonctionnelle;
use AppBundle\Entity\MobiliteGeographique;
use AppBundle\Entity\ObjectifEvalue;
use AppBundle\Entity\ObjectifFutur;
use AppBundle\Entity\Crep;

class CrepCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        // Name and description for bin/console command
        $this
        ->setName('crep:show')
        ->setDescription('Création d\'un jeux');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Showing when the script is launched
        $now = new \DateTime();
        $output->writeln('<comment>Start : '.$now->format('d-m-Y G:i:s').' ---</comment>');

        // Importing CSV on DB via Doctrine ORM
        $this->Insert($input, $output);

        // Showing when the script is over
        $now = new \DateTime();
        $output->writeln('<comment>End : '.$now->format('d-m-Y G:i:s').' ---</comment>');
    }

    protected function Insert(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();

        $crep = new CrepMindef();

        $crep->setStatut('créé');
        $crep->setMatriculeAlliance('lkjlkjkl');
        $crep->setNomNaissance('nomNaissance');
        $crep->setNomUsage('jkllkjkl');
        $crep->setNomNaissanceShd('nom shd');
        $crep->getDateEntreeCorps(new \DateTime('2011-01-01T15:03:01.012345Z'));
        $crep->setPosteOccupeAgent('lkklj');
        $crep->setGrade('officier');
        $crep->setEtablissement('Voltaire');
        $crep->setDepartement('75');

        $crep->setAutresActivites('kayak');
        $crep->setObservationsAgentObjectifsPasses('lkererkl erkgjerkgj');
        $crep->setNbAgentsEncadresA(10);
        $crep->setNbAgentsEncadresB(11);
        $crep->setNbAgentsEncadresC(12);

        $em->persist($crep);

        // 	    $agent = new Agent();
        // 	    $agent->setEmail('cool@cool.co');
        // 	    $agent->setMatricule('12358');
        // 	    $agent->setNomNaissance('nomNaissance');
        // 	    $agent->setDateNaissance(new \DateTime('2011-01-01T15:03:01.012345Z'));
        // 	    $em->persist($agent);

        $objectifEvalue = new ObjectifEvalue();
        $objectifEvalue->setLibelle('obj attendu');
        $crep->addObjectifsEvalue($objectifEvalue);

        $em->persist($objectifEvalue);
        $em->persist($crep);

        $competencesAgent = new CompetencePoste();
        $competencesAgent->setLibelle('compentence poste');
        $competencesAgent->setNiveauAcquis(0);
        $competencesAgent->setNiveauRequis('niveau a atteindre');
        $competencesAgent = new CompetencePoste();
        $competencesAgent->setLibelle('compentence poste 2');
        $competencesAgent->setNiveauAcquis(0);
        $competencesAgent->setNiveauRequis('niveau a atteindre');
        $crep->addCompetencesPoste($competencesAgent);
        $crep->addCompetencesPoste($competencesAgent);

        $em->persist($competencesAgent);
        $em->persist($crep);

        $competencesTransverse = new CompetenceTransverse();
        $competencesTransverse->setLibelle('compentence manageriale');
        $competencesTransverse->setNiveauAcquis(1);

        $em->persist($competencesTransverse);

        $competencesTransverse = new CompetenceTransverse();
        $competencesTransverse->setLibelle('compentence manageriale');
        $competencesTransverse->setNiveauAcquis(1);

        $crep->addCompetencesTransverse($competencesTransverse);
        $crep->addCompetencesTransverse($competencesTransverse);

        $em->persist($competencesTransverse);
        $em->persist($crep);

        $competencesManageriale = new CompetenceManageriale();
        $competencesManageriale->setLibelle('compentence manageriale');
        $competencesManageriale->setNiveauAcquis(1);
        $crep->addCompetencesManageriale($competencesManageriale);

        $em->persist($competencesManageriale);
        $em->persist($crep);

        // 	    $objectifFutur = new ObjectifFutur();

        // 	    $objectifFutur->setLibelle('obj futur');
        // 	    $objectifFutur->setResultat('resultats');
        // 	     $crep->setObservationsAgentObjectifsFuturs('kjlhljhklj');
        // 	    $em->persist($objectifFutur);
        // 	    $em->persist($crep);

        // 	    $objectifFutur->setEcheance(new \DateTime('2019-01-01T15:03:01.012345Z'));
        // 	    $crep->setObservationsAgentObjectifsFuturs('lkererkl erkgjerkgj');
        // 	    $crep->addObjectifsFutur($objectifFutur);

        // 	    $em->persist($objectifFutur);
        // 	    $em->persist($crep);

        $emploi = new Emploi();
        $emploi->setAffectation('affectation1');
        $emploi->setPoste('mon poste');
        $emploi->setDateDebut(new \DateTime('2021-01-01T15:03:01.012345Z'));
        $emploi->getFamilleMorgane('The family');

        $em->persist($emploi);

        $crep->addEmploi($emploi);

        $em->persist($crep);

        $competenceDeclaree = new CompetenceDeclaree();
        $competenceDeclaree->setLibelle('lerjglerkj');
        $competenceDeclaree->setNiveauAcquis(2);

        $em->persist($competenceDeclaree);

        $crep->addCompetencesDeclaree($competenceDeclaree);

        $crep->setObservationsAgentProjetProfessionnel('très bon boulot !!!!!!!');

        $crep->setObservationsShdProjetProfessionnel('très bon boulot !!!!!!!');

        $em->persist($crep);

        $evolutionProfessionnelle = new EvolutionProfessionnelle();
        $evolutionProfessionnelle->setChoix('mon choix');
        $evolutionProfessionnelle->setEcheance(new \DateTime('2021-01-01T15:03:01.012345Z'));

        $crep->setEvolutionProfessionnelle($evolutionProfessionnelle);

        $em->persist($evolutionProfessionnelle);
        $em->persist($crep);

        $mobiliteFonctionnelle = new MobiliteFonctionnelle();
        $mobiliteFonctionnelle->setFamilleProfessionnelle('lkjlkj');
        $mobiliteFonctionnelle->setFiliere('lkjlkj');
        $mobiliteFonctionnelle->setPriorite('erg');

        $crep->setMobiliteFonctionnelle($mobiliteFonctionnelle);

        $em->persist($mobiliteFonctionnelle);
        $em->persist($crep);

        $mobiliteGeographique = new MobiliteGeographique();
        $mobiliteGeographique->setRegion('mon choix');
        $mobiliteGeographique->setDepartement('kjhjkh');
        $mobiliteGeographique->setVille('zef');
        $mobiliteGeographique->setPriorite('kjhjkh');

        $crep->setMobiliteGeographique($mobiliteGeographique);

        $em->persist($mobiliteGeographique);
        $em->persist($crep);

        $mobiliteExterne = new MobiliteExterne();

        $ministere = new Ministere();
        $mobiliteExterne->setMinistere($ministere->getLibelleCourt());
        $mobiliteExterne->setHorsMinistere('lkjlkj');
        $mobiliteExterne->setPriorite('erg');

        $em->persist($mobiliteExterne);

        $crep->setMobiliteExterne($mobiliteExterne);

        $em->persist($crep);

        $formationSuivie = new FormationSuivie();

        $formation = new Formation();
        $formation->setLibelle('kljklj');
        $formation->setCode(12345);
        $formation->setDuree('3 jours');
        $formationSuivie->setFormation($formation);

        $crep->addFormationsSuivy($formationSuivie);

        $em->persist($formation);
        $em->persist($formationSuivie);
        $em->persist($crep);

        // 		// Flushing and clear data on queue
        $em->flush();
    }
}
