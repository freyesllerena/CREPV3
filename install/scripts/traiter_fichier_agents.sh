#!/bin/bash

BASEDIR=$(dirname "$0")

. $BASEDIR/init_vars.sh

COMMANDE="campagnePnc:traiterFichierPopulation"

PARAMETRES="$1"

if [ ! -f ${FLAG_LIVRAISON}  ]
then
	${APPLI_PHP_FILE} -c ${REP_CONF} ${COMMANDE_CONSOLE} ${COMMANDE} ${PARAMETRES} >>${REP_LOG}/${FIC_LOG} 2>&1
fi