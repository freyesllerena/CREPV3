<?php

namespace AppBundle\Form\Crep\CrepMcc;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Form\Crep\CrepType;

class CrepMccAhType extends CrepType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('attributionPartVariable', ChoiceType::class, [
                    'choices' => [
                            'Diminution' => 0,
                            'Maintien' => 1,
                            'Augmentation' => 2,
                    ],
                    'expanded' => true,
                    'multiple' => false,
                    'required' => false,
            ])
            ->add('avisAttributionPartVariable', null, ['attr' => ['maxlength' => '4096'], 'required' => false])
            ->add('avancement', ChoiceType::class, [
                    'choices' => [
                            'Oui' => 1,
                            'Non' => 0,
                    ],
                    'expanded' => true,
                    'multiple' => false,
            ])
            ->add('explicationAvancement', null, ['attr' => ['maxlength' => '4096'], 'required' => false])
            ->add('attributionCia', ChoiceType::class, [
                    'choices' => [
                            'Oui' => 1,
                            'Non' => 0,
                    ],
                    'expanded' => true,
                    'multiple' => false,
            ])
            ->add('explicationAttributionCia', null, ['attr' => ['maxlength' => '4096'], 'required' => false])
            ->add('avancementGrade', ChoiceType::class, [
                    'choices' => [
                            'Oui' => 1,
                            'Non' => 0,
                    ],
                    'expanded' => true,
                    'multiple' => false,
            ])
            ->add('gradeConcerne', null, ['attr' => ['maxlength' => '100'], 'required' => false])
            ->add('avisSurAvancementGrade', ChoiceType::class, [
                    'choices' => [
                            'Trés favorable' => 0,
                            'Favorable' => 1,
                            'Réservé' => 2,
                            'Défavorable' => 3,
                    ],
                    'expanded' => true,
                    'multiple' => false,
                    'required' => false,
            ])
            ->add('explicationAvancementGrade', null, ['attr' => ['maxlength' => '4096'], 'required' => false])
            ->add('avancementCorps', ChoiceType::class, [
                    'choices' => [
                            'Oui' => 1,
                            'Non' => 0,
                    ],
                    'expanded' => true,
                    'multiple' => false,
            ])
            ->add('corpsConcerne', null, ['attr' => ['maxlength' => '100'], 'required' => false])
            ->add('avisSurAvancementCorps', ChoiceType::class, [
                    'choices' => [
                            'Trés favorable' => 0,
                            'Favorable' => 1,
                            'Réservé' => 2,
                            'Défavorable' => 3,
                    ],
                    'expanded' => true,
                    'multiple' => false,
                    'required' => false,
            ])
            ->add('explicationAvancementCorps', null, ['attr' => ['maxlength' => '4096'], 'required' => false])
            ->add('qualiteAh', null, ['required' => false]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepMcc\CrepMcc',
        ));
    }
}
