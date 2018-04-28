<?php

namespace AppBundle\Twig;

use AppBundle\EnumTypes\EnumStatutCampagne;

class CampagneStatutLabelExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter(
                'campagne_status_label',
                array(
                    $this,
                    'campagneStatusLabel',
                )
            ),
            new \Twig_SimpleFilter(
                'campagne_message',
                array(
                    $this,
                    'campagneMessage',
                )
            ),
        );
    }

    /**
     * var $status.
     */
    public function campagneStatusLabel($status)
    {
        $_status = '';
        switch ($status) {
            case EnumStatutCampagne::INITIALISEE:
                $_status = 'label-warning';
                break;

            case EnumStatutCampagne::CREEE:
                $_status = 'label-primary';
                break;

            case EnumStatutCampagne::OUVERTE:
                $_status = 'label-success';
                break;

            case EnumStatutCampagne::CLOTUREE:
                $_status = 'label-info';
                break;

            case EnumStatutCampagne::EXPIREE:
                $_status = 'label-warning';
                break;

            case EnumStatutCampagne::FERMEE:
                $_status = 'label-danger';
                break;

            case EnumStatutCampagne::SUPPRIMEE:
                $_status = 'label-danger';
                break;
        }

        return $_status;
    }

    /**
     * twig extension message information campage
     * Toutes les valeurs doivent être implementé
     * pour eviter toutes erreur.
     */
    public function campagneMessage($status, $type = 'message')
    {
        $messages = [
            EnumStatutCampagne::CREEE => "Listes en attente d'envoi.",
            EnumStatutCampagne::OUVERTE => 'Campagne ouverte.',
        ];

        $icones = [
            EnumStatutCampagne::CREEE => 'fa-hourglass-half',
            EnumStatutCampagne::OUVERTE => 'fa-thumbs-o-up',
        ];

        $alertClass = [
            EnumStatutCampagne::CREEE => 'alert-info',
            EnumStatutCampagne::OUVERTE => 'alert-success',
        ];

        $arguments = [
            'message' => $messages,
            'icone' => $icones,
            'alert' => $alertClass,
        ];

        return $arguments[$type][$status];
    }

    public function getName()
    {
        return 'campagne_status_label_extension';
    }
}
