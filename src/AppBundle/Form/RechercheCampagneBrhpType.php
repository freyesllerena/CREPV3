<?php

namespace AppBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\CampagneBrhp;

class RechercheCampagneBrhpType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* @var $campagneBrhp CampagneBrhp */
        $campagneBrhp = $options['campagneBrhp'];

        /* @var $em EntityManager */
        $em = $options['em'];

        $builder
        ->add('categories', ChoiceType::class, array(
            'choices' => $em->getRepository('AppBundle:Agent')->getColonneByCampagne('categorieAgent', 'catégorie', $campagneBrhp),
            'expanded' => false,
            'multiple' => true,
        ))

        ->add('affectations', ChoiceType::class, array(
            'choices' => $em->getRepository('AppBundle:Agent')->getColonneByCampagne('affectation', 'affectation', $campagneBrhp),
            'expanded' => false,
            'multiple' => true,
        ))

        ->add('corps', ChoiceType::class, array(
            'choices' => $em->getRepository('AppBundle:Agent')->getColonneByCampagne('corps', 'corps', $campagneBrhp),
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
            'campagneBrhp' => null,
            'em' => null,
        ));
    }
}
