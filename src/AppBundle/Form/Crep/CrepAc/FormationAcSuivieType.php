<?php

namespace AppBundle\Form\Crep\CrepAc;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class FormationAcSuivieType extends AbstractType
{
    private $ministere;

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->ministere = $options['ministere'];

        $anneeEvaluee = $options['anneeEvaluation'];

        $builder
            ->add('annee', ChoiceType::class, [
                            'choices' => [
                                '' => null,
                                $anneeEvaluee => $anneeEvaluee,
                                $anneeEvaluee - 1 => $anneeEvaluee - 1,
                                $anneeEvaluee - 2 => $anneeEvaluee - 2,
                            ],
                            'expanded' => false,
                            'multiple' => false,
                            'attr' => ['class' => 'fieldCollection'],
                        ])

            ->add('libelle', null, [
                            'attr' => ['class' => 'fieldCollection',
                                        'maxlength' => '4096', ],
                            'required' => false,
                        ])
            ->add('duree', null, [
                            'attr' => ['class' => 'fieldCollection',
                                        'maxlength' => '256', ],
                            'required' => false,
                        ])
            ->add('commentaires', null, [
                            'attr' => ['class' => 'fieldCollection',
                                        'maxlength' => '4096', ],
                            'required' => false,
                        ])
            ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepAc\FormationAcSuivie',
            'ministere' => null,
            'anneeEvaluation' => null,
        ));
    }
}
