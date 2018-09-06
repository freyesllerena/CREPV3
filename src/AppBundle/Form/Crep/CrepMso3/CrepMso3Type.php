<?php

namespace AppBundle\Form\Crep\CrepMso3;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use AppBundle\Form\Crep\CrepMso3\Competences\CrepMso3CompetenceRequiseType;
use AppBundle\Form\Crep\CrepMso3\Competences\CrepMso3SavoirFairePosteType;
use AppBundle\Form\Crep\CrepMso3\Competences\CrepMso3SavoirFairePosteAutreType;
use AppBundle\Form\Crep\CrepMso3\Competences\CrepMso3QualiteRelationnellePosteType;
use AppBundle\Form\Crep\CrepMso3\Competences\CrepMso3QualiteRelationnellePosteAutreType;
use AppBundle\Form\Crep\CrepMso3\Competences\CrepMso3CompetenceMiseEnOeuvreType;
use AppBundle\Form\Crep\CrepMso3\Competences\CrepMso3SavoirFaireAgentType;
use AppBundle\Form\Crep\CrepMso3\Competences\CrepMso3SavoirFaireAgentAutreType;
use AppBundle\Form\Crep\CrepMso3\Competences\CrepMso3QualiteRelationnelleAgentType;
use AppBundle\Form\Crep\CrepMso3\Competences\CrepMso3QualiteRelationnelleAgentAutreType;
use AppBundle\Form\Crep\CrepMso3\Competences\CrepMso3AptitudeManagementType;
use AppBundle\Entity\Crep\CrepMso3\CrepMso3;
use AppBundle\Form\Crep\CrepMso3\Formations\CrepMso3FormationN1Type;
use AppBundle\Form\Crep\CrepMso3\Formations\CrepMso3FormationN2Type;
use AppBundle\Form\Crep\CrepMso3\Formations\CrepMso3FormationT1Type;
use AppBundle\Form\Crep\CrepMso3\Formations\CrepMso3FormationT3Type;
use AppBundle\Form\Crep\CrepMso3\Formations\CrepMso3FormationT2Type;
use AppBundle\Form\Crep\CrepMso3\Formations\CrepMso3FormationT3FormationPreparationConcoursType;
use AppBundle\Form\Crep\CrepMso3\Formations\CrepMso3FormationAutreType;
use AppBundle\Form\Crep\CrepMso3\Competences\CrepMso3CompetenceManiereServirAgentType;
use AppBundle\Form\Crep\CrepType;

class CrepMso3Type extends CrepType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* @var $crep CrepMso3 */
        $crep = $builder->getData();
        $options['ministere'] = $crep->getAgent()->getCampagnePnc()->getMinistere();
        $options['echelleObjectifEvalue'] = $crep::$echelleObjectifEvalue;
        $anneeEvaluee = $crep->getAgent()->getCampagnePnc()->getAnneeEvaluee();
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
            ->add('categorie', null, ['required' => false])
            ->add('corps', null, ['required' => false])
            ->add('grade', null, ['required' => false])
            ->add('echelon', null, ['required' => false])
            ->add('affectation', null, ['required' => false])
            ->add('posteOccupe', null, ['required' => false])
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
            ->add('nomUsageShd')
            ->add('prenomShd')
            ->add('categorieShd', null, ['required' => false])
            ->add('corpsShd', null, ['required' => false])
            ->add('gradeShd', null, ['required' => false])
            ->add('fonctionExerceeShd', null, ['required' => false])
            ->add('contexteAnneeEcoulee', null, ['required' => false])
            ->add('natureDossiersTravaux', null, ['required' => false])
            ->add('resultatsObtenusParAgent', null, ['required' => false])
            ->add('contexteResultats', null, ['required' => false])
            ->add('appreciationEvaluateur', null, ['required' => false])
            ->add('elementsParticuliers', null, ['required' => false])
            ->add('objectifsService', null, ['required' => false])
            ->add('contextePrevisibleAnnee', null, ['required' => false])
            ->add(
                'competencesRequises',
                    CollectionType::class,
                    [
                            'entry_type' => CrepMso3CompetenceRequiseType::class,
                            'allow_add' => true,
                            'allow_delete' => true,
                            'by_reference' => false,
                    ]
            )
            ->add(
                'savoirsFairePoste',
                    CollectionType::class,
                    [
                            'entry_type' => CrepMso3SavoirFairePosteType::class,
                            'allow_add' => false,
                            'allow_delete' => false,
                            'by_reference' => false,
                    ]
            )
            ->add(
                'savoirsFairePosteAutres',
                    CollectionType::class,
                    [
                            'entry_type' => CrepMso3SavoirFairePosteAutreType::class,
                            'allow_add' => true,
                            'allow_delete' => true,
                            'by_reference' => false,
                    ]
            )
            ->add(
                'qualitesRelationnellesPoste',
                    CollectionType::class,
                    [
                            'entry_type' => CrepMso3QualiteRelationnellePosteType::class,
                            'allow_add' => false,
                            'allow_delete' => false,
                            'by_reference' => false,
                    ]
            )
            ->add(
                'qualitesRelationnellesPosteAutres',
                    CollectionType::class,
                    [
                            'entry_type' => CrepMso3QualiteRelationnellePosteAutreType::class,
                            'allow_add' => true,
                            'allow_delete' => true,
                            'by_reference' => false,
                    ]
            )
            ->add(
                'competencesMisesEnOeuvre',
                    CollectionType::class,
                    [
                            'entry_type' => CrepMso3CompetenceMiseEnOeuvreType::class,
                            'allow_add' => true,
                            'allow_delete' => true,
                            'by_reference' => false,
                    ]
            )
            ->add(
                'savoirsFaireAgent',
                    CollectionType::class,
                    [
                            'entry_type' => CrepMso3SavoirFaireAgentType::class,
                            'allow_add' => false,
                            'allow_delete' => false,
                            'by_reference' => false,
                    ]
            )
            ->add(
                'savoirsFaireAgentAutres',
                    CollectionType::class,
                    [
                            'entry_type' => CrepMso3SavoirFaireAgentAutreType::class,
                            'allow_add' => true,
                            'allow_delete' => true,
                            'by_reference' => false,
                    ]
            );
        $builder->add(
                'qualitesRelationnellesAgent',
                    CollectionType::class,
                    [
                            'entry_type' => CrepMso3QualiteRelationnelleAgentType::class,
                            'allow_add' => false,
                            'allow_delete' => false,
                            'by_reference' => false,
                    ]
            )
            ->add(
                'qualitesRelationnellesAgentAutres',
                    CollectionType::class,
                    [
                            'entry_type' => CrepMso3QualiteRelationnelleAgentAutreType::class,
                            'allow_add' => true,
                            'allow_delete' => true,
                            'by_reference' => false,
                    ]
            )
            ->add('agentsEncadres', null, ['required' => false])

            ->add(
                'aptitudesManagementAgent',
                    CollectionType::class,
                    [
                            'entry_type' => CrepMso3AptitudeManagementType::class,
                            'allow_add' => false,
                            'allow_delete' => false,
                            'by_reference' => false,
                    ]
            )

            ->add(
                'formationsN1',
                    CollectionType::class,
                    [
                            'entry_type' => CrepMso3FormationN1Type::class,
                            'allow_add' => true,
                            'allow_delete' => true,
                            'by_reference' => false,
                            'entry_options' => ['annee_evaluee' => $anneeEvaluee],
                    ]
            )
            ->add(
                'formationsN2',
                    CollectionType::class,
                    [
                            'entry_type' => CrepMso3FormationN2Type::class,
                            'allow_add' => true,
                            'allow_delete' => true,
                            'by_reference' => false,
                            'entry_options' => ['annee_evaluee' => $anneeEvaluee],
                    ]
            )
            ->add(
                'formationsT1',
                    CollectionType::class,
                    [
                            'entry_type' => CrepMso3FormationT1Type::class,
                            'allow_add' => true,
                            'allow_delete' => true,
                            'by_reference' => false,
                            'entry_options' => ['annee_evaluee' => $anneeEvaluee],
                    ]
            )
            ->add(
                'formationsT2',
                    CollectionType::class,
                    [
                            'entry_type' => CrepMso3FormationT2Type::class,
                            'allow_add' => true,
                            'allow_delete' => true,
                            'by_reference' => false,
                            'entry_options' => ['annee_evaluee' => $anneeEvaluee],
                    ]
            )
            ->add(
                'formationsT3',
                    CollectionType::class,
                    [
                            'entry_type' => CrepMso3FormationT3Type::class,
                            'allow_add' => true,
                            'allow_delete' => true,
                            'by_reference' => false,
                            'entry_options' => ['annee_evaluee' => $anneeEvaluee],
                    ]
            )
            ->add(
                'formationsPreparationConcours',
                    CollectionType::class,
                    [
                            'entry_type' => CrepMso3FormationT3FormationPreparationConcoursType::class,
                            'allow_add' => true,
                            'allow_delete' => true,
                            'by_reference' => false,
                            'entry_options' => ['annee_evaluee' => $anneeEvaluee],
                    ]
            )
            ->add(
                'formationsAutres',
                    CollectionType::class,
                    [
                            'entry_type' => CrepMso3FormationAutreType::class,
                            'allow_add' => true,
                            'allow_delete' => true,
                            'by_reference' => false,
                            'entry_options' => ['annee_evaluee' => $anneeEvaluee],
                    ]
            )
            ->add('evolutionPosteActuel', null, ['required' => false])
            ->add('modificationFicheDePoste', null, ['required' => false])
            ->add('priseDeResponsabilites', null, ['required' => false])
            ->add('projetProfessionnel', null, ['required' => false])
            ->add('souhaitEntretienCarriere', ChoiceType::class, [
                    'choices' => [
                            'Oui' => 1,
                            'Non' => 0,
                    ],
                    'expanded' => true,
                    'multiple' => false,
                    'required' => false,
                    'placeholder' => null,
            ])
            ->add('observationsShdPerspectivesProfessionnelles', null, ['required' => false])
            ->add('avisShdAvancementGrade', null, ['required' => false])
            ->add(
                'competencesManiereServir',
                    CollectionType::class,
                    [
                            'entry_type' => CrepMso3CompetenceManiereServirAgentType::class,
                            'allow_add' => false,
                            'allow_delete' => false,
                            'by_reference' => false,
                    ]
            )
            ->add('aptitudesExercerFonctionsSupperieures', null, ['required' => false])
            ->add('appreciationLitteraleShd', null, ['required' => false])
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
        ));
    }
}
