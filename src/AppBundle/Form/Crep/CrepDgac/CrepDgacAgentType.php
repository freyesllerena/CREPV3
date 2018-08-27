<?php

namespace AppBundle\Form\Crep\CrepDgac;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use AppBundle\Form\Crep\CrepType;

class CrepDgacAgentType extends CrepType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	parent::buildForm($builder, $options);
    	
        $builder
            ->add('elementsObservesAgent', null, ['attr' => ['maxlength' => '4096'], 'required' => false, ])
            ->add('obsAgentObjectifsEvalues', null, ['required' => false])
            ->add('autresObservationsAgent', null, ['required' => false])
            ->add('commentaireResultatsAgent', null, ['required' => false])

        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepDgac\CrepDgac',
        ));
    }
}
