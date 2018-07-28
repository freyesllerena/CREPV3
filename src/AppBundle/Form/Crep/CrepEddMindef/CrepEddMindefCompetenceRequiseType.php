<?php

namespace AppBundle\Form\Crep\CrepEddMindef;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use AppBundle\Entity\Crep\CrepEddMindef\CrepEddMindef;

class CrepEddMindefCompetenceRequiseType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle', TextareaType::class, [
                'attr' => ['maxlength' => '4096'],
                'required' => false
            ])
            ->add('niveauAcquis', ChoiceType::class, [
                'choices' => CrepEddMindef::$niveauCompetence,
                'expanded' => true,
                'multiple' => false,
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepEddMindef\CrepEddMindefCompetenceRequise',
        ));
    }
}
