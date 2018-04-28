<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Repository\FormationRepository;

class FormationDemandeeAdministrationType extends AbstractType
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

        $selectTypologieFormation = $options['selectTypologieFormation'];

        $builder->add('priorite', ChoiceType::class, array(
            'choices' => [
                '1' => 1,
                '2' => 2,
                '3' => 3,
            ],
               'attr' => ['class' => 'fieldCollection'],
        ))
            ->add('lienAvecObjectifs', null, [
                  'attr' => ['class' => 'fieldCollection'], ])

            ->add('libelle', null, [
                    'attr' => ['class' => 'fieldCollection'], ])

//             ->add('typologie')
            ->add('code', null, [
                    'attr' => ['class' => 'fieldCollection'], ])

            ->add('niveauSame', ChoiceType::class, [
                    'choices' => $echelleNiveauSame,
                    'expanded' => false,
                    'multiple' => false,
                    'attr' => ['class' => 'fieldCollection'],
                ])

            ->add('typologie', ChoiceType::class, [
                'choices' => $selectTypologieFormation,
                'expanded' => false,
                'multiple' => false,
                'attr' => ['class' => 'fieldCollection'],
            ])
        ;
//             ->add('formation', EntityType::class, array(
//             'class' => 'AppBundle:Formation',
//             'query_builder' => function (FormationRepository $er) {
//                 return $er->getFormationsValides($this->ministere);
//             },
//             'choice_label' => function ($formation) {
//                 return $formation->getLibelle() . ' (' . $formation->getCode() . ')';
//             },
//             'required' => false
//         ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\FormationDemandeeAdministration',
            'ministere' => null,
            'echelleNiveauSame' => null,
            'selectTypologieFormation' => null,
        ));
    }
}
