<?php

namespace AppBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use AppBundle\Entity\CampagnePnc;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\PerimetreRlc;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;
use AppBundle\Entity\PerimetreBrhp;
use AppBundle\Form\EventListener\AddPerimetresBrhpFieldListener;

class RechercheCampagnePncType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* @var $campagnePnc CampagnePnc */
        $campagnePnc = $options['campagnePnc'];

        /* @var $em EntityManager */
        $em = $options['em'];

        $perimetresRlc = clone $campagnePnc->getPerimetresRlc();
        $perimetresRlc[] = null;

        $builder
        ->add('perimetresRlc', EntityType::class, array(
                'class' => 'AppBundle:PerimetreRlc',
                'choices' => $perimetresRlc,
                'choice_label' => function ($perimetreRlc) {
                    if (null === $perimetreRlc) {
                        return '(Sans périmètre RLC)';
                    }

                    return $perimetreRlc->getLibelle();
                },
                'choice_value' => function ($perimetreRlc = null) {
                    return $perimetreRlc ? $perimetreRlc->getId() : 'null';
                },
                'expanded' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false,
        ));

        $builder
        ->add('categories', ChoiceType::class, array(
            'choices' => $em->getRepository('AppBundle:Agent')->getColonneByCampagne('categorieAgent', 'catégorie', $campagnePnc),
            'expanded' => false,
            'multiple' => true,
        ))

        ->add('affectations', ChoiceType::class, array(
            'choices' => $em->getRepository('AppBundle:Agent')->getColonneByCampagne('affectation', 'affectation', $campagnePnc),
            'expanded' => false,
            'multiple' => true,
        ))

        ->add('corps', ChoiceType::class, array(
            'choices' => $em->getRepository('AppBundle:Agent')->getColonneByCampagne('corps', 'corps', $campagnePnc),
            'expanded' => false,
            'multiple' => true,
        ));

        $builder->addEventSubscriber(new AddPerimetresBrhpFieldListener($em));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'campagnePnc' => null,
            'em' => null,
         	'translation_domain' => false,	// Afin de de ne pas avoir d'erreur de traduction
        ));
    }
}
