<?php

namespace AppBundle\Form\Crep;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use AppBundle\Form\CompetencePosteType;
use AppBundle\Form\CompetenceDeclareeType;
use AppBundle\Form\ObjectifEvalueType;
use AppBundle\Form\ObjectifFuturType;
use AppBundle\Form\FormationSuivieType;
use AppBundle\Form\FormationAVenirType;
use AppBundle\Form\FormationDemandeeAdministrationType;
use AppBundle\Form\FormationReglementaireType;
use AppBundle\Form\FormationDemandeeEmployeurType;
use AppBundle\Form\FormationDemandeeAgentType;
use AppBundle\Form\MobiliteFonctionnelleType;
use AppBundle\Form\MobiliteGeographiqueType;
use AppBundle\Form\MobiliteExterneType;
use AppBundle\Form\EmploiType;

abstract class CrepType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $echelleObjectifEvalue = $options['echelleObjectifEvalue'];
        $echelleNiveauSame = $options['echelleNiveauSame'];
        $selectTypologieFormation = $options['selectTypologieFormation'];
        $ministere = $options['ministere'];

        $builder
            ->add(
                'competencesPostes',
                CollectionType::class,
                [
                    'label' => false,
                    'entry_type' => CompetencePosteType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                ]
            )
            ->add(
                'competencesDeclarees',
                CollectionType::class,
                [
                    'entry_type' => CompetenceDeclareeType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                ]
            )
            ->add(
                'objectifsEvalues',
                CollectionType::class,
                [
                    'entry_type' => ObjectifEvalueType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'entry_options' => ['echelleObjectifEvalue' => $echelleObjectifEvalue],
                ]
            )
            ->add(
                'objectifsFuturs',
                CollectionType::class,
                [
                    'entry_type' => ObjectifFuturType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                ]
            )
            ->add(
                'formationsSuivies',
                CollectionType::class,
                [
                    'entry_type' => FormationSuivieType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'entry_options' => [
                        'ministere' => $ministere,
                    ],
                ]
            )
            ->add(
                'formationsAVenir',
                CollectionType::class,
                [
                    'entry_type' => FormationAVenirType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'entry_options' => [
                        'ministere' => $ministere,
                    ],
                ]
            )
            ->add(
                'formationsDemandeesAdministration',
                CollectionType::class,
                [
                    'entry_type' => FormationDemandeeAdministrationType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'entry_options' => [
                        'ministere' => $ministere,
                        'echelleNiveauSame' => $echelleNiveauSame,
                        'selectTypologieFormation' => $selectTypologieFormation,
                    ],
                ]
            )
            ->add(
                'formationsReglementaires',
                CollectionType::class,
                [
                    'entry_type' => FormationReglementaireType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'entry_options' => [
                        'ministere' => $ministere,
                        'echelleNiveauSame' => $echelleNiveauSame,
                    ],
                ]
            )
            ->add(
                'formationsDemandeesEmployeur',
                CollectionType::class,
                [
                    'entry_type' => FormationDemandeeEmployeurType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'entry_options' => [
                        'ministere' => $ministere,
                    ],
                ]
            )
            ->add(
                'formationsDemandeesAgent',
                CollectionType::class,
                [
                    'entry_type' => FormationDemandeeAgentType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'entry_options' => [
                        'ministere' => $ministere,
                        'echelleNiveauSame' => $echelleNiveauSame,
                        'selectTypologieFormation' => $selectTypologieFormation,
                    ],
                ]
            )

            /* Valable pour le modèle CREPMINDEF et non pas pour CREPMINDEF01*/
            ->add('mobiliteFonctionnelle', MobiliteFonctionnelleType::class)
            ->add('mobiliteGeographique', MobiliteGeographiqueType::class)
            ->add('mobiliteExterne', MobiliteExterneType::class)
            ->add(
                'emplois',
                CollectionType::class,
                [
                    'entry_type' => EmploiType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                ]
            )
            ->add(
                'dateEntretien',
                DateType::class,
                array(
                    'widget' => 'single_text',
                    'input' => 'datetime',
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                )
            )
            ->add('refusEntretienProfessionnel')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep',
            'echelleObjectifEvalue' => null,
            'echelleNiveauSame' => null,
            'selectTypologieFormation' => null,
        ));
    }
}
