<?php

/**
 * Created by PhpStorm.
 * User: freyes-adc
 * Date: 10/07/2018
 * Time: 11:21
 */

namespace AppBundle\Repository\CrepRepository\CrepMj02Repository;

use AppBundle\Entity\CampagneBrhp;

/**
 * Class CrepMj02FormationAnneeEcouleeRepository
 * @package AppBundle\Repository\CrepRepository\CrepMj02Repository
 */
class CrepMj02FormationAnneeEcouleeRepository extends \Doctrine\ORM\EntityRepository
{
    public function exportFormations(CampagneBrhp $campagneBrhp, $modeleCrep)
    {
        $qb = $this->createQueryBuilder('formation');
        $qb
            ->select('agent.matricule as a_matricule, agent.email as a_email, agent.civilite as a_civilite, agent.nom as a_nom,  agent.prenom as a_prenom')
            ->addSelect('agent.categorieAgent as a_categorieAgent, agent.corps as a_corps, agent.grade as a_grade, agent.affectation as a_affectation')
            ->addSelect('crep.dateNotification as c_dateNotification, crep.dateRefusNotification as c_dateRefusNotification')

            ->addSelect('formation.libelle as f_libelle')
            ->addSelect('formation.objectif as f_objectif')
            ->addSelect('formation.duree as f_duree')
            ->addSelect('formation.cpf as f_cpf')
            ->addSelect('formation.typologie as f_typologie')
            ->addSelect('formation.suivie as f_suivie')
            ->addSelect('formation.motifNonSuivie as f_motifNonSuivie')
            ->addSelect('formation.demandeeAgent as f_demandeeAgent, formation.avisShd as f_avisShd, formation.propositionAh as f_propositionAh, formation.echeance as f_echeance ')
            ->innerJoin('formation.crep', 'crep')

            ->innerJoin('crep.agent', 'agent')
            ->where('agent.campagneBrhp = :CAMPAGNE_BRHP')
            ->andWhere('crep.crepPapier IS NULL')
            ->andWhere('crep INSTANCE OF '.$modeleCrep)
            ->orderBy('agent.nom')
            ->addOrderBy('agent.prenom')
            ->setParameter('CAMPAGNE_BRHP', $campagneBrhp);

        $reslut = $qb->getQuery()->getScalarResult();

        return $reslut;
    }
}
