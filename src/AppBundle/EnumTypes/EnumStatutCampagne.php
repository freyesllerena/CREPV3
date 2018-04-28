<?php

namespace AppBundle\EnumTypes;

class EnumStatutCampagne extends GeneriqueEnum
{
    const INITIALISEE = 'initialisée';
    const CLOTUREE = 'clôturée';
    const CREEE = 'créée';
    const OUVERTE = 'ouverte';
    const SUPPRIMEE = 'supprimée';
    const FERMEE = 'fermée';
    const EXPIREE = 'expirée';

    protected $name = 'enum_statut_campagne';

    protected $values = array(
        self::INITIALISEE,
        self::CLOTUREE,
        self::CREEE,
        self::OUVERTE,
        self::SUPPRIMEE,
        self::FERMEE,
        self::EXPIREE,
    );
}
