<?php

namespace AppBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\PerimetreBrhp;
use AppBundle\Entity\CampagneRlc;

class RechercheCampagneRlcType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* @var $campagneRlc CampagneRlc */
        $campagneRlc = $options['campagneRlc'];

        /* @var $em EntityManager */
        $em = $options['em'];

        $perimetresBrhp = clone $campagneRlc->getPerimetresBrhp();
        $perimetresBrhp[] = null;

        $builder
        ->add('perimetresBrhp', EntityType::class, array(
                'class' => 'AppBundle:PerimetreBrhp',
                'choices' => $perimetresBrhp,
                'choice_label' => function ($perimetreBrhp) {
                    if (null === $perimetreBrhp) {
                        return '(Sans périmètre BRHP)';
                    }

                    return $perimetreBrhp->getLibelle();
                },
                'choice_value' => function ($perimetreBrhp = null) {
                    return $perimetreBrhp ? $perimetreBrhp->getId() : 'null';
                },
                'expanded' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false,
        ));

        $builder
        ->add('categories', ChoiceType::class, array(
            'choices' => $em->getRepository('AppBundle:Agent')->getColonneByCampagne('categorieAgent', 'catégorie', $campagneRlc),
            'expanded' => false,
            'multiple' => true,
        ))

        ->add('affectations', ChoiceType::class, array(
            'choices' => $em->getRepository('AppBundle:Agent')->getColonneByCampagne('affectation', 'affectation', $campagneRlc),
            'expanded' => false,
            'multiple' => true,
        ))

        ->add('corps', ChoiceType::class, array(
            'choices' => $em->getRepository('AppBundle:Agent')->getColonneByCampagne('corps', 'corps', $campagneRlc),
            'expanded' => false,
            'multiple' => true,
        ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'campagneRlc' => null,
            'em' => null,
        	'translation_domain' => false,	// Afin de de ne pas avoir d'erreur de traduction
        ));
    }
}
