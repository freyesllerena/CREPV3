<?php

namespace AppBundle\Form\Crep\CrepMinefContract;

use AppBundle\Form\ObjectifFuturType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use AppBundle\Form\Crep\CrepType;

class CrepMinefContractType extends CrepType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* @var $crep CrepMinefContract */
        $crep = $builder->getData();

        $options['selectTypologieFormation'] = $crep::$selectTypologieFormation;
        $options['ministere'] = $crep->getAgent()->getCampagnePnc()->getMinistere();

        parent::buildForm($builder, $options);

        $builder
            ->add('nomUsage')
            ->add('prenom')
            ->add(
                'dateNaissance',
                DateType::class,
                array(
                    'label' => false,
                    'widget' => 'single_text',
                    'input' => 'datetime',
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                    )
                )
            ->add('categorieAgent', null, ['required' => false])

            ->add('directionAffectation', null, [
                                'attr' => ['maxlength' => '4096'],
                                'required' => false, ])
            ->add('motifRefusEntretien', null, [
                                'attr' => ['maxlength' => '4096'],
                                'required' => false, ])
            ->add('descriptionFonctions', null, [
                                'attr' => ['maxlength' => '4096'],
                                'required' => false, ])
            ->add(
                'datePriseFonctions',
                DateType::class,
                array(
                    'label' => false,
                    'widget' => 'single_text',
                    'input' => 'datetime',
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                )
            )
            ->add('acquisExperiencePro', null, [
                                'attr' => ['maxlength' => '4096'],
                                'required' => false, ])
            ->add('capaciteOrganiserAnimer', null, [
                                'attr' => ['maxlength' => '4096'],
                                'required' => false, ])
            ->add('capaciteDefinirObjectifs', null, [
                                'attr' => ['maxlength' => '4096'],
                                'required' => false, ])
            ->add('souhaitEvolutionCarriere', null, ['required' => false])
            ->add('typeEvolutionCarriere', null, [
                                'attr' => ['maxlength' => '4096'],
                                'required' => false, ])
            ->add('souhaitMobilite', null, ['required' => false])
            ->add('typeMobilite', null, [
                                'attr' => ['maxlength' => '4096'],
                                'required' => false, ])
            ->add('objectifsFuturs',
                CollectionType::class,
                [
                    'entry_type' => ObjectifFuturType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                ]
            )
            ->add('souhaitEntretienCarriere', null, ['required' => false])
            ->add(
                'typeEntretienCarriere',
                ChoiceType::class,
                [
                    'choices' => [
                        'avec son bureau des ressources humaines' => 0,
                        'avec son bureau gestionnaire (Direction des ressources humaines - SDRH 2)' => 1,
                        'avec la mission de suivi personnalisé et des parcours professionnels (MS3P) de la DRH' => 2,
                    ],
                    'expanded' => true,
                    'multiple' => false,
                ]
            )
            ->add('coordonneesEntretien', null, [
                                'attr' => ['maxlength' => '4096'],
                                'required' => false, ])
            ->add('autresBesoinsFormation', null, [
                                'attr' => ['maxlength' => '4096'],
                                'required' => false, ])
            ->add('autresPointsAbordesShd', null, [
                                'attr' => ['maxlength' => '4096'],
                                'required' => false, ])
            ->add('autresPointsAbordesAgent', null, [
                                'attr' => ['maxlength' => '4096'],
                                'required' => false, ])
            ->add('appreciationLitteraleShd', null, [
                                'attr' => ['maxlength' => '4096'],
                                'required' => false, ])
            ->add(
                'competencesTransverses',
                    CollectionType::class,
                    [
                        'label' => false,
                        'entry_type' => CrepMinefContractCompetenceTransverseType::class,
                    ]
            )
            ->add('qualiteShd', null, ['required' => false])
            ->add(
                'typeCadenceAvancement',
                ChoiceType::class,
                [
                    'choices' => [
                        'Acceleration 1 mois' => 0,
                        'Acceleration 2 mois' => 1,
                        'Acceleration 3 mois' => 2,
                        'Cadence Moyenne' => 3,
                        "Mention d'alerte" => 4,
                        'Ralentissement 1 mois' => 5,
                        'Ralentissement 2 mois' => 6,
                        'Ralentissement 3 mois' => 7,
                        ],
                    'expanded' => true,
                    'multiple' => false,
                ]
            )
            ->add('revisionGracieuse', null, ['required' => false])
            ->add(
                'dateCommunicationReponse',
                    DateType::class,
                    array(
                        'label' => false,
                        'widget' => 'single_text',
                        'input' => 'datetime',
                        'format' => 'dd/MM/yyyy',
                        'required' => false,
                    )
            )

            ->add('commentaireAgentFormation', null, [
                'attr' => ['maxlength' => '4096'],
                'required' => false,
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepMinefContract\CrepMinefContract',
            'echelleObjectifEvalue' => null,
            'echelleNiveauSame' => null,
            'selectTypologieFormation' => null,
            'ministere' => null,
        ));
    }
}
