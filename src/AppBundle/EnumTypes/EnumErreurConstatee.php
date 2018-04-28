<?php

namespace AppBundle\EnumTypes;

class EnumErreurConstatee extends GeneriqueEnum
{
    const MAUVAIS_SHD = 'Mauvais rattachement N+1';
    const MAUVAIS_AH = 'Mauvais rattachement N+2';
    const AUTRE = 'Autre';

    protected $name = 'enum_erreur_constatee';
    protected $values = array('Mauvais rattachement N+1', 'Mauvais rattachement N+2', 'Autre');
}
