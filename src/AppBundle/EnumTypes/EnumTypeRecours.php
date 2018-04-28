<?php

namespace AppBundle\EnumTypes;

class EnumTypeRecours extends GeneriqueEnum
{
    const RECOURS_HIERARCHIQUE = 0;
    const RECOURS_CAP = 1;
    const RECOURS_TRIBUNAL_ADMINISTRATIF = 2;

    protected $name = 'enum_types_recours';
    protected $values = array(0, 1, 2);
}
