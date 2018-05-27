<?php

namespace AppBundle\EnumTypes;

class EnumRole extends GeneriqueEnum
{
    const ROLE_ADMIN_MIN = 'ROLE_ADMIN_MIN';
    const ROLE_PNC = 'ROLE_PNC';
    const ROLE_RLC = 'ROLE_RLC';
    const ROLE_BRHP = 'ROLE_BRHP';
    const ROLE_BRHP_CONSULT = 'ROLE_BRHP_CONSULT';
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_SHD = 'ROLE_SHD';
    const ROLE_AH = 'ROLE_AH';
    const ROLE_AGENT = 'ROLE_AGENT';

    protected $name = 'enum_role';
    protected $values = array('ROLE_ADMIN_MIN', 'ROLE_PNC', 'ROLE_RLC', 'ROLE_BRHP', 'ROLE_BRHP_CONSULT', 'ROLE_ADMIN', 'ROLE_SHD', 'ROLE_AH', 'ROLE_AGENT');
}
