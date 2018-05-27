#!/bin/bash

# Script à  planier du lundi au vendredi vers 7h00 du matin

BASEDIR=$(dirname "$0")

. $BASEDIR/init_vars.sh

COMMANDE="campagnePnc:ouvrir"

PARAMETRES="$1 $2"

if [ ! -f ${FLAG_LIVRAISON}  ]
then
	${APPLI_PHP_FILE} -c ${REP_CONF} ${COMMANDE_CONSOLE} ${COMMANDE} ${PARAMETRES} >>${REP_LOG}/${FIC_LOG} 2>&1
fi