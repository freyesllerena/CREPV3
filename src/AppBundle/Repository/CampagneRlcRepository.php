<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Ministere;
use AppBundle\Entity\Utilisateur;
use AppBundle\Entity\Rlc;
use AppBundle\Entity\CampagnePnc;
use AppBundle\Entity\PerimetreRlc;

/**
 * CampagneRlcRepository.
 */
class CampagneRlcRepository extends \Doctrine\ORM\EntityRepository
{
    public function findCampagnesRecentes(Utilisateur $utilisateurCourant, $max = null)
    {
        $qb = $this->createQueryBuilder('c');

        if ($utilisateurCourant->hasRole('ROLE_ADMIN')) {
            $qb->leftJoin('c.campagnePnc', 'campagnePnc')
                ->addOrderBy('campagnePnc.anneeEvaluee', 'DESC')
                ->addOrderBy('campagnePnc.ministere', 'ASC')
                ->addOrderBy('c.perimetreRlc', 'ASC')
                ->addOrderBy('campagnePnc.libelle', 'ASC');

            return array_slice($qb->getQuery()->getResult(), 0, $max);
        }

        $qb->leftjoin('c.perimetreRlc', 'perimetreRlc')
           ->leftJoin('perimetreRlc.rlcs', 'rlc')
           ->leftJoin('c.campagnePnc', 'campagnePnc')
           ->where('rlc.utilisateur = :UTILISATEUR')
           ->addOrderBy('campagnePnc.anneeEvaluee', 'DESC')
           ->addOrderBy('c.perimetreRlc', 'ASC')
           ->addOrderBy('campagnePnc.libelle', 'ASC')
           ->setParameter('UTILISATEUR', $utilisateurCourant);

        return array_slice($qb->getQuery()->getResult(), 0, $max);
    }

    /**
     * Renvoie le nombre de campagnes au statut $statut.
     */
    public function countCampagnesRlc(Utilisateur $utilisateur, $statut)
    {
        $qb = $this->createQueryBuilder('c');

        $qb->select('COUNT(c)')
            ->leftjoin('c.perimetreRlc', 'perimetreRlc')
            ->leftJoin('perimetreRlc.rlcs', 'rlc')
            ->where('rlc.utilisateur = :UTILISATEUR')
            ->andWhere('c.statut = :STATUT')
            ->setParameter('UTILISATEUR', $utilisateur)
            ->setParameter('STATUT', $statut);

        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * Récupère les camapgnes accessibles par le rlc passé en paramètre.
     */
    public function getCampagnes(Rlc $rlc)
    {
        $qb = $this->createQueryBuilder('c')
        ->where('c.perimetreRlc IN (:PERIMETRES)')
        ->setParameter('PERIMETRES', $rlc->getPerimetresRlc());

        return $qb->getQuery()->getResult();
    }

    public function getCampagneRlc(CampagnePnc $campagnePnc, PerimetreRlc $perimetreRlc)
    {
        $qb = $this->createQueryBuilder('c');

        $qb->where('c.campagnePnc = :CAMPAGNE_PNC')
        ->andWhere('c.perimetreRlc = :PERIMETRE_RLC')
        ->setParameter('CAMPAGNE_PNC', $campagnePnc)
        ->setParameter('PERIMETRE_RLC', $perimetreRlc);

        return $qb->getQuery()->getOneOrNullResult();
    }
}
