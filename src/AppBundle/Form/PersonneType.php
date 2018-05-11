<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\EnumTypes\EnumCivilite;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PersonneType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $typeAction = $options['typeAction'];

        if ('editBrhp' == $typeAction) {
            $disabled = true;
        } else {
            $disabled = false;
        }

        $builder

            ->add('civilite', ChoiceType::class, ['choices' => ['M.' => EnumCivilite::MONSIEUR,
                    'Mme' => EnumCivilite::MADAME, ],
                    'expanded' => false,
                    'multiple' => false,
                                                'choices_as_values' => true,
            ])
            ->add('nom', null)
            ->add('prenom', null)
            ->add('email', null, ['disabled' => $disabled])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Personne',
            'typeAction' => null,
        ));
    }
}
