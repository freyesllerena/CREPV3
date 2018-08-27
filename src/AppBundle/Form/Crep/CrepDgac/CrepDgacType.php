<?php

namespace AppBundle\Form\Crep\CrepDgac;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use AppBundle\Form\Crep\CrepType;

class CrepDgacType extends CrepType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* @var $crep CrepDgac */
        $crep = $builder->getData();
        $options['ministere'] = $crep->getAgent()->getCampagnePnc()->getMinistere();

        parent::buildForm($builder, $options);

        $builder
            ->add('nomUsage')
            ->add('prenom')
            ->add('grade', null, ['required' => false])
            ->add('corps', null, ['required' => false])
            ->add('matricule', null, ['required' => false])
            ->add('service', null, ['required' => false])
            ->add('posteOccupe', null, ['required' => false])
            ->add('nomUsageShd')
            ->add('prenomShd')
            ->add('fonctionExerceeShd', null, ['required' => false])
            ->add('contexteAnneeEcoulee', null, ['required' => false])
            ->add('descriptionPosteMission', null, ['required' => false])
            ->add('elementsObservesShd', null, ['required' => false])
            ->add('elementsObservesAgent', null, ['required' => false])
            ->add(
            		'composantesPostes',
            		CollectionType::class,
            		[
            				'label' => false,
            				'entry_type' => CrepDgacComposantePosteType::class,
            				'allow_add' => false,
            				'allow_delete' => false,
            				'by_reference' => false,
            		]
            )
            ->add(
            		'autresComposantesPostes',
            		CollectionType::class,
            		[
            				'label' => false,
            				'entry_type' => CrepDgacAutreComposantePosteType::class,
            				'allow_add' => true,
                            'allow_delete' => true,
                            'by_reference' => false,
            		]
            )
            ->add(
            		'competencesProfessionnelles',
            		CollectionType::class,
            		[
            				'label' => false,
            				'entry_type' => CrepDgacCompetenceProfessionnelleType::class,
            				'allow_add' => true,
            				'allow_delete' => true,
            				'by_reference' => false,
            		]
            ) 
            ->add(
            		'autresCompetencesProfessionnelles',
            		CollectionType::class,
            		[
            				'label' => false,
            				'entry_type' => CrepDgacAutreCompetenceProfessionnelleType::class,
            				'allow_add' => true,
            				'allow_delete' => true,
            				'by_reference' => false,
            		]
            )
            ->add(
            		'competencesManageriales',
            		CollectionType::class,
            		[
            				'label' => false,
            				'entry_type' => CrepDgacCompetenceManagerialeType::class,
            				'allow_add' => true,
            				'allow_delete' => true,
            				'by_reference' => false,
            		]
            )
            ->add(
            		'autresCompetencesManageriales',
            		CollectionType::class,
            		[
            				'label' => false,
            				'entry_type' => CrepDgacAutreCompetenceManagerialeType::class,
            				'allow_add' => true,
            				'allow_delete' => true,
            				'by_reference' => false,
            		]
            )            
            ->add(
            		'competencesSyntheses',
            		CollectionType::class,
            		[
            				'label' => false,
            				'entry_type' => CrepDgacCompetenceSyntheseType::class,
            				'allow_add' => true,
            				'allow_delete' => true,
            				'by_reference' => false,
            		]
            ) 
            ->add(
            		'autresCompetencesSyntheses',
            		CollectionType::class,
            		[
            				'label' => false,
            				'entry_type' => CrepDgacAutreCompetenceSyntheseType::class,
            				'allow_add' => true,
            				'allow_delete' => true,
            				'by_reference' => false,
            		]
            )
            ->add('contextePrevisibleAnnee', null, ['required' => false])
            ->add('elementsPermanents', null, ['required' => false])
            ->add('elementsParticuliers', null, ['required' => false])
            ->add('resultatsObtenusParAgent', null, ['required' => false])
            ->add('resultatAutresActivites', null, ['required' => false])
            ->add('obsShdObjectifsEvalues', null, ['required' => false])
             ->add('obsAgentObjectifsEvalues', null, ['required' => false])
             ->add('autresObservationsAgent', null, ['required' => false])
             ->add('commentaireResultatsAgent', null, ['required' => false])
            ->add('obsCompetencesRequises', null, ['required' => false])
            ->add('elementsObsCompShd', null, ['required' => false])
            ->add('elementsObsCompAgent', null, ['required' => false])
            ->add('appreciationGenerale', null, ['required' => false])
            ->add('observationShdEvolution', null, ['required' => false])
            ->add('typeEvolutionCarriere', null, ['required' => false])
            ->add('mobilite', null, ['required' => false])
            ->add('priseDeResponsabilites', null, ['required' => false])
            ->add('observationsNotifAgent', null, ['required' => false])
            ->add('contributionsCompPrevues', null, ['required' => false])
            ->add('objectifsPermanentsAvenir', null, ['required' => false])
            ->add('objectifsParticuliersAvenir', null, ['required' => false])
            ->add(
            		'formationsSuivies',
            		CollectionType::class,
            		[
            				'label' => false,
            				'entry_type' => CrepDgacFormationSuivieType::class,
            				'allow_add' => true,
            				'allow_delete' => true,
            				'by_reference' => false,
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
            'data_class' => 'AppBundle\Entity\Crep\CrepDgac\CrepDgac',
            'echelleObjectifEvalue' => null,
            'echelleNiveauSame' => null,
            'ministere' => null,
            'selectTypologieFormation' => null,
        ));
    }
}
