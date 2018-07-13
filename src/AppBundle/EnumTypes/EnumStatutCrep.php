<?php

namespace AppBundle\EnumTypes;

/**
 * Class EnumStatutCrep
 * @package AppBundle\EnumTypes
 */
class EnumStatutCrep extends GeneriqueEnum
{
    const CREE = '01 créé';
    const MODIFIE_SHD = '02 modifié shd';
    const SIGNE_SHD = '03 signé SHD';
    const VISE_AGENT = '04 visé agent';
    const REFUS_VISA_AGENT = '05 refus visa agent';
    const SIGNE_AH = '06 signé AH';
    const NOTIFIE_AGENT = '07 notifié agent';
    const REFUS_NOTIFICATION_AGENT = '08 refus notification agent';
    const REFUS_EP = '10 refus EP';

    protected $name = 'enum_statut_crep';

    protected $values = array(
        self::CREE,
        self::MODIFIE_SHD,
        self::SIGNE_SHD,
        self::VISE_AGENT,
        self::REFUS_VISA_AGENT,
        self::SIGNE_AH,
        self::NOTIFIE_AGENT,
        self::REFUS_NOTIFICATION_AGENT,
        self::REFUS_EP,
    );
}
