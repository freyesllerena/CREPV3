<?php

namespace AppBundle\Form\Crep\CrepMcc;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\EnumTypes\EnumStatutCrep;
use AppBundle\Form\Crep\CrepType;

class CrepMccAgentType extends CrepType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //Cette variable détermine les champs réservés à l'agent et qu'il peut modifier durant le visa du CREP
        $disabled1 = true;

        if (EnumStatutCrep::SIGNE_SHD == $builder->getData()->getStatut()) {
            $disabled1 = false;
        }

        //Cette variable détermine les champs réservés à l'agent et qu'il peut modifier durant le signature définitive du CREP
        $disabled2 = true;

        if (EnumStatutCrep::SIGNE_AH == $builder->getData()->getStatut()) {
            $disabled2 = false;
        }

        if (EnumStatutCrep::SIGNE_SHD == $builder->getData()->getStatut() && $builder->getData()->getAgent()->getSansAh()) {
            $disabled2 = false;
        }

        $builder
            ->add('commentaireAgentSurEntretien', null, ['attr' => ['maxlength' => '4096'],
                    'required' => false,
                    'disabled' => $disabled1, ])
            ->add('commentaireAgentCarriereMobilite', null, ['attr' => ['maxlength' => '4096'],
                    'required' => false,
                    'disabled' => $disabled1, ])
            ->add('observationsNotifAgent', null, [
                                'attr' => ['maxlength' => '4096'],
                                'required' => false,
                                'disabled' => $disabled2,
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepMcc\CrepMcc',
        ));
    }
}
