<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class UniteOrganisationnelleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('code')
                ->add('libelle')
//         		->add('uniteOrganisationnelleMere', EntityType::class, array(
//         		    'class' => 'AppBundle:UniteOrganisationnelle',
//         		    'placeholder' => '',
//         		    'choice_label' => function ($uo) {
//                         return $uo->getCode().' : '.$uo->getLibelle();
//                     },

//         		))
                ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\UniteOrganisationnelle',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_unite_organisationnelle';
    }
}
