<?php

namespace AppBundle\Form\Crep\CrepEddMindef;

use AppBundle\Form\CompetencePosteType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class CrepEddMindefCompetenceTransverseDetenueType extends CompetencePosteType
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
                        ])
            ->add('niveauAcquis', ChoiceType::class, [
                'choices' => [
                    'Exceptionnelle' => 0,
                    'Forte' => 1,
                    'Assez forte' => 2,
                    'A développer' => 3,
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
            'data_class' => 'AppBundle\Entity\Crep\CrepEddMindef\CrepEddMindefCompetenceTransverseDetenue',
        ));
    }
}
