<?php

namespace AppBundle\EventListener;

use Doctrine\DBAL\Event\ConnectionEventArgs;
use Doctrine\DBAL\Event\Listeners\OracleSessionInit as BaseOracleSessionInit;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * Custom OracleSessionInit.
 */
class AppOracleSessionInit
{
    /**
     * Methode qui s'execute sur une connexion OK.
     *
     * @param InteractiveLoginEvent $event
     */
    public function postConnect(ConnectionEventArgs $args)
    {
        $sessionVars = [
                            'NLS_LANGUAGE' => 'FRENCH',
                            'NLS_TERRITORY' => 'FRANCE',
                            'NLS_CURRENCY' => '€',
                            'NLS_ISO_CURRENCY' => 'FRANCE',
                            'NLS_CALENDAR' => 'GREGORIAN',
                            'NLS_DATE_LANGUAGE' => 'FRENCH',
                            'NLS_SORT' => 'BINARY_AI',
                            'NLS_DUAL_CURRENCY' => '€',
                            'NLS_COMP' => 'LINGUISTIC',
                            'NLS_LENGTH_SEMANTICS' => 'BYTE',
                            'NLS_NCHAR_CONV_EXCP' => 'FALSE',
        ];

        $oracleSessionInit = new BaseOracleSessionInit($sessionVars);
        $oracleSessionInit->postConnect($args);
    }
}
