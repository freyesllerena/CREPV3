<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Entity\Utilisateur;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

class ChoixUtilisateurType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('utilisateur', Select2EntityType::class, [
                'multiple' => false,
                'remote_route' => 'utilisateur_ajax_search',
                'class' => 'AppBundle\Entity\Utilisateur',
                'placeholder' => 'Choisir un utilisateur',
                'primary_key' => 'id',
                'text_property' => 'email',
                'minimum_input_length' => 3,
                'allow_clear' => true,
                'delay' => 250,
                'cache' => true,
                'cache_timeout' => 60000, // 60 sec
                'language' => 'fr',
        		'width' => '100%'
        ]);
    }
}
