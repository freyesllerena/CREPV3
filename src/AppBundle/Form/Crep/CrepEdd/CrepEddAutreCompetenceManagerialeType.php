<?php

namespace AppBundle\Form\Crep\CrepEdd;

use AppBundle\Form\CompetencePosteType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CrepEddAutreCompetenceManagerialeType extends CompetencePosteType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('libelle', null, [
                            'attr' => ['class' => 'fieldCollection',
                                        'maxlength' => '4096', ],
                            'required' => false,
                        ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepEdd\CrepEddAutreCompetenceManageriale',
        ));
    }
}
