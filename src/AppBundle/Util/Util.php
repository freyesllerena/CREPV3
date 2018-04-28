<?php

namespace AppBundle\Util;

class Util
{
    /**
     * Retourne le nom de la classe de l'objet passé en paramètre (sans le namespace).
     *
     * @param object $object
     *
     * @return string
     */
    public static function getClassName($object)
    {
        $class = get_class($object);
        $path = explode('\\', $class);

        return array_pop($path);
    }

    /**
     * Cette fonction retourne un tableau de timestamp correspondant
     * aux jours fériés en France pour une année donnée.
     */
    public static function getHolidays($year = null)
    {
        if (null === $year) {
            $year = intval(date('Y'));
        }

        $easterDate = easter_date($year);
        $easterDay = date('j', $easterDate);
        $easterMonth = date('n', $easterDate);
        $easterYear = date('Y', $easterDate);

        $holidays = array(
                // Dates fixes
                mktime(0, 0, 0, 1, 1, $year),  // 1er janvier
                mktime(0, 0, 0, 5, 1, $year),  // Fête du travail
                mktime(0, 0, 0, 5, 8, $year),  // Victoire des alliés
                mktime(0, 0, 0, 7, 14, $year),  // Fête nationale
                mktime(0, 0, 0, 8, 15, $year),  // Assomption
                mktime(0, 0, 0, 11, 1, $year),  // Toussaint
                mktime(0, 0, 0, 11, 11, $year),  // Armistice
                mktime(0, 0, 0, 12, 25, $year),  // Noel

                // Dates variables
                mktime(0, 0, 0, $easterMonth, $easterDay + 1, $easterYear),
                mktime(0, 0, 0, $easterMonth, $easterDay + 39, $easterYear),
                mktime(0, 0, 0, $easterMonth, $easterDay + 50, $easterYear),
        );

        sort($holidays);

        return $holidays;
    }

    /*
     * Calculer une date en ajoutant un nombre de jours ouvres à une date de début
     */
    public static function calculeDate(\DateTime $dateDeb, $nbJoursOuvres)
    {
        // On clone la date passée en paramètres afin de ne pas la modifier
        $dateDebut = clone $dateDeb;

        if ($nbJoursOuvres <= 0) {
            return $dateDebut;
        }

        $heureDebut = $dateDebut->format('H:i:s');
        $dateDebut->setTime(0, 0, 0);

        while ($nbJoursOuvres > 0) {
            $date = $dateDebut->add(new \DateInterval('P1D'));
            $jourSemaine = $date->format('w');
            $feries = Util::getHolidays($date->format('Y'));

            if (0 != $jourSemaine && 6 != $jourSemaine) { // Contrôle du week-end
                if (!in_array($date->getTimestamp(), $feries)) { // Contrôle des jours feriés
                    --$nbJoursOuvres;
                }
            }
        }

        return new \DateTime($date->format('Y-m-d').' '.$heureDebut);
    }

    public static function twig_capitalize($string)
    {
        $charset = 'UTF-8';

        return mb_strtoupper(mb_substr($string, 0, 1, $charset), $charset).mb_strtolower(mb_substr($string, 1, mb_strlen($string, $charset), $charset), $charset);
    }

    public static function twig_upper($string)
    {
        $charset = 'UTF-8';

        return mb_strtoupper($string, $charset);
    }

    public static function twig_lower($string)
    {
        $charset = 'UTF-8';

        return mb_strtolower($string, $charset);
    }

    public static function twig_title($string)
    {
        $charset = 'UTF-8';

        return mb_convert_case($string, MB_CASE_TITLE, $charset);
    }

    public static function validerEmail($email)
    {
        $regex = "/^[a-zA-Z0-9@_.\-\+']+$/";

        if (!preg_match($regex, $email)          // caractères autorisés : minuscules, majuscules, chiffres, "-", "@", ".", et "_"
            || substr_count($email, '@') > 1      // présence de plus d'un @
            || substr_count($email, '..') > 0     // présence de deux points '..'
            || substr_count($email, '.@') > 0     // Le caractère . est situé juste avant le caractère @
        ) {
            return false;
        }

        return true;
    }
}
