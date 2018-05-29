<?php

namespace AppBundle\Form\Crep\CrepEdd;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CrepEddCompetenceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle')
            ->add('niveauAcquis', ChoiceType::class, [
                'choices' => [
                    'Exceptionnelle' => 0,
                    'Forte' => 1,
                    'Assez forte' => 2,
                    'A développer' => 3,
                    'Non pertinent' => 4,
                ],
                'expanded' => true,
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
            'data_class' => 'AppBundle\Entity\Competence',
        ));
    }
}
