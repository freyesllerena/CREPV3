<?php

namespace AppBundle\Form\Crep\CrepScl02;

use AppBundle\Form\Crep\CrepType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use AppBundle\Entity\Crep\CrepScl02\CrepScl02;

class CrepScl02Type extends CrepType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* @var $crep CrepScl02 */
        $crep = $builder->getData();
        $options['ministere'] = $crep->getAgent()->getCampagnePnc()->getMinistere();

        parent::buildForm($builder, $options);
        
        $builder
            ->add('nomUsage')
            ->add('prenom')
            ->add(
                'dateNaissance',
                DateType::class,
                array(
                    'label'     => false,
                    'widget'    => 'single_text',
                    'input'     => 'datetime',
                    'format'    => 'dd/MM/yyyy',
                    'required'  => false,
                    )
                )
            ->add('grade', null, ['required' => false])
            ->add('echelon', null, ['required' => false])
            ->add('directionAffectation', null,
                        [
                            "attr"      => ["maxlength" => "4096"],
                            'required'  => false,
                         ])
            ->add('rang', null, ['required' => false])
            ->add('echelonTerminal', null,
                        [
                            'required' => false
                        ]
            )
            ->add('motifRefusEntretien', null,
                        [
                            "attr"      => ["maxlength" => "4096"],
                            'required'   => false,
                         ]
            )
            ->add('descriptionFonctions', null,
                        [
                            "attr"      => ["maxlength" => "4096"],
                            'required'  => false,
                        ]
            )
            ->add('acquisExperiencePro', null,
                        [
                            "attr"      => ["maxlength" => "4096"],
                            'required'  => false,
                         ]
            )
            ->add('typeEvolutionCarriere', null,
                        [
                            "attr"      => ["maxlength" => "4096"],
                            'required'  => false,
                         ]
            )
            ->add('perspectivesEvolutionFonction', TextareaType::class,
                        [
                            "attr"      => ["maxlength" => "4096"],
                            'required' => false
                        ]
            )
            ->add('typeMobilite', null,
                        [
                            "attr"      => ["maxlength" => "4096"],
                            'required'  => false,
                         ]
            )
            ->add('autresPointsAbordesShd', null,
                        [
                            "attr"      => ["maxlength" => "4096"],
                            'required'  => false,
                         ]
            )
            ->add('autresPointsAbordesAgent', null,
                        [
                            "attr"      => ["maxlength" => "4096"],
                            'required'  => false,
                         ]
            )
            ->add('appreciationLitteraleShd', null,
                        [
                            "attr"      => ["maxlength" => "4096"],
                            'required'  => false,
                         ]
            )
            ->add('competencesTransverses',
                  CollectionType::class,
                   [
                        'label' => false,
                        'entry_type' => CrepScl02CompetenceTransverseType::class,
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
            'data_class' => 'AppBundle\Entity\Crep\CrepScl02\CrepScl02',
            'echelleObjectifEvalue' => null,
            'echelleNiveauSame' => null,
            'ministere'=> null,
            'selectTypologieFormation' => null,
        ));
    }
}