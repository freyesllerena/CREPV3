<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\EnumTypes\EnumErreurConstatee;

class StatutValidationAgentsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('validationShd', ChoiceType::class, array(
                            'choices' => array(
                                'Oui' => 1,
                                'Non' => 0,
                            ),
                            'expanded' => true,
                            'multiple' => false,
                            'required' => true,
                        ))

                ->add('erreurSignalee', ChoiceType::class, array(
                    'choices' => array(
                        null => null,
                        'Mauvais rattachement N+1' => EnumErreurConstatee::MAUVAIS_SHD,
                        'Mauvais rattachement N+2' => EnumErreurConstatee::MAUVAIS_AH,
                        'Autre' => EnumErreurConstatee::AUTRE,
                    ),
                ))

                ->add('commentaireValidation', null, ['required' => false])
                ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Agent',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_agent';
    }
}
