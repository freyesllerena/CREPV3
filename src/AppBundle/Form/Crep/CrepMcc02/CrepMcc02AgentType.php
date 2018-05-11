<?php

namespace AppBundle\Form\Crep\CrepMcc02;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
//use AppBundle\Form\CrepType;
use AppBundle\Form\Crep\CrepType;
use AppBundle\Form\ObjectifEvalueType;
use AppBundle\Form\Crep\CrepMcc02\Competences\CrepMcc02CompetenceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use AppBundle\Form\Crep\CrepMcc02\Formations\CrepMcc02FormationSuivieType;
//use AppBundle\Form\Crep\CrepMcc02\Formations\CrepMcc02FormationSolliciteeType;
//use AppBundle\Form\Crep\CrepMcc02\Formations\CrepMcc02FormationEnvisageeType;


class CrepMcc02AgentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('observationsAgentObjectifsEvalues', TextareaType::class, ['required' => false])
            ->add('observationsVisaAgent', TextareaType::class, ['required' => false])
//			->add('observationsAgentDeroulementEntretien', TextareaType::class, ['required' => false])
//			->add('observationsAgentAppreciationsPortees', TextareaType::class, ['required' => false])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepMcc02\CrepMcc02',
            'echelleObjectifEvalue' => null,
            'echelleNiveauSame' => null,
            'ministere'=> null,
        	'selectTypologieFormation' => null,
        ));
    }
}
