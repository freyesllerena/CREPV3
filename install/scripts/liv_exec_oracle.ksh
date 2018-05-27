#!/bin/ksh
###############################################################
#                          CISIRH                             #
###############################################################
# script ksh  liv_exec_mysql.ksh
# utilisation : liv_exec_mysql.ksh <option> <parametre>
# cree par    : INNOVATION / BT - 23/12/2016
###############################################################
# Description
# Script d execution de script mysql
#
###############################################################
# Historique des modifications
# 23/12/2016 - V1.0  - INNOVATION / BT - Creation
#
###############################################################
# Codes retour
#  0 : Sortie sans erreur
#
################################################################

echo "-----------------------------------------------------------"
# Le script sera execute par httadmin
utilisateur=`whoami`
if test "$utilisateur"="httadmin" ; then
  echo "OK : Verification de l utilisateur"
else
  echo "KO : L'utilisateur doit etre httadmin"
  echo "-----------------------------------------------------------"
  exit 11
fi

. /exploit/commun/script/onp_lib_cmn.ksh

# --------------------------------------------- #
# Fonction de formatage du message
# --------------------------------------------- #

Log_ecriture()
    {
     #--- Fonction pour ecrire un message d information dans le fichier de log
     #--- Pre-requis : Renseigner et exporter la variable ONP_FIC_LOG en debut de script
     #--- Usage : Log_ecriture "message" <INF|AVT|ERR|BUG>

     log_val_date=$(date "+%Y/%m/%d %H:%M:%S") # Recuperation du time-stamp
     log_val_nom_script=$(basename ${0})       # Recuperation du nom du script
     log_val_niveau=$1                         # Recuperation du niveau de la log
     log_val_info=$2                           # Recuperation de l info a tracer
     log_val_format="${log_val_date} [${log_val_niveau}] [${log_val_nom_script}] ${log_val_info}" # Construction du message
     echo ${log_val_format}
    }

# --------------------------------------------- #
# Test et Valorisation de variables
# --------------------------------------------- #

if [ $# -eq "1" ]
    then
        ora_param_objet=${1}
    else
        Log_ecriture ERR "Usage : liv_exec_oracle.ksh <repertoire/fichier ou repertoire complet a traiter> "
        exit 99
fi

# --------------------------------------------- #
# Test sur l objet a traiter
# --------------------------------------------- #

# test si le parametre est un fichier ou un repertoire complet
# pour qu un fichier soit traite il doit respecter un format :
# commencer par 2 chiffres - (ex : 01-xxx ) et finire par .sql


APPLI_DATABASE_USER=@@APPLI_DATABASE_USER@@
APPLI_DATABASE_USER_PASSWORD=$(Get_password APPLI_DATABASE_USER_PASSWORD_@@HTTP_NOM_APPLI@@_@@APPLI_ENV@@;echo $ONP_USER_PASSWORD)
APPLI_DATABASE_NAME=@@APPLI_DATABASE_NAME@@


if [ ! -d "${ora_param_objet}" ]
    then
        if [ -s "${ora_param_objet}" -a $(echo ${ora_param_objet} | grep ".sql"$ | wc -l) -eq "1"  ]
            then
                sqlplus ${APPLI_DATABASE_USER}/${APPLI_DATABASE_USER_PASSWORD}@${APPLI_DATABASE_NAME} @${ora_param_objet}
                if [ $? -ne 0 ]
                    then
                        Log_ecriture ERR "erreur lors de l execution du script sql : ${ora_param_objet} "
                        exit 99
                fi
            else
                Log_ecriture ERR  "Mauvais format du fichier : fichier ${ora_param_objet} inexistant vide ou sans extension en .sql "
        fi
    else
        nb_fic_total=$(ls -1 ${ora_param_objet} | grep ".sql"$ | sort | wc -l )
        nb_fic_bon=$(ls -1 ${ora_param_objet} | grep ".sql"$ | sort | grep ^[0-9][0-9] | wc -l )
        if [ "${nb_fic_total}" != "${nb_fic_bon}" ]
            then
                Log_ecriture ERR "le nom de certains fichiers presents dans le repertoire n est pas correctement formate"
                exit 99
            else
                cd ${ora_param_objet}
                ls -1 ${ora_param_objet} | grep ".sql"$ | sort | grep ^[0-9][0-9] | while read ora_param_fic
                     do
                         ora_fic_log="/tmp/$(echo ${ora_param_fic}| sed s'/.sql/.log/')"
                         sqlplus ${APPLI_DATABASE_USER}/${APPLI_DATABASE_USER_PASSWORD}@${APPLI_DATABASE_NAME} @${ora_param_fic} > ${ora_fic_log}
                         if [ $? -ne 0 ]
                             then
                                 Log_ecriture ERR "erreur lors de l execution du script sql : ${ora_param_fic} "
                                 exit 99
                             else
                                 Log_ecriture INF "CODE RETOUR 00 pour SQL : ${ora_param_fic} "
                                 Log_ecriture INF "Fichier log : ${ora_fic_log}"
                         fi
                     done
        fi
fi
