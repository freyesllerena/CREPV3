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
use AppBundle\Form\CrepType;
use AppBundle\Form\ObjectifEvalueType;
use AppBundle\Form\Crep\CrepMj01\Competences\CrepMj01CompetenceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use AppBundle\Form\Crep\CrepMj01\Formations\CrepMj01FormationSuivieType;
use AppBundle\Form\Crep\CrepMj01\Formations\CrepMj01FormationSolliciteeType;
use AppBundle\Form\Crep\CrepMj01\Formations\CrepMj01FormationEnvisageeType;


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
			->add('observationsAgentDeroulementEntretien', TextareaType::class, ['required' => false])
			->add('observationsAgentAppreciationsPortees', TextareaType::class, ['required' => false])            
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepMj01\CrepMj01',
            'echelleObjectifEvalue' => null,
            'echelleNiveauSame' => null,
            'ministere'=> null,
        	'selectTypologieFormation' => null,
        ));
    }
}
