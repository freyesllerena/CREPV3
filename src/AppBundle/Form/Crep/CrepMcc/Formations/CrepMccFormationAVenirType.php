<?php

namespace AppBundle\Form\Crep\CrepMcc\Formations;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CrepMccFormationAVenirType extends AbstractType
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
            ->add('besoinAvere', null, ['attr' => ['class' => 'fieldCollection']])
            ->add('libelle', null, ['attr' => ['class' => 'fieldCollection']])
            ->add('besoinToujoursAvere', null, ['attr' => ['class' => 'fieldCollection']])
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
            ->add('cpf', null, ['attr' => ['class' => 'fieldCollection']])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepMcc\CrepMccFormationAVenir',
            'ministere' => null,
        ));
    }
}
