<?php

namespace AppBundle\Form\Crep\CrepMcc02;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Crep\CrepMcc02\CrepMcc02MobilitePoste;

class CrepMcc02MobilitePosteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('memeService', null, ['required' => false, 'label' => ' Au sein du même service'])
            ->add('memeMinistere', null, ['required' => false, 'label' => ' Au sein du ministère'])
            ->add('autreMinistere', null, ['required' => false, 'label' => ' Dans un autre ministère'])
            ->add('autreFonctionPublique', null, ['required' => false, 'label' => ' Dans une autre fonction publique'])
            ->add('autreProjet', null, ['required' => false, 'label' => '  Autre projet'])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepMcc02\CrepMcc02MobilitePoste'
        ));
    }
}
