#!/bin/bash

BASEDIR=$(dirname "$0")

. $BASEDIR/init_vars.sh

# Nettoyage des fichiers temporaires datant d'il y a plus d'une heure
find ${HTTP_REP_PRODUIT_AS}/docroot/${REP_SOURCES}/var/tmp/ -mindepth 1 -depth -mmin +59 -exec rm -rf {} \;