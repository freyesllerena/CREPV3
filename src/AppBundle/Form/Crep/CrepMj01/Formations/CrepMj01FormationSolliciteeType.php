<?php

namespace AppBundle\Form\Crep\CrepMj01\Formations;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CrepMj01FormationSolliciteeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('libelle')
        ->add('origine', ChoiceType::class, [
                'choices' => [
                        'proposée par l\'administration' => 0,
                        'demandée par l\'agent' => 1,
                        'demandée par les deux parties' => 2, ],
                'expanded' => false,
                'multiple' => false,
        ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepMj01\CrepMj01FormationSollicitee',
        ));
    }
}
