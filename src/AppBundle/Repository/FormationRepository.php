<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Ministere;

/**
 * FormationRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FormationRepository extends \Doctrine\ORM\EntityRepository
{
    public function getFormationsValides(Ministere $ministere)
    {
        return $this->createQueryBuilder('f')
            ->where('f.ministere = :MINISTERE')
            ->andWhere('f.dateFinValidite >= :DATE_FIN_VALIDITE')
            ->orderBy('f.libelle', 'DESC')
            ->setParameter('MINISTERE', $ministere)
            ->setParameter('DATE_FIN_VALIDITE', new \DateTime());
    }

    public function getFormations(Ministere $ministere)
    {
        return $this->createQueryBuilder('f')
        ->where('f.ministere = :MINISTERE')
        ->andWhere('f.dateFinValidite >= :DATE_FIN_VALIDITE')
        ->orderBy('f.libelle', 'DESC')
        ->setParameter('MINISTERE', $ministere)
        ->setParameter('DATE_FIN_VALIDITE', new \DateTime())
        ->getQuery()->getResult();
    }

    public function dataTableServerProcessing($ministere, $search, $page = 0, $max = null, $getResult = true, $columnOrder = 1, $dirOrder = 'asc')
    {
        $orders = array(
                'f.code',
                'f.libelle',
                'f.duree',
        );

        $qb = $this->createQueryBuilder('f');

        $qb->leftJoin('f.ministere', 'm');

        // Filtre sur le ministere
        $qb->andWhere('m.id = :MINISTERE')
        ->setParameter('MINISTERE', $ministere);

        // recherches
        if ($search) {
            $search = trim($search);

            $orX = $qb->expr()->orX();
            $conditionsLike = array();

            $conditionsLike[] = $qb->expr()->like('f.code', ':search');
            $conditionsLike[] = $qb->expr()->like('f.libelle', ':search');
            $conditionsLike[] = $qb->expr()->like('f.duree', ':search');

            $orX->addMultiple($conditionsLike);

            $qb->andWhere($orX);

            $qb->setParameter('search', '%'.$search.'%');
        }

        // ordres
        $qb->orderBy($orders[$columnOrder], $dirOrder);

        // pagination
        if ($max) {
            $preparedQuery = $qb->getQuery()
            ->setMaxResults($max)
            ->setFirstResult($page * $max);
        } else {
            $preparedQuery = $qb->getQuery();
        }

        return $getResult ? $preparedQuery->getResult() : $preparedQuery;
    }

    public function supprimerReferentielFormation(Ministere $ministere)
    {
        $this->createQueryBuilder('f')->delete()
        ->where('f.ministere = :MINISTERE')
        ->setParameter('MINISTERE', $ministere)
        ->getQuery()->execute();
    }

    public function getNbFormations(Ministere $ministere)
    {
        $qb = $this->createQueryBuilder('formation');
        $qb->select('COUNT(formation)')
        ->where('formation.ministere = :MINISTERE')
        ->setParameter('MINISTERE', $ministere);

        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * Methode appelée par l'autocomple ajax de jQuerry.
     *
     * @param unknown $ministere_id
     * @param unknown $search
     *
     * @return un tableau avec le format attendu par jQuery : [{'value': 'ma valeur', 'data': 'ma donnee'}]:
     */
    public function searchAjax(Ministere $ministere, $search)
    {
        $search = trim($search);

        $qb = $this->createQueryBuilder('formation');
        $qb->select('formation.libelle as value')
        ->addSelect('formation.libelle as data')
        ->where('formation.ministere = :MINISTERE')
        ->andWhere('formation.libelle LIKE :SEARCH')
        ->setParameter('MINISTERE', $ministere)
        ->setParameter('SEARCH', '%'.$search.'%');

        return $qb->getQuery()->getScalarResult();
    }

    public function countFormations($ministere, $search = null)
    {
        $qb = $this->createQueryBuilder('f');
        $qb->select('count(f)');

        $qb->where('f.ministere = :MINISTERE')
        ->setParameter('MINISTERE', $ministere);

        // recherches
        if ($search) {
            $search = trim($search);

            $orX = $qb->expr()->orX();
            $conditionsLike = array();

            $conditionsLike[] = $qb->expr()->like('f.code', ':search');
            $conditionsLike[] = $qb->expr()->like('f.libelle', ':search');
            $conditionsLike[] = $qb->expr()->like('f.duree', ':search');

            $orX->addMultiple($conditionsLike);

            $qb->andWhere($orX);

            $qb->setParameter('search', '%'.$search.'%');
        }

        return $qb->getQuery()->getSingleScalarResult();
    }
}
