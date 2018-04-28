<?php

namespace AppBundle\Form\Crep\CrepAc;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use AppBundle\Form\Crep\CrepType;

class CrepAcAgentType extends CrepType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('commentaireAgentFonction', null, [
                                'attr' => ['maxlength' => '4096'],
                                'required' => false, ])
            ->add(
                'competencesTransversesDetenues',
                CollectionType::class,
                                [
                                    'label' => false,
                                    'entry_type' => CrepAcCompetenceTransverseDetenueType::class,
                                    'allow_add' => true,
                                    'allow_delete' => true,
                                    'by_reference' => false,
                                ]
            )
            ->add('commAgentEvolution', null, [
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
            'data_class' => 'AppBundle\Entity\Crep\CrepAc\CrepAc',
        ));
    }
}
