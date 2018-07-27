<?php

namespace AppBundle\Form\Crep\CrepScl;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use AppBundle\Form\Crep\CrepType;
use AppBundle\Entity\Crep\CrepScl\CrepScl;

class CrepSclType extends CrepType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* @var $crep CrepScl */
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
                    'label' => false,
                    'widget' => 'single_text',
                    'input' => 'datetime',
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                    )
                )
            ->add('grade', null, ['required' => false])
            ->add('echelon', null, ['required' => false])
            ->add('directionAffectation', null, [
                                'attr' => ['maxlength' => '4096'],
                                'required' => false, ])
            ->add('rang', null, ['required' => false])
            ->add('echelonTerminal', null, ['required' => false])

            ->add('motifRefusEntretien', null, [
                                'attr' => ['maxlength' => '4096'],
                                'required' => false, ])
            ->add('descriptionFonctions', null, [
                                'attr' => ['maxlength' => '4096'],
                                'required' => false, ])
            ->add('acquisExperiencePro', null, [
                                'attr' => ['maxlength' => '4096'],
                                'required' => false, ])
            ->add('typeEvolutionCarriere', null, [
                                'attr' => ['maxlength' => '4096'],
                                'required' => false, ])
            ->add('typeMobilite', null, [
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
                        'entry_type' => CrepSclCompetenceTransverseType::class,
                    ]
            )
            ->add(
                'typeCadenceAvancement',
                ChoiceType::class,
                [
                    'choices' => [
                        'Acceleration 1 mois' => 0,
                        'Acceleration 2 mois' => 1,
                        'Acceleration 3 mois' => 2,
                        'Cadence Moyenne' => 3,
                        'Ralentissement 1 mois' => 4,
                        'Ralentissement 2 mois' => 5,
                        'Ralentissement 3 mois' => 6,
                        ],
                    'expanded' => true,
                    'multiple' => false,
                ]
            )
            ->add('mentionAlerte', null, [
                                'attr' => ['maxlength' => '4096'],
                                'required' => false, ])
            ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepScl\CrepScl',
            'echelleObjectifEvalue' => null,
            'echelleNiveauSame' => null,
            'ministere' => null,
            'selectTypologieFormation' => null,
        ));
    }
}
