<?php

namespace AppBundle\Form;

use AppBundle\Repository\PerimetreRlcRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use AppBundle\Entity\CampagnePnc;
use AppBundle\EnumTypes\EnumStatutCampagne;

class CampagnePncType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $utilisateur = $options['utilisateur'];
        /* @var $campagnePnc CampagnePnc */
        $campagnePnc = $options['campagnePnc'];

        if (EnumStatutCampagne::CREEE === $campagnePnc->getStatut()) {
            $desactive = false;
        } else {
            $desactive = true;
        }

        $builder
            ->add('libelle', TextType::class)
            ->add('perimetresRlc', EntityType::class, array(
                'class' => 'AppBundle\Entity\PerimetreRlc',
                'query_builder' => function (PerimetreRlcRepository $er) use ($utilisateur) {
                    return $er->getPerimetresRlcByMinistere($utilisateur);
                },
                'multiple' => true,
            ))
            ->add('anneeEvaluee', TextType::class, array(
                'disabled' => $desactive,
            ))
            ->add('dateDebut', DateType::class, array(
                    'widget' => 'single_text',
                    'input' => 'datetime',
                    'format' => 'dd/MM/yyyy',
                    'disabled' => $desactive,
            ))
            ->add('dateCloture', DateType::class, array(
                    'widget' => 'single_text',
                    'input' => 'datetime',
                    'format' => 'dd/MM/yyyy',
            ))
            ->add('documents', CollectionType::class, array(
                    'entry_type' => UploadeDocumentType::class,
                    'allow_add' => true, // permettre à l'utilisateur d'ajouter des documents dynamiquement
                    'allow_delete' => true, // permettre à l'utilisateur de supprimer des documents dynamiquement
                    'label' => false,
                    'by_reference' => false,
            ))
            ->add('dateDebutEntretien', DateType::class, array(
                'widget' => 'single_text',
                'input' => 'datetime',
                'format' => 'dd/MM/yyyy',
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\CampagnePnc',
            'utilisateur' => null,
            'campagnePnc' => null,
        ));
    }
}
