<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Repository\FormationRepository;

class FormationDispenseeType extends AbstractType
{
    private $ministere;

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->ministere = $options['ministere'];

        $builder
            ->add('date', DateType::class, array(
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
            ))
            ->add('formation', EntityType::class, array(
                'class' => 'AppBundle:Formation',
                'query_builder' => function (FormationRepository $er) {
                    return $er->getFormationsValides($this->ministere);
                },
                'choice_label' => function ($formation) {
                    return $formation->getLibelle().' ('.$formation->getCode().')';
                },
                'required' => false,
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\FormationDispensee',
            'ministere' => null,
        ));
    }
}
