<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\EnumTypes\EnumCivilite;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Agent;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use AppBundle\Repository\ModeleCrepRepository;
use AppBundle\Entity\ModeleCrep;

class AgentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* @var $agent Agent */
        $agent = $builder->getData();
        $ministere = $agent->getCampagnePnc()->getMinistere();

        $unitesOrganisationnelles = $options['unitesOrganisationnelles'];
        $perimetresRlc = $options['perimetresRlc'];
        $perimetresBrhp = $options['perimetresBrhp'];
        $roleUtilisateur = $options['roleUtilisateur'];

        $disabled = true;

        // Si l'utilisateur connecté est Administrateur ou BRHP :
        // l'ensemble des champs de l'agent sont modifiables
        if (in_array($roleUtilisateur, ['ROLE_ADMIN', 'ROLE_PNC', 'ROLE_RLC', 'ROLE_BRHP'])) {
            $disabled = false;
        }

        $builder->add('matricule', null, ['required' => false, 'disabled' => $disabled])
                ->add('nomNaissance', null, ['required' => false, 'disabled' => $disabled])
                ->add('nomMarital', null, ['required' => false, 'disabled' => $disabled])
                ->add(
                    'dateNaissance',
                        DateType::class,
                        [
                            'label' => false,
                            'widget' => 'single_text',
                            'input' => 'datetime',
                            'format' => 'dd/MM/yyyy',
                            'required' => false,
                            'disabled' => $disabled,
                        ]
                )
                ->add('corps', null, ['required' => false, 'disabled' => $disabled])
                ->add(
                    'dateEntreeCorps',
                        DateType::class,
                        [
                            'label' => false,
                            'widget' => 'single_text',
                            'input' => 'datetime',
                            'format' => 'dd/MM/yyyy',
                            'required' => false,
                            'disabled' => $disabled,
                        ]
                )
                ->add('grade', null, ['required' => false, 'disabled' => $disabled])
                ->add(
                    'dateEntreeGrade',
                        DateType::class,
                        [
                            'label' => false,
                            'widget' => 'single_text',
                            'input' => 'datetime',
                            'format' => 'dd/MM/yyyy',
                            'required' => false,
                            'disabled' => $disabled,
                        ]
                )
                ->add('echelon', null, ['required' => false, 'disabled' => $disabled])
                ->add(
                    'dateEntreeEchelon',
                        DateType::class,
                        [
                            'label' => false,
                            'widget' => 'single_text',
                            'input' => 'datetime',
                            'format' => 'dd/MM/yyyy',
                            'required' => false,
                            'disabled' => $disabled,
                        ]
                )
                ->add('gradeEmploi', null, ['required' => false, 'disabled' => $disabled])
                ->add(
                    'dateEntreeGradeEmploi',
                        DateType::class,
                        [
                            'label' => false,
                            'widget' => 'single_text',
                            'input' => 'datetime',
                            'format' => 'dd/MM/yyyy',
                            'required' => false,
                            'disabled' => $disabled,
                        ]
                )
                ->add('etablissement', null, ['required' => false, 'disabled' => $disabled])
                ->add('departement', null, ['required' => false, 'disabled' => $disabled])
                ->add('affectation', null, ['required' => false, 'disabled' => $disabled])
                ->add('affectationClairAgent', null, ['required' => false, 'disabled' => $disabled])
                ->add('posteOccupe', null, ['required' => false, 'disabled' => $disabled])
                ->add(
                    'dateEntreePosteOccupe',
                        DateType::class,
                        [
                            'label' => false,
                            'widget' => 'single_text',
                            'input' => 'datetime',
                            'format' => 'dd/MM/yyyy',
                            'required' => false,
                            'disabled' => $disabled,
                        ]
                )
                ->add('codeSirh1', null, ['required' => false, 'disabled' => $disabled])
                ->add('codeSirh2', null, ['required' => false, 'disabled' => $disabled])
                ->add('capitalDif', TextType::class, ['required' => false, 'disabled' => $disabled])
                ->add('capitalDifMobilisable', TextType::class, ['required' => false, 'disabled' => $disabled])
                ->add('documents', CollectionType::class, array(
                    'entry_type' => UploadeDocumentType::class,
                    'allow_add' => true, // permettre à l'utilisateur d'ajouter des documents dynamiquement
                    'allow_delete' => true, // permettre à l'utilisateur de supprimer des documents dynamiquement
                    'label' => false,
                    'by_reference' => false,
                	'disabled' => $disabled,
                ))
                ->add('modeleCrep', EntityType::class, [
                        'class' => 'AppBundle:ModeleCrep',
                        'query_builder' => function (ModeleCrepRepository $er) use ($ministere) {
                            return $er->getModelesCrep($ministere, true, true);
                        },
                        'choice_label' => function (ModeleCrep $modeleCrep) {
                            return $modeleCrep->getLibelle().' ('.$modeleCrep->getTypeEntity().')';
                        },
                        'required' => false,
                        'disabled' => $disabled,
                ])
                ;

        if ('ROLE_SHD' == $roleUtilisateur) {
            $builder->add('shd', Select2EntityType::class, [
                    'multiple' => false,
                    'remote_route' => 'agent_new_server_processing_pnc',
                    'remote_params' => ['campagnePnc' => $agent->getCampagnePnc()->getId(), 'agent_id' => $agent->getId()],
                    'class' => 'AppBundle\Entity\Agent',
                    'primary_key' => 'id',
                    'text_property' => 'email',
                    'minimum_input_length' => 3,
                    'allow_clear' => true,
                    'delay' => 250,
                    'cache' => true,
                    'cache_timeout' => 60000, // 60 sec
                    'language' => 'fr',
                    'placeholder' => 'Email du N+1',
                    'disabled' => true,
            		'width' => '100%'
            ]);
        } else {
            $builder->add('shd', Select2EntityType::class, [
                    'multiple' => false,
                    'remote_route' => 'agent_new_server_processing_pnc',
                    'remote_params' => ['campagnePnc' => $agent->getCampagnePnc()->getId(), 'agent_id' => $agent->getId()],
                    'class' => 'AppBundle\Entity\Agent',
                    'primary_key' => 'id',
                    'text_property' => 'email',
                    'minimum_input_length' => 3,
                    'allow_clear' => true,
                    'delay' => 250,
                    'cache' => true,
                    'cache_timeout' => 60000, // 60 sec
                    'language' => 'fr',
                    'placeholder' => 'Email du N+1',
                    'disabled' => false,
            		'width' => '100%'
            ]);
        }

        $builder->add('ah', Select2EntityType::class, [
                'multiple' => false,
                'remote_route' => 'agent_new_server_processing_pnc',
                'remote_params' => ['campagnePnc' => $agent->getCampagnePnc()->getId(), 'agent_id' => $agent->getId()],
                'class' => 'AppBundle\Entity\Agent',
                'primary_key' => 'id',
                'text_property' => 'email',
                'minimum_input_length' => 3,
                'allow_clear' => true,
                'delay' => 250,
                'cache' => true,
                'cache_timeout' => 60000, // 60 sec
                'language' => 'fr',
                'placeholder' => 'Email du N+2',
        		'width' => '100%'
                        ])

                ->add(
                    'evaluable',
                        ChoiceType::class,
                        [
                            'choices' => [
                                            'Oui' => true,
                                            'Non' => false,
                                         ],
                            'expanded' => true,
                            'placeholder' => null,
                            'required' => false,
                            'multiple' => false,
                            'disabled' => false,
                        ]
                )
                ->add(
                    'sansAh',
                        ChoiceType::class,
                        [
                                'choices' => [
                                        'Oui' => true,
                                        'Non' => false,
                                ],
                            'expanded' => true,
                            'placeholder' => null,
                            'required' => false,
                            'multiple' => false,
                              'disabled' => false,
                        ]
                )
                ->add('motifNonEvaluation', null, ['required' => false, 'disabled' => false])
                ->add('categorieAgent', null, ['required' => false, 'disabled' => $disabled])
                ->add(
                    'civilite',
                        ChoiceType::class,
                        [
                            'choices' => [
                                            'M.' => EnumCivilite::MONSIEUR,
                                            'Mme' => EnumCivilite::MADAME,
                                        ],
                            'expanded' => false,
                            'multiple' => false,
                            'required' => false,
                            'disabled' => $disabled,
                        ]
                )
                ->add('nom', null, ['required' => false, 'disabled' => $disabled])
                ->add('prenom', null, ['required' => false, 'disabled' => $disabled]);

        // Ajout du champ email de l'agent
        if (in_array($roleUtilisateur, ['ROLE_ADMIN', 'ROLE_PNC', 'ROLE_RLC', 'ROLE_BRHP'])) {
            $builder->add('email', null, ['disabled' => false]);
        } else {
            $builder->add('email', null, ['disabled' => true]);
        }

        if ('ROLE_PNC' == $roleUtilisateur || 'ROLE_ADMIN' == $roleUtilisateur) {
            $builder->add(
                'perimetreRlc',
                    EntityType::class,
                    [
                            'class' => 'AppBundle\Entity\PerimetreRlc',
                            'choices' => $perimetresRlc,
                            'multiple' => false,
                            'required' => false,
                    ]
            );
        }
        if ('ROLE_RLC' == $roleUtilisateur || 'ROLE_ADMIN' == $roleUtilisateur) {
            $builder->add(
                'perimetreBrhp',
                            EntityType::class,
                            [
                                'class' => 'AppBundle\Entity\PerimetreBrhp',
                                'choices' => $perimetresBrhp,
                                'multiple' => false,
                                'required' => false,
                            ]
            );
        }
        if ('ROLE_BRHP' == $roleUtilisateur || 'ROLE_ADMIN' == $roleUtilisateur) {
            $builder->add(
                'uniteOrganisationnelle',
                            EntityType::class,
                            [
                                'class' => 'AppBundle\Entity\UniteOrganisationnelle',
                                'choices' => $unitesOrganisationnelles,
                                'multiple' => false,
                                'required' => false,
                                'disabled' => $disabled,
                            ]
            );
        }
        if ('ROLE_SHD' == $roleUtilisateur) {
            $builder->add(
                'uniteOrganisationnelle',
                            EntityType::class,
                            [
                                'class' => 'AppBundle\Entity\UniteOrganisationnelle',
                                'choices' => $unitesOrganisationnelles,
                                'multiple' => false,
                                'required' => false,
                                'disabled' => true,
                            ]
            );
        }

        /*
         * TODO: à déplacer dans AgentMccType
         *
         */

        if (3 == $agent->getCampagnePnc()->getMinistere()->getId()) {
            $builder->add('contrat', ChoiceType::class, [
                'choices' => [
                    'CDD' => 'cdd',
                    'CDI' => 'cdi',
                ],
                'expanded' => false,
                'multiple' => false,
                'required' => false,
            ])
                ->add(
                    'dateDebutContrat',
                    DateType::class,
                    array(
                        'label' => false,
                        'widget' => 'single_text',
                        'input' => 'datetime',
                        'format' => 'dd/MM/yyyy',
                        'required' => false,
                        )
                    )
                ->add(
                    'dateEntreeMinistere',
                    DateType::class,
                    array(
                        'label' => false,
                        'widget' => 'single_text',
                        'input' => 'datetime',
                        'format' => 'dd/MM/yyyy',
                        'required' => false,
                    )
                    )
                ->add(
                    'titulaire',
                    ChoiceType::class,
                    [
                        'choices' => [
                            'Oui' => 1,
                            'Non' => 0,
                        ],
                        'expanded' => true,
                        'placeholder' => null,
                        'required' => false,
                        'multiple' => false,
                        'disabled' => false,
                    ]
                )
               ;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Agent',
            'unitesOrganisationnelles' => null,
            'perimetresRlc' => null,
            'perimetresBrhp' => null,
            'roleUtilisateur' => null,
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
