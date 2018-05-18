<?php

namespace AppBundle\Form\EventListener;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\PerimetreBrhp;

class AddPerimetresBrhpFieldListener implements EventSubscriberInterface
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'onPreSetData',
            FormEvents::PRE_SUBMIT => 'onPreSubmit',
        );
    }

    /**
     * Rajoute un champ departement au formulaire.
     *
     * @param FormInterface $form
     * @param Region|null   $region
     */
    private function addPerimetresBrhpForm(FormInterface $form, $perimetresRlc = [])
    {
        $perimetresBrhp = $this->em->getRepository(PerimetreBrhp::class)->findPerimetresBrhpByPerimetresRlc($perimetresRlc);
        $perimetresBrhp[] = null;

        $form->add('perimetresBrhp', EntityType::class, array(
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
                'required' => false,
                'mapped' => false,
                'expanded' => false,
                'multiple' => true,
            )
        );
    }

    //Fonction appeler à l'ouverture de la page contenant le fomulaire
    public function onPreSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        $perimetreRlc = $data ? $form->get('perimetresRlc')->getData() : null;
        $this->addPerimetresBrhpForm($form, $perimetreRlc);
    }

    //fonction appeler pendant le submit en Ajax avec des evenement JS
    public function onPreSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (!$data) {
            return;
        }

        $perimetreRlc = key_exists('perimetresRlc', $data) ? $data['perimetresRlc'] : null;

        $this->addPerimetresBrhpForm($form, $perimetreRlc);
    }
}
