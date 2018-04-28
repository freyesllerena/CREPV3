<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use AppBundle\Entity\PerimetreRlc;
use AppBundle\EnumTypes\EnumStatutCampagne;

class CampagneRlcType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $perimetresBrhp = $options['perimetresBrhp'];
        $campagneRlc = $options['campagneRlc'];

        if (EnumStatutCampagne::CREEE == $campagneRlc->getStatut() || EnumStatutCampagne::INITIALISEE == $campagneRlc->getStatut()) {
            $desactive = false;
        } else {
            $desactive = true;
        }

        $builder
            ->add('libelle', null, array(
                    'disabled' => true,
            ))
            ->add('perimetreRlc', EntityType::class, array(
                    'class' => 'AppBundle\Entity\PerimetreRlc',
                    'disabled' => true,
            ))
            ->add('perimetresBrhp', EntityType::class, array(
                    'class' => 'AppBundle\Entity\PerimetreBrhp',
                    'choices' => $perimetresBrhp,
                    'multiple' => true,
//                 'disabled'=> $desactive,
            ))
            ->add('anneeEvaluee', TextType::class, array(
                    'disabled' => true,
            ))
            ->add('dateDebut', DateType::class, array(
                    'widget' => 'single_text',
                    'input' => 'datetime',
                    'format' => 'dd/MM/yyyy',
                    'disabled' => true,
            ))
            ->add('documents', CollectionType::class, array(
                'entry_type' => UploadeDocumentType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
                'by_reference' => false,
            ))
            ->add('dateDebutEntretien', DateType::class, array(
                'widget' => 'single_text',
                'input' => 'datetime',
                'format' => 'dd/MM/yyyy',
                'disabled' => true,
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\CampagneRlc',
            'perimetresBrhp' => null,
            'campagneRlc' => null,
        ));
    }
}
