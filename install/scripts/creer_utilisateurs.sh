#!/bin/bash

BASEDIR=$(dirname "$0")

. $BASEDIR/init_vars.sh

COMMANDE="utilisateurs:creer"

PARAMETRES="10"

# Boucle pour appeler la commande d'envoi de mail toutes les 10sec durant une heure
for x in $(seq  1 359);
do
		if [ -f ${FLAG_LIVRAISON}  ]
    	then
        	break
		fi
		
		${APPLI_PHP_FILE} -c ${REP_CONF} ${COMMANDE_CONSOLE} ${COMMANDE} ${PARAMETRES} >/dev/null 2>&1
        sleep 10
done ;

