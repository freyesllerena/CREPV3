<?php

namespace AppBundle\Traits;

use Doctrine\ORM\QueryBuilder;

trait ConditionsFiltre
{
    public function addFiltreCategories(QueryBuilder $qb, $categories)
    {
        // S'il n'y a pas de filtres sur les catégories on sort de la fonction
        if (empty($categories)) {
            return;
        }

        // Le code ci-dessous permet de faire l'équivalent SQL suivant :
        // WHERE agent.categorieAgent IS NULL OR agent.categorieAgent IN ('A', 'B' .....)
        $orX = $qb->expr()->orX();

        $conditionsOr = array();
        $categoriesAgentWithoutNull = [];

        foreach ($categories as $categorie) {
            if (null === $categorie) {
                $conditionsOr[] = $qb->expr()->isNull('agent.categorieAgent');
            } else {
                $categoriesAgentWithoutNull[] = $categorie;
            }
        }

        if (!empty($categoriesAgentWithoutNull)) {
            $conditionsOr[] = $qb->expr()->in('agent.categorieAgent', $categoriesAgentWithoutNull);
        }
        $orX->addMultiple($conditionsOr);
        $qb->andWhere($orX);
    }

    public function addFiltrePerimetresRlc(QueryBuilder $qb, $perimetresRlc)
    {
        // S'il n'y a pas de filtres sur les périmètres RLC on sort de la fonction
        if (empty($perimetresRlc)) {
            return;
        }

        $qb->leftJoin('agent.campagneRlc', 'campagneRlc');

        // Le code ci-dessous permet de faire l'équivalent SQL suivant :
        // WHERE campagneRlc.perimetreRlc IS NULL OR campagneRlc.perimetreRlc IN (1, 2, ...)
        $orX = $qb->expr()->orX();

        $conditionsOr = array();
        $perimetresRlcWithoutNull = [];

        foreach ($perimetresRlc as $perimetreRlc) {
            if (null === $perimetreRlc) {
                $conditionsOr[] = $qb->expr()->isNull('campagneRlc.perimetreRlc');
            } else {
                $perimetresRlcWithoutNull[] = $perimetreRlc->getId();
            }
        }
        if (!empty($perimetresRlcWithoutNull)) {
            $conditionsOr[] = $qb->expr()->in('campagneRlc.perimetreRlc', $perimetresRlcWithoutNull);
        }
        $orX->addMultiple($conditionsOr);
        $qb->andWhere($orX);
    }

    public function addFiltrePerimetresBrhp(QueryBuilder $qb, $perimetresBrhp)
    {
        // S'il n'y a pas de filtres sur les périmètres BRHP on sort de la fonction
        if (empty($perimetresBrhp)) {
            return;
        }
        $qb->leftJoin('agent.campagneBrhp', 'campagneBrhp');

        // Le code ci-dessous permet de faire l'équivalent SQL suivant :
        // WHERE campagneBrhp.perimetreBrhp IS NULL OR campagneBrhp.perimetreBrhp IN (1, 2, ...)
        $orX = $qb->expr()->orX();

        $conditionsOr = array();
        $perimetresBrhpWithoutNull = [];

        foreach ($perimetresBrhp as $perimetreBrhp) {
            if (null === $perimetreBrhp) {
                $conditionsOr[] = $qb->expr()->isNull('campagneBrhp.perimetreBrhp');
            } else {
                $perimetresBrhpWithoutNull[] = $perimetreBrhp->getId();
            }
        }
        if (!empty($perimetresBrhpWithoutNull)) {
            $conditionsOr[] = $qb->expr()->in('campagneBrhp.perimetreBrhp', $perimetresBrhpWithoutNull);
        }
        $orX->addMultiple($conditionsOr);
        $qb->andWhere($orX);
    }

    public function addFiltreAffectations(QueryBuilder $qb, $affectations)
    {
        // S'il n'y a pas de filtres sur les affectations on sort de la fonction
        if (empty($affectations)) {
            return;
        }
        // Le code ci-dessous permet de faire l'équivalent SQL suivant :
        // WHERE agent.affectation IS NULL OR agent.affectations IN ('A', 'B' .....)
        $orX = $qb->expr()->orX();

        $conditionsOr = array();
        $affectationsWithoutNull = [];

        foreach ($affectations as $affectation) {
            if (null === $affectation) {
                $conditionsOr[] = $qb->expr()->isNull('agent.affectation');
            } else {
                $affectationsWithoutNull[] = $affectation;
            }
        }

        if (!empty($affectationsWithoutNull)) {
            $conditionsOr[] = $qb->expr()->in('agent.affectation', $affectationsWithoutNull);
        }
        $orX->addMultiple($conditionsOr);
        $qb->andWhere($orX);
    }

    public function addFiltreCorps(QueryBuilder $qb, $corps)
    {
        // S'il n'y a pas de filtres sur les corps on sort de la fonction
        if (empty($corps)) {
            return;
        }

        // Le code ci-dessous permet de faire l'équivalent SQL suivant :
        // WHERE agent.corps IS NULL OR agent.corps IN ('A', 'B' .....)
        $orX = $qb->expr()->orX();

        $conditionsOr = array();
        $corpsWithoutNull = [];

        foreach ($corps as $c) {
            if (null === $c) {
                $conditionsOr[] = $qb->expr()->isNull('agent.corps');
            } else {
                $corpsWithoutNull[] = $c;
            }
        }

        if (!empty($corpsWithoutNull)) {
            $conditionsOr[] = $qb->expr()->in('agent.corps', $corpsWithoutNull);
        }
        $orX->addMultiple($conditionsOr);
        $qb->andWhere($orX);
    }
}
