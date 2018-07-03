<?php

/**
 * Created by PhpStorm.
 * User: freyes-adc
 * Date: 27/06/2018
 * Time: 15:37
 */

namespace AppBundle\Form\Crep\CrepMj02\Competences;


use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Entity\Crep\CrepMj02\CrepMj02;

/**
 * Class CrepMj02CompetenceEncadrementType
 * @package AppBundle\Form\Crep\CrepMj02\Competences
 */
class CrepMj02CompetenceEncadrementType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('niveauAcquis', ChoiceType::class, [
                'choices' => CrepMj02::$niveauCompetence,
                'expanded' => true,
                'multiple' => false,
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepMj02\CrepMj02CompetenceEncadrement',
        ));
    }
}