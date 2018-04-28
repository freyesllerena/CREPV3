<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\EnumTypes\EnumTypeRecours;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use AppBundle\EnumTypes\EnumTypeResultatRecours;

class RecoursType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $roleUtilisateur = $options['roleUtilisateur'];

        $typesRecours = [];

        // Un BRHP ne peut déclarer qu'un recours hiérarchique
        if ('ROLE_BRHP' == $roleUtilisateur) {
            $typesRecours = [
                    'Recours hiérarchique' => EnumTypeRecours::RECOURS_HIERARCHIQUE,
            ];
        // Un RLC peut déclarer soit un recours en CAP ou au TA
        } elseif ('ROLE_RLC' == $roleUtilisateur) {
            $typesRecours = [
                    'Recours à la CAP' => EnumTypeRecours::RECOURS_CAP,
                    'Recours au tribunal administratif' => EnumTypeRecours::RECOURS_TRIBUNAL_ADMINISTRATIF,
            ];
        }

        $builder
                ->add(
                    'type',
                        ChoiceType::class,
                        [
                                'choices' => $typesRecours,
                                'expanded' => false,
                                'multiple' => false,
                                'required' => true,
                        ]
                )

                ->add(
                    'dateDemande',
                        DateType::class,
                        [
                            'label' => false,
                            'widget' => 'single_text',
                            'input' => 'datetime',
                            'format' => 'dd/MM/yyyy',
                            'required' => true,
                        ]
                )

                ->add(
                    'decision',
                        ChoiceType::class,
                        [
                            'choices' => [
                                //'Suppression du CREP de l\'agent'  => EnumTypeResultatRecours::SUPPRESSION,
                                'Modification du CREP de l\'agent' => EnumTypeResultatRecours::MODIFICATION,
                                'Pas de modification du CREP de l\'agent' => EnumTypeResultatRecours::PAS_DE_MODIFICATION,
                            ],
                                'expanded' => false,
                                'multiple' => false,
                                'required' => false,
                        ]
                )

                ->add(
                    'dateDecision',
                        DateType::class,
                        [
                            'label' => false,
                            'widget' => 'single_text',
                            'input' => 'datetime',
                            'format' => 'dd/MM/yyyy',
                            'required' => false,
                        ]
                );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Recours',
            'roleUtilisateur' => null,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_recours';
    }
}
