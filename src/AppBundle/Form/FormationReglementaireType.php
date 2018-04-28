<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class FormationReglementaireType extends AbstractType
{
    private $ministere;

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->ministere = $options['ministere'];

        $echelleNiveauSame = $options['echelleNiveauSame'];

        $builder->add('priorite', ChoiceType::class, array(
            'choices' => [
                '1' => 1,
                '2' => 2,
                '3' => 3,
            ],
            'attr' => ['class' => 'fieldCollection'],
        ))
            ->add('libelle', null, [
                    'attr' => ['class' => 'fieldCollection'], ])

            ->add('niveauSame', ChoiceType::class, [
                    'choices' => $echelleNiveauSame,
                    'expanded' => false,
                    'multiple' => false,
                    'attr' => ['class' => 'fieldCollection'],
                ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\FormationReglementaire',
            'ministere' => null,
            'echelleNiveauSame' => null,
        ));
    }
}
