#!/bin/bash

BASEDIR=$(dirname "$0")

. $BASEDIR/init_vars.sh

FIC_LOG="sendmail.log"

COMMANDE_PROD="swiftmailer:spool:send --env=prod"
COMMANDE_DEV="swiftmailer:spool:send --env=dev"

PARAMETRES=""

# Boucle pour appeler la commande d'envoi de mail toutes les 10sec durant une heure
for x in $(seq  1 359);
do
		if [ -f ${FLAG_LIVRAISON}  ]
    	then
        	break
		fi
		
		${APPLI_PHP_FILE} -c ${REP_CONF} ${COMMANDE_CONSOLE} ${COMMANDE_PROD} ${PARAMETRES} >>${REP_LOG}/${FIC_LOG} 2>&1
		
		${APPLI_PHP_FILE} -c ${REP_CONF} ${COMMANDE_CONSOLE} ${COMMANDE_DEV} ${PARAMETRES} >>${REP_LOG}/${FIC_LOG} 2>&1
		
        sleep 10
done ;
