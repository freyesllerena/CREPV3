<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
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

        $builder->add('date', DateType::class, array(
            'attr' => ['class' => 'fieldCollection'],
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
        ))
            ->add('annee', null, ['attr' => ['class' => 'fieldCollection']])
            ->add('type', null, ['attr' => ['class' => 'fieldCollection']])
            ->add('libelle', null, ['attr' => ['maxlength' => '200', 'class' => 'fieldCollection'] ])
            ->add('commentaires', null, ['attr' => ['maxlength' => '200', 'class' => 'fieldCollection', ],'required' => false, ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\FormationSuivie',
            'ministere' => null,
        ));
    }
}
