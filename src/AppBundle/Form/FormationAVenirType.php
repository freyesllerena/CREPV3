<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Repository\FormationRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class FormationAVenirType extends AbstractType
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
            ->add('besoinAvere')
            ->add('libelle')
//             ->add('formation', EntityType::class,
//                    array(
//                         'class' => 'AppBundle:Formation',
//                         'query_builder' => function (FormationRepository $er) {
//                                                 return $er->getFormationsValides($this->ministere);
//                                             },
//                         'choice_label' => function ($formation) {
//                                                 return $formation->getLibelle() . ' (' . $formation->getCode() . ')';
//                                             },
//                         'required' => false
//         ))
        ->add('besoinToujoursAvere')
        ->add('origine', ChoiceType::class, [
                'choices' => [
                        "Demande de l'agent-e" => 0,
                        'Avis du-de la responsable hiérarchique' => 1,
                        'Demande au regard des objectifs du service' => 2,
                ],
                'expanded' => true,
                'multiple' => false,
                'attr' => ['class' => 'fieldCollection'],
        ])
        ->add('cpf')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\FormationAVenir',
            'ministere' => null,
        ));
    }
}
