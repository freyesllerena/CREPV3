<?php

namespace AppBundle\Form\Crep\CrepMcc02\Formations;


use AppBundle\Form\FormationSuivieType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CrepMcc02FormationSuivieType extends FormationSuivieType
{
    private $ministere;

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->ministere = $options['ministere'];

        parent::buildForm($builder, $options);

        $anneeEvaluee = $options['anneeEvaluation'];

        $builder->add('annee', ChoiceType::class, [
                'choices' => [
                    $anneeEvaluee - 1 => $anneeEvaluee - 1,
                    $anneeEvaluee - 2 => $anneeEvaluee - 2,
                ],
                'expanded' => false,
                'multiple' => false,
                'attr' => ['class' => 'fieldCollection', 'style' => 'min-width: 80px;'],
                'placeholder' => ''
            ])
            ->add('duree', null, ['attr' => ['class' => 'fieldCollection']])
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
            'anneeEvaluation' => null,
            'ministere' => null,
        ));
    }
}