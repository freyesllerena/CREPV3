<?php


namespace AppBundle\Form\Crep\CrepMcc02\Competences;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Entity\Crep\CrepMcc02\CrepMcc02;

class CrepMcc02AutresPotentielEvolutionType extends CrepMcc02PotentielEvolutionType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle', null, [
                'attr' => ['maxlength' => '4096'],
                'required' => false, ])
            ->add('niveauAcquis', ChoiceType::class, [
                'choices' => CrepMcc02::$niveauAutrePotentielEvolution,
                'expanded' => true,
                'label' => false,
                'multiple' => false,
            ])
            ->remove('appreciation')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepMcc02\CrepMcc02AutresPotentielEvolution',
        ));
    }
}