<?php

namespace AppBundle\Form\Crep\CrepMso3;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\EnumTypes\EnumStatutCrep;
use AppBundle\Form\Crep\CrepType;

class CrepMso3AgentType extends CrepType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //Cette variable détermine les champs réservés à l'agent, et qu'il peut modifier uniquement durant le visa du CREP
        $disabled = true;

        if (EnumStatutCrep::SIGNE_SHD == $builder->getData()->getStatut()) {
            $disabled = false;
        }

        $builder
            ->add('fonctionsExercees', null, ['required' => false])
            ->add('cotationPoste', null, ['required' => false])
            ->add('quotiteTravail', null, ['required' => false])
            ->add('fichePosteAdaptee', ChoiceType::class, [
                    'choices' => [
                            'Oui' => 1,
                            'Non' => 0,
                    ],
                    'expanded' => true,
                    'multiple' => false,
                    'required' => false,
                    'placeholder' => null,
            ])
            ->add('pointsActualisesFichePoste', null, ['required' => false])
            ->add('appreciationPosteAgent', null, ['required' => false])
            ->add(
                'observationsAgentSurSonActivite',
                null,
                    [
                        'required' => false,
                        'disabled' => $disabled,
                    ]
            )
            ->add(
                'observationsAgentPerspectivesProfessionnelles',
                null,
                    [
                        'required' => false,
                        'disabled' => $disabled,
                    ]
            )
            ->add(
                'observationsVisaAgent',
                null,
                    [
                        'required' => false,
                        'disabled' => $disabled,
                    ]
            )
            ->add(
                'observationsAppreciationsPorteesAgent',
                null,
                    [
                        'required' => false,
                        'disabled' => $disabled,
                    ]
            )
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepMso3\CrepMso3',
            'echelleObjectifEvalue' => null,
            'echelleNiveauSame' => null,
            'selectTypologieFormation' => null,
            'ministere' => null,
               'anneeEvaluation' => null,
            'validation_groups' => array('Default', 'EnregistrementShd'),
        ));
    }
}
