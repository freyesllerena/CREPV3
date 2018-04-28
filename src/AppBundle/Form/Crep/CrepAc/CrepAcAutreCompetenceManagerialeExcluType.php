<?php

namespace AppBundle\Form\Crep\CrepAc;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CrepAcAutreCompetenceManagerialeExcluType extends CrepAcCompetenceManagerialeType
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
            'data_class' => 'AppBundle\Entity\Crep\CrepAc\CrepAcAutreCompetenceManagerialeExclu',
        ));
    }
}
