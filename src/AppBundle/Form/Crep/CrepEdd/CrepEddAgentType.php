<?php

namespace AppBundle\Form\Crep\CrepEdd;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Form\Crep\CrepType;

class CrepEddAgentType extends CrepType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('commentaireAgentFonction',null, [
                                'attr' => ['maxlength' => '4096'],
                                'required' => false, ])
            ->add(
                'competencesTransversesDetenues',
                CollectionType::class,
                                [
                                    'label' => false,
                                    'entry_type' => CrepEddCompetenceTransverseDetenueType::class,
                                    'allow_add' => true,
                                    'allow_delete' => true,
                                    'by_reference' => false,
                                ]
            )

            ->add('observationsCompetencesTransversesDetenues', null, [
                'required' => false, ])



            ->add('commentaireAgentEvolution', null, [
                                'attr' => ['maxlength' => '4096'],
                                'required' => false, ])


            ->add('observationsVisaAgent', null, [
                                'attr' => ['maxlength' => '4096'], ])
        ;

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepEdd\CrepEdd',
        ));
    }
}
