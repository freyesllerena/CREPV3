<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use AppBundle\Entity\Utilisateur;
use Symfony\Component\Validator\Constraints\NotBlank;

class ChoixRoleType extends AbstractType
{
    private $rolesApplicatifs = [
            'Administrateur' => 'ROLE_ADMIN',
            'Administrateur ministériel' => 'ROLE_ADMIN_MIN',
            'Pilote national de campagne' => 'ROLE_PNC',
            'Responsable local de campagne' => 'ROLE_RLC',
            'Acteur RH de proximité' => 'ROLE_BRHP',
            'Gestionnaire de recours' => 'ROLE_GESTIONNAIRE_RECOURS',
            'Conseiller de formation' => 'ROLE_CONSEILLER_FORMATION',
            'N+1' => 'ROLE_SHD',
            'N+2' => 'ROLE_AH',
            'Agent' => 'ROLE_AGENT', ];

    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            /* @var $utilisateur Utilisateur */
            $utilisateur = $this->tokenStorage->getToken()->getUser();

            $rolesUtilisateur = $utilisateur->getRoles();
            $form = $event->getForm();

            $rolesFormulaire = array();

            if ($utilisateur->hasRole('ROLE_ADMIN')) {
                $rolesFormulaire = $this->rolesApplicatifs;
            } else {
                foreach ($this->rolesApplicatifs as $libelle => $role) {
                    if (in_array($role, $rolesUtilisateur)) {
                        $rolesFormulaire[$libelle] = $role;
                    }
                }
            }

            //TODO : ajouter les rôles N+1 et N+2 si l'utilisateur est N+1 ou N+2 sur un CREP

            $formOptions = array(
                    'choices' => $rolesFormulaire,
                    'expanded' => true,
                    'multiple' => false,
                    'required' => false,
                    'placeholder' => null,
                    //'constraints' => [new NotBlank(["message" => "Veuillez sélectionner un rôle"]),]
            );

            $form->add('roles', ChoiceType::class, $formOptions);
        });
    }
}
