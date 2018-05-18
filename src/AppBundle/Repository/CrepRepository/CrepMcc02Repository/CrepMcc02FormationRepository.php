<?php

namespace AppBundle\Repository\CrepRepository\CrepMcc02Repository;

use AppBundle\Entity\CampagneBrhp;
use AppBundle\EnumTypes\EnumStatutCrep;

class CrepMcc02FormationRepository extends \Doctrine\ORM\EntityRepository
{
    public function exportFormations(CampagneBrhp $campagneBrhp, $modeleCrep)
    {
        $qb = $this->createQueryBuilder('formation');
        $qb
        ->select('agent.matricule as a_matricule, agent.email as a_email, agent.civilite as a_civilite, agent.nom as a_nom,  agent.prenom as a_prenom')
        ->addSelect('agent.categorieAgent as a_categorieAgent, agent.corps as a_corps, agent.grade as a_grade, agent.affectation as a_affectation')
        ->addSelect('crep.dateNotification as c_dateNotification, crep.dateRefusNotification as c_dateRefusNotification')

        ->addSelect('formation.libelle as f_libelle')
        ->addSelect('formation.commentaires as f_commentaires')
        ->innerJoin('formation.crep', 'crep')
        ->innerJoin('crep.agent', 'agent')

        ->where('agent.campagneBrhp = :CAMPAGNE_BRHP')
//        ->andWhere('crep.statut IN(:STATUTS_CREPS_FINALISE)')
        ->andWhere('crep.crepPapier IS NULL')
        ->andWhere('crep INSTANCE OF '.$modeleCrep)
        ->orderBy('agent.nom')
        ->addOrderBy('agent.prenom')
        ->setParameter('CAMPAGNE_BRHP', $campagneBrhp);
//        ->setParameter('STATUTS_CREPS_FINALISE', [EnumStatutCrep::NOTIFIE_AGENT, EnumStatutCrep::REFUS_NOTIFICATION_AGENT]);
        echo $qb->getQuery()->getSQL();die;
        $reslut = $qb->getQuery()->getScalarResult();

        return $reslut;
    }
}
