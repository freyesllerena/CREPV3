<?php
/**
 * Created by PhpStorm.
 * User: gpecheux-adc
 * Date: 25/07/2018
 * Time: 15:50
 */
namespace AppBundle\Form\Crep\CrepMinefContract;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CrepMinefContractCompetenceTransverseType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('niveauAcquis', ChoiceType::class, [
            'choices' => [
                '0' => 0,
                '1' => 1,
                '2' => 2,
                '3' => 3,
                '4' => 4,
            ],
            'expanded' => true,
            'multiple' => false,
        ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepMinefContract\CrepMinefContractCompetenceTransverse',
        ));
    }
}
