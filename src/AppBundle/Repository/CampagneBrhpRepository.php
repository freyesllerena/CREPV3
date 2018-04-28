<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Utilisateur;
use AppBundle\EnumTypes\EnumStatutCampagne;
use AppBundle\Entity\Brhp;
use AppBundle\Entity\CampagnePnc;
use AppBundle\Entity\PerimetreBrhp;
use AppBundle\Entity\CampagneRlc;

/**
 * CampagneBrhpRepository.
 */
class CampagneBrhpRepository extends \Doctrine\ORM\EntityRepository
{
    public function findCampagnesRecentesBrhp($utilisateurCourant, $max = null)
    {
        $qb = $this->createQueryBuilder('c');

        if ($utilisateurCourant->hasRole('ROLE_ADMIN')) {
            $qb->leftJoin('c.campagneRlc', 'campagneRlc')
               ->leftJoin('campagneRlc.campagnePnc', 'campagnePnc')
               ->addOrderBy('campagnePnc.anneeEvaluee', 'DESC')
               ->addOrderBy('campagnePnc.ministere', 'ASC')
               ->addOrderBy('c.perimetreBrhp', 'ASC')
               ->addOrderBy('campagnePnc.libelle', 'ASC');

            return array_slice($qb->getQuery()->getResult(), 0, $max);
        }

        $qb->leftjoin('c.perimetreBrhp', 'perimetreBrhp')
            ->leftJoin('perimetreBrhp.brhps', 'brhp')
            ->leftJoin('c.campagneRlc', 'campagneRlc')
            ->leftJoin('campagneRlc.campagnePnc', 'campagnePnc')
            ->where('brhp.utilisateur = :UTILISATEUR')
            ->addOrderBy('campagnePnc.anneeEvaluee', 'DESC')
            ->addOrderBy('c.perimetreBrhp', 'ASC')
            ->addOrderBy('campagnePnc.libelle', 'ASC')
            ->setParameter('UTILISATEUR', $utilisateurCourant);

        return array_slice($qb->getQuery()->getResult(), 0, $max);
    }

    public function findCampagnesRecentesShd(Utilisateur $utilisateurCourant, $max = null)
    {
        $qb = $this->createQueryBuilder('c');

        if ($utilisateurCourant->hasRole('ROLE_ADMIN')) {
            $qb->leftjoin('c.agents', 'agent')
                ->where('c.statut NOT IN (:STATUTS)')
                ->setParameter('STATUTS', array(EnumStatutCampagne::INITIALISEE, EnumStatutCampagne::CREEE));

            return array_slice($qb->getQuery()->getResult(), 0, $max);
        }

        $qb->leftjoin('c.agents', 'agent')
           ->leftJoin('agent.campagnePnc', 'campagnePnc')
           ->leftJoin('agent.shd', 'shd')
           ->where('shd.utilisateur = :UTILISATEUR_SHD')
           ->andWhere('c.statut NOT IN (:STATUTS)')
           ->addOrderBy('campagnePnc.anneeEvaluee', 'DESC')
           ->addOrderBy('campagnePnc.libelle', 'ASC')
           ->setParameter('UTILISATEUR_SHD', $utilisateurCourant)
           ->setParameter('STATUTS', array(EnumStatutCampagne::INITIALISEE, EnumStatutCampagne::CREEE));

        return array_slice($qb->getQuery()->getResult(), 0, $max);
    }

    public function findCampagnesRecentesAh(Utilisateur $utilisateurCourant, $max = null)
    {
        $qb = $this->createQueryBuilder('c');

        if ($utilisateurCourant->hasRole('ROLE_ADMIN')) {
            $qb->leftjoin('c.agents', 'agent')
                ->where('c.statut NOT IN (:STATUTS)')
                ->setParameter('STATUTS', array(EnumStatutCampagne::INITIALISEE, EnumStatutCampagne::CREEE));

            return array_slice($qb->getQuery()->getResult(), 0, $max);
        }

        $qb->leftjoin('c.agents', 'agent')
           ->leftJoin('c.campagneRlc', 'campagneRlc')
           ->leftJoin('campagneRlc.campagnePnc', 'campagnePnc')
           ->leftJoin('agent.ah', 'ah')
           ->where('ah.utilisateur = :UTILISATEUR_AH')
           ->andWhere('c.statut NOT IN (:STATUTS)')
           ->addOrderBy('campagnePnc.anneeEvaluee', 'DESC')
           ->addOrderBy('campagnePnc.libelle', 'ASC')
           ->setParameter('UTILISATEUR_AH', $utilisateurCourant)
           ->setParameter('STATUTS', array(EnumStatutCampagne::INITIALISEE, EnumStatutCampagne::CREEE));

        return array_slice($qb->getQuery()->getResult(), 0, $max);
    }

    public function findCampagnesRecentesAgent(Utilisateur $utilisateurCourant, $max = null)
    {
        $qb = $this->createQueryBuilder('c');

        $qb->leftjoin('c.agents', 'agent')
           ->leftJoin('c.campagneRlc', 'campagneRlc')
           ->leftJoin('campagneRlc.campagnePnc', 'campagnePnc')
           ->where('agent.email = :EMAIL_AGENT')
           ->andWhere('c.statut NOT IN (:STATUTS)')
           ->andWhere('agent.evaluable = :EVALUABLE')
           ->addOrderBy('campagnePnc.anneeEvaluee', 'DESC')
           ->addOrderBy('campagnePnc.libelle', 'ASC')
           ->setParameter('EMAIL_AGENT', $utilisateurCourant->getEmail())
           ->setParameter('STATUTS', array(EnumStatutCampagne::INITIALISEE, EnumStatutCampagne::CREEE))
           ->setParameter('EVALUABLE', true);

        return array_slice($qb->getQuery()->getResult(), 0, $max);
    }

    public function countCampagnesBrhp(Utilisateur $utilisateurCourant, $statut)
    {
        $qb = $this->createQueryBuilder('c');

        $qb->select('COUNT(c)')
            ->leftjoin('c.perimetreBrhp', 'perimetreBrhp')
            ->leftJoin('perimetreBrhp.brhps', 'brhp')
            ->where('brhp.utilisateur = :UTILISATEUR')
            ->andWhere('c.statut = :STATUT')
            ->setParameter('UTILISATEUR', $utilisateurCourant)
            ->setParameter('STATUT', $statut);

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countCampagnesShd(Utilisateur $utilisateurCourant, $statut)
    {
        $qb = $this->createQueryBuilder('c');

        $qb->select('COUNT(DISTINCT c.id)')
           ->leftjoin('c.agents', 'agent')
           ->leftJoin('agent.shd', 'shd')
           ->where('shd.utilisateur = :UTILISATEUR_SHD')
           ->andWhere('c.statut = :STATUT')
           ->setParameter('UTILISATEUR_SHD', $utilisateurCourant)
           ->setParameter('STATUT', $statut);

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countCampagnesAh(Utilisateur $utilisateurCourant, $statut)
    {
        $qb = $this->createQueryBuilder('c');

        $qb->leftjoin('c.agents', 'agent')
        ->leftJoin('agent.ah', 'ah')
        ->where('ah.utilisateur = :UTILISATEUR_AH')
        ->andWhere('c.statut = :STATUT')
        ->setParameter('UTILISATEUR_AH', $utilisateurCourant)
        ->setParameter('STATUT', $statut);

        return count($qb->getQuery()->getResult());
    }

    /**
     * Récupère les camapgnes accessibles par le brhp passé en paramètre.
     */
    public function getCampagnes(Brhp $brhp)
    {
        $qb = $this->createQueryBuilder('c')
        ->where('c.perimetreBrhp IN (:PERIMETRES)')
        ->setParameter('PERIMETRES', $brhp->getPerimetresBrhp());

        return $qb->getQuery()->getResult();
    }

    public function getCampagneBrhp(CampagnePnc $campagnePnc, PerimetreBrhp $perimetreBrhp)
    {
        $qb = $this->createQueryBuilder('c');

        $qb->leftJoin('c.campagneRlc', 'campagneRlc')
        ->leftJoin('campagneRlc.campagnePnc', 'campagnePnc')
        ->where('campagnePnc = :CAMPAGNE_PNC')
        ->andWhere('c.perimetreBrhp = :PERIMETRE_BRHP')
        ->setParameter('CAMPAGNE_PNC', $campagnePnc)
        ->setParameter('PERIMETRE_BRHP', $perimetreBrhp);

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function getCampagnesBrhpByCampagnePnc(CampagnePnc $campagnePnc)
    {
        $qb = $this->createQueryBuilder('c');

        $qb->leftJoin('c.campagneRlc', 'campagneRlc')
        ->leftJoin('campagneRlc.campagnePnc', 'campagnePnc')
        ->where('campagnePnc = :CAMPAGNE_PNC')
        ->setParameter('CAMPAGNE_PNC', $campagnePnc);

        return $qb->getQuery()->getResult();
    }

    public function getCampagnesBrhpByCampagneRlc(CampagneRlc $campagneRlc)
    {
        $qb = $this->createQueryBuilder('campagneBrhp');

        $qb->leftJoin('campagneBrhp.campagneRlc', 'campagneRlc')
        ->where('campagneRlc = :CAMPAGNE_RLC')
        ->setParameter('CAMPAGNE_RLC', $campagneRlc);

        return $qb->getQuery()->getResult();
    }
}
