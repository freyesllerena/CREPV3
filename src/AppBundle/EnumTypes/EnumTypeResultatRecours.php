<?php

namespace AppBundle\EnumTypes;

class EnumTypeResultatRecours extends GeneriqueEnum
{
    const SUPPRESSION = 0;
    const MODIFICATION = 1;
    const PAS_DE_MODIFICATION = 2;

    protected $name = 'enum_types_resultat_recours';
    protected $values = array(0, 1, 2);
}
