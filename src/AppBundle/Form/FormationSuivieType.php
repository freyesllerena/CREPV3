<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class FormationSuivieType extends AbstractType
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

        $builder->add('date', DateType::class, array(
            'attr' => ['class' => 'fieldCollection'],
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
        ))
            ->add('annee', ChoiceType::class, [
                'choices' => [
                    $anneeEvaluee => $anneeEvaluee,
                    $anneeEvaluee - 1 => $anneeEvaluee - 1,
                    $anneeEvaluee - 2 => $anneeEvaluee - 2,
                ],
                'expanded' => false,
                'multiple' => false,
                'attr' => ['class' => 'fieldCollection'],
                'placeholder' => ''
            ])
            ->add('type', null, ['attr' => ['class' => 'fieldCollection']])
            ->add('duree', null, ['attr' => ['class' => 'fieldCollection']])
            ->add('libelle', null, ['attr' => ['class' => 'fieldCollection']])
            ->add('commentaires', TextareaType::class, [
                    'attr' => ['maxlength' => '4096',
                                'class' => 'fieldCollection', ],
                    'required' => false, ])
                ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\FormationSuivie',
            'ministere' => null,
            'anneeEvaluation' => null,
        ));
    }
}
