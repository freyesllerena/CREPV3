<?php

namespace AppBundle\Form\Crep\CrepMcc;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use AppBundle\Form\Crep\CrepType;
use AppBundle\Form\Crep\CrepMcc\Competences\CrepMccCritereAppreciationType;
use AppBundle\Form\Crep\CrepMcc\Competences\CrepMccRespEncadrementType;
use AppBundle\Form\Crep\CrepMcc\Formations\CrepMccFormationAdapatationPosteType;
use AppBundle\Form\Crep\CrepMcc\Formations\CrepMccFormationMetierType;
use AppBundle\Form\Crep\CrepMcc\Formations\CrepMccFormationDevQualifType;
use AppBundle\Form\Crep\CrepMcc\Formations\CrepMccFormationPrepaConcoursType;
use AppBundle\Form\Crep\CrepMcc\Formations\CrepMccFormationAutresActionsType;
use AppBundle\Entity\Crep\CrepMcc\CrepMcc;

class CrepMccType extends CrepType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* @var $crep CrepMcc */
        $crep = $builder->getData();

        $options['echelleObjectifEvalue'] = $crep::$echelleObjectifEvalue;
        $options['ministere'] = $crep->getAgent()->getCampagnePnc()->getMinistere();

        parent::buildForm($builder, $options);

        $builder
        ->add('nomPatronymique')
        ->add('affectation')
        ->add('nomUsage')
        ->add('direction')
        ->add('prenom')
        ->add('service')
        ->add('bureau')
        ->add(
            'titulaire',
            ChoiceType::class,
            [
                    'choices' => [
                        'Oui' => 1,
                        'Non' => 0,
                        ],
                    'expanded' => true,
                    'multiple' => false,
                 ]
             )
        ->add('corps')
        ->add(
            'dateEntreeCorps',
                DateType::class,
                array(
                    'label' => false,
                    'widget' => 'single_text',
                    'input' => 'datetime',
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                    )
            )
        ->add('grade')
        ->add(
            'dateEntreeGrade',
                DateType::class,
                array(
                    'label' => false,
                    'widget' => 'single_text',
                    'input' => 'datetime',
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                    )
            )
        ->add('echelon')
        ->add(
            'dateEntreeEchelon',
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
        ->add('contrat', ChoiceType::class, [
                    'choices' => [
                        'CDD' => 0,
                        'CDI' => 1,
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
        ->add('intitulePoste')
        ->add('groupeRifseep')
        ->add('descriptionPosteMission', null, ['attr' => ['maxlength' => '4096'], 'required' => false])
        ->add(
            'dateEntreePoste',
                DateType::class,
                array(
                    'label' => false,
                    'widget' => 'single_text',
                    'input' => 'datetime',
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                    )
                )
        ->add('observationsObjectifsPasses', null, ['attr' => ['maxlength' => '4096'], 'required' => false])

        ->add(
            'criteresAppreciations',
                CollectionType::class,
                [
                        'label' => false,
                        'entry_type' => CrepMccCritereAppreciationType::class,
                ]
        )
        ->add(
            'responsabilitesEncadrements',
                CollectionType::class,
                [
                        'label' => false,
                        'entry_type' => CrepMccRespEncadrementType::class,
                ]
        )

        ->add('nbAgentsEncadres', TextType::class)
        ->add('nbAgentsAEvaluer', TextType::class)
        ->add('nbAgentsEvaluesAnneePrec', TextType::class)
        ->add('avisCriteresAppreciations', null, ['attr' => ['maxlength' => '4096'], 'required' => false])
        ->add('appreciationsManiereServir', null, ['attr' => ['maxlength' => '4096'], 'required' => false])
        ->add('acquisExperiencePro', null, ['attr' => ['maxlength' => '4096'], 'required' => false])
        ->add('actionsFormationFormateur', null, ['attr' => ['maxlength' => '4096'], 'required' => false])
        ->add('objectifsCollectifsService', null, ['attr' => ['maxlength' => '4096'], 'required' => false])
        ->add('contextePrevisibleAnnee', null, ['attr' => ['maxlength' => '4096'], 'required' => false])
        ->add('evolutionPosteActuel', null, ['attr' => ['maxlength' => '4096'], 'required' => false])
        ->add('mobilite', null, ['attr' => ['maxlength' => '4096'], 'required' => false])
        ->add(
            'formationsAdaptationPosteTravail',
            CollectionType::class,
                [
                        'entry_type' => CrepMccFormationAdapatationPosteType::class,
                        'allow_add' => true,
                        'allow_delete' => true,
                        'by_reference' => false,
                ]
        )
        ->add(
            'formationsEvolutionMetiers',
            CollectionType::class,
                [
                        'entry_type' => CrepMccFormationMetierType::class,
                        'allow_add' => true,
                        'allow_delete' => true,
                        'by_reference' => false,
                ]
        )
        ->add(
            'formationsDevQualifs',
            CollectionType::class,
                [
                        'entry_type' => CrepMccFormationDevQualifType::class,
                        'allow_add' => true,
                        'allow_delete' => true,
                        'by_reference' => false,
                ]
        )
        ->add(
            'formationsPrepaConcoursExamens',
            CollectionType::class,
                [
                        'entry_type' => CrepMccFormationPrepaConcoursType::class,
                        'allow_add' => true,
                        'allow_delete' => true,
                        'by_reference' => false,
                ]
        )
        ->add(
            'formationsAutresActions',
            CollectionType::class,
                [
                        'entry_type' => CrepMccFormationAutresActionsType::class,
                        'allow_add' => true,
                        'allow_delete' => true,
                        'by_reference' => false,
                ]
        )
        ->add('dureeEntretien', null, ['attr' => ['maxlength' => '30'], 'required' => false])
        ->add('qualiteShd', null, ['required' => false])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepMcc\CrepMcc',
            'echelleObjectifEvalue' => null,
            'echelleNiveauSame' => null,
            'selectTypologieFormation' => null,
            'ministere' => null,
        ));
    }
}
