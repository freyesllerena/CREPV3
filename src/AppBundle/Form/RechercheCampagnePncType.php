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

//         $builder->get('perimetresRlc')->addEventListener(
//             FormEvents::POST_SUBMIT,
//             function (FormEvent $event) {
//                 $form = $event->getForm();
//                 dump(0);
//                 $this->addPerimetresBrhpField($form->getParent(), $form->getData());
//             }
//         );

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

        $builder->addEventSubscriber(new AddPerimetresBrhpFieldListener($em))
//         ->add('perimetresBrhp', EntityType::class, array(
//                 'class' => 'AppBundle:PerimetreBrhp',
//                 'choices' => null,
//                 'expanded' => false,
//                 'multiple' => true,
//         ))

        ;

//         $builder->addEventListener(
//             FormEvents::POST_SET_DATA,
//             function (FormEvent $event) {
//                 $data = $event->getData();

//                 dump($data);

//                 $perimetresBrhp = $data ? $data->getPerimetresBrhp() : [];

//                 $form = $event->getForm();
//                 if(empty($perimetresBrhp)){
//                     dump(1);
//                     $this->addPerimetresBrhpField($form, []);
//                 }else{
//                     dump(2);
//                     $perimetresRlc = [];

//                     /* @var $perimetreBrhp PerimetreBrhp */
//                     foreach ($perimetresBrhp as $perimetreBrhp){
//                         $perimetresRlc[$perimetreBrhp->getPerimetreRlc()->getId()] = $perimetreBrhp->getPerimetreRlc();
//                     }

//                     $this->addPerimetresBrhpField($form, $perimetresRlc);

//                     $form->get('perimetresRlc')->setData($perimetresRlc);
//                 }

                /*

                if ($ville) {
                    // On récupère le département et la région
                    $departement = $ville->getDepartement();
                    $region = $departement->getRegion();
                    // On crée les 2 champs supplémentaires
                    $this->addDepartementField($form, $region);
                    $this->addVilleField($form, $departement);
                    // On set les données
                    $form->get('region')->setData($region);
                    $form->get('departement')->setData($departement);
                } else {
                    // On crée les 2 champs en les laissant vide (champs utilisé pour le JavaScript)
                    $this->addDepartementField($form, null);
                    $this->addVilleField($form, null);
                }
                */
//             }
//         );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'campagnePnc' => null,
            'em' => null,
        ));
    }

//     private function addPerimetresBrhpField(FormInterface $form, $perimetresRlc = []) {
//         dump($form->getData());
//         dump("addPerimetresBrhpField");
//         $perimetresBrhp = [];
//         foreach ($perimetresRlc as $perimetreRlc) {
//             $perimetresBrhp = array_merge($perimetresBrhp, $perimetreRlc->getPerimetresBrhp()->toArray());
//         }

//         $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
//             'perimetresBrhp',
//             EntityType::class,
//             null,
//             [
//                 'class'           => PerimetreBrhp::class,
//                 'mapped'          => false,
//                 'required'        => false,
//                 'auto_initialize' => false,
//                 'choices'         => $perimetresBrhp,
//                 'expanded' => false,
//                 'multiple' => false,
//             ]
//         );
//         $form->add($builder->getForm());
//     }
}
