<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Ministere;

class ModeleCrepRepository extends \Doctrine\ORM\EntityRepository
{
    // Cette requête retourne les modèles de crep actifs d'un ministère
    public function getModelesCrep($ministere = null, $actif = null)
    {
        $qb = $this->createQueryBuilder('mc');

        if ($ministere) {
            $qb->andWhere('mc.ministere = :MINISTERE')
               ->setParameter('MINISTERE', $ministere);
        }

        if ($actif) {
            $qb->andWhere('mc.actif = :ACTIF')
               ->setParameter('ACTIF', 1);
        }

        return $qb->getQuery()->getResult();
    }

    // Cette requête retourne le modèle de crep actif associé au libellé passé en paramètre
    public function getModeleCrepByLibelle($libelle, $ministere)
    {
        $qb = $this->createQueryBuilder('mc');

        $qb->andWhere('mc.libelle LIKE :LIBELLE')
            ->setParameter('LIBELLE', $libelle)
            ->andWhere('mc.actif = :ACTIF')
            ->setParameter('ACTIF', true)
            ->andWhere('mc.ministere = :MINISTERE')
            ->setParameter('MINISTERE', $ministere);

        return $qb->getQuery()->getSingleResult();
    }
}
