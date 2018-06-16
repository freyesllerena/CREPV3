<?php

/**
 * Created by PhpStorm.
 * User: freyes-adc
 * Date: 14/06/2018
 * Time: 16:47
 */

namespace AppBundle\Form\Crep\CrepMj02;


use AppBundle\Entity\Crep;
use AppBundle\Form\Crep\CrepType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CrepMj02Type extends CrepType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Crep\CrepMj02\CrepMj02 $crep */
        $crep = $builder->getData();
        $options['ministere'] = $crep->getAgent()->getCampagnePnc()->getMinistere();

        parent::buildForm($builder, $options);

        $ministere = $crep->getAgent()->getCampagnePnc()->getMinistere();
        $tableauNotesAgent = [];

        for($i=1 ; $i<=20 ; $i++){
            $tableauNotesAgent[$i.'/20'] = $i;
        }

        $builder
            ->add('nomNaissance', null, ['required' => true])
            ->add('prenom')

            ->add('grade', null, ['required' => false])
            ->add('corps', null, ['required' => false])
//            ->add('posteOccupe', null, ['required' => false])
//            ->add('affectation', null, ['required' => false])

        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepMj02\CrepMj02',
            'echelleObjectifEvalue' => null,
            'echelleNiveauSame' => null,
            'ministere'=> null,
            'selectTypologieFormation' => null,
        ));
    }
}