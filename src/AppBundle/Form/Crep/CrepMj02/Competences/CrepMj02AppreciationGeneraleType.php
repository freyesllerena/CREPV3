<?php

/**
 * Created by PhpStorm.
 * User: myentreprise
 * Date: 02/07/2018
 * Time: 04:56
 */

namespace AppBundle\Form\Crep\CrepMj02\Competences;


use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Entity\Crep\CrepMj02\CrepMj02;

/**
 * Class CrepMj02AppreciationGeneraleType
 * @package AppBundle\Form\Crep\CrepMj02\Competences
 */
class CrepMj02AppreciationGeneraleType extends AbstractType
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
            'data_class' => 'AppBundle\Entity\Crep\CrepMj02\CrepMj02AppreciationGenerale',
        ));
    }
}