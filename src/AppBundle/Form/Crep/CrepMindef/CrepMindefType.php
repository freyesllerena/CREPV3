<?php

namespace AppBundle\Form\Crep\CrepMindef;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use AppBundle\Form\Crep\CrepType;
use AppBundle\Entity\Crep\CrepMindef\CrepMindef;
use AppBundle\Form\MotivationsMobiliteType;

class CrepMindefType extends CrepType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* @var $crep CrepMindef */
        $crep = $builder->getData();

        $options['echelleObjectifEvalue'] = $crep::$echelleObjectifEvalue;
        $options['echelleNiveauSame'] = $crep::$echelleNiveauSame;
        $options['selectTypologieFormation'] = $crep::$selectTypologieFormation;
        $options['ministere'] = $crep->getAgent()->getCampagnePnc()->getMinistere();

        parent::buildForm($builder, $options);

        $builder
            ->add('matriculeAlliance')
            ->add('nomNaissance', null, ['required' => false])
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
                    )
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
            ->add('grade', null, ['required' => false])
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
            ->add('echelon', null, ['required' => false])
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
            ->add('gradeEmploi', null, ['required' => false])
            ->add(
                'dateEntreeGradeEmploi',
                DateType::class,
                array(
                    'label' => false,
                    'widget' => 'single_text',
                    'input' => 'datetime',
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                    )
                )
            ->add('etablissement', null, ['required' => false])
            ->add('departement', null, ['required' => false])
            ->add('codePosteAlliance', null, ['required' => false])
            ->add('codePosteCredo', null, ['required' => false])
            ->add('nomNaissanceShd', null, ['required' => false])
            ->add('nomUsageShd')
            ->add('prenomShd')
            ->add('corpsShd', null, ['required' => false])
            ->add('gradeShd', null, ['required' => false])
            ->add('etablissementShd', null, ['required' => false])
            ->add('affectationAgent', null, ['required' => false])
            ->add('affectationShd', null, ['required' => false])
            ->add('posteOccupeAgent', null, ['required' => false])
            ->add(
                'dateEntreePosteOccupeAgent',
                DateType::class,
                array(
                    'label' => false,
                    'widget' => 'single_text',
                    'input' => 'datetime',
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                )
            )

            ->add('posteOccupeShd', null, ['required' => false])
            ->add('cadreMiseEnOeuvreObjectifs', null, ['required' => false])
            ->add(
                'fichePoseAJour',
                ChoiceType::class,
                [
                    'choices' => [
                        'Oui' => true,
                        'Non' => false,
                    ],
                    'expanded' => true,
                    'multiple' => false,
                ]
            )
            ->add('autresActivites')
            ->add('resultatAutresActivites')
            ->add('nbAgentsEncadresA', TextType::class)
            ->add('nbAgentsEncadresB', TextType::class)
            ->add('nbAgentsEncadresC', TextType::class)
            ->add('autresFonctionsManageriales')
            ->add('contexteObjectifsAnneeEnCours')
            ->add('souhaitEntretienCarriere')
            ->add('observationsShdProjetProfessionnel')
            ->add('observationsAgentObjectifsFuturs')
            ->add('observationsAgentProjetProfessionnel')
            ->add('capitalDif', TextType::class)
            ->add('capitalDifMobilisable', TextType::class)
            ->add('motivationsMobilite', MotivationsMobiliteType::class)
            ->add(
                'evaluationGlobale',
                ChoiceType::class,
                [
                    'choices' => [
                        'Insuffisants' => 0,
                        'Partiels' => 1,
                        'Conformes' => 2,
                        'Dépassés' => 3,
                    ],
                    'expanded' => true,
                    'multiple' => false,
                ]
            )
            ->add('aptitudesExercerFonctionsSupperieures')
            ->add('appreciationLitteraleShd')
            ->add(
                'competencesManageriales',
                CollectionType::class,
                [
                    'label' => false,
                    'entry_type' => CrepMindefCompetenceManagerialeType::class,
//                     'allow_add' => true,
//                     'allow_delete' => true,
//                     'by_reference' => false,
                ]
            )
            ->add(
                'competencesTransverses',
                CollectionType::class,
                [
                    'label' => false,
                    'entry_type' => CrepMindefCompetenceTransverseType::class,
//                     'allow_add' => true,
//                     'allow_delete' => true,
//                     'by_reference' => false,
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
            'data_class' => 'AppBundle\Entity\Crep\CrepMindef\CrepMindef',
//             'echelleObjectifEvalue' => null,
//             'ministere'=> null,
//         	'echelleNiveauSame' => null,
//         	'selectTypologieFormation' => null,
        ));
    }
}
