<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\EnumTypes\EnumStatutCrep;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Valid;

class ImportCrepPapierType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $modelesCrep = $options['modelesCrep'];

        $builder
                ->add(
                    'statut',
                    ChoiceType::class,
                        ['placeholder' => '',
                                'choices' => [
                                        'L\'agent a signé son CREP notifié' => EnumStatutCrep::NOTIFIE_AGENT,
                                        'L\'agent a refusé de signer son CREP notifié' => EnumStatutCrep::REFUS_NOTIFICATION_AGENT,
//                                         'Absence de l\'agent' => EnumStatutCrep::CAS_ABSENCE,
                                ],
                                'mapped' => false,
                                'constraints' => [
                                                    new NotBlank(['message' => 'Veuillez sélectionner un statut',
                                                                    'groups' => ['chargement_crep_pdf'],
                                                    ]),
                                                    new Choice(['choices' => [EnumStatutCrep::NOTIFIE_AGENT,
                                                                                EnumStatutCrep::REFUS_NOTIFICATION_AGENT,
                                                                                EnumStatutCrep::CAS_ABSENCE,
                                                                            ],
                                                                'message' => 'Veuillez sélectionner un statut valide',
                                                                'groups' => ['chargement_crep_pdf'],
                                                    ]),
                                                ],
                        ]
                    )

                ->add('crepPapier', UploadeDocumentType::class, [
                                                                    'mapped' => false,
                                                                    'constraints' => [new Valid()],
                ]);

        $modeleCrepOptions = [
                                        'class' => 'AppBundle\Entity\ModeleCrep',
                                        'choices' => $modelesCrep,
                                        'multiple' => false,
                                        'required' => true,
                                        'mapped' => false,
                                ];

        // pour gérer la sélection du modèle de CREP par defaut quand il y en a un seul
        if (count($modelesCrep) > 1) {
            $modeleCrepOptions['placeholder'] = '';
        }

        $builder->add('modeleCrep', EntityType::class, $modeleCrepOptions);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'modelesCrep' => null,
            'validation_groups' => ['Default', 'chargement_crep_pdf'],
        ]);
    }
}
