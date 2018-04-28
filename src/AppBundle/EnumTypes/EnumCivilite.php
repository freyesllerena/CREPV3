<?php

namespace AppBundle\EnumTypes;

class EnumCivilite extends GeneriqueEnum
{
    const MONSIEUR = 'm.';
    const MADAME = 'mme';

    protected $name = 'enum_civilite';
    protected $values = array('m.', 'mme');
}
