<?php

namespace AppBundle\EnumTypes;

class EnumStatutValidationAgent extends GeneriqueEnum
{
    const VALIDE = 'rattachement validé';
    const EN_COURS = 'rattachement en attente de validation';
    const ERREUR_SIGNALEE = 'erreur signalée';
    const REJETE = 'rattachement rejeté';

    protected $name = 'enum_statut_validation_agent';

    protected $values = array(self::VALIDE,
                                self::EN_COURS,
                                self::ERREUR_SIGNALEE,
                                self::REJETE, );
}
