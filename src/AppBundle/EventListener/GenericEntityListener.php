<?php

namespace AppBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\GenericEntityInterface;
use AppBundle\Entity\Utilisateur;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Custom login listener.
 */
class GenericEntityListener
{
    protected $tokenStorage;

    /**
     * Constructor.
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    private function logAction(LifecycleEventArgs $args)
    {
        /* @var $entity GenericEntityInterface */
        $entity = $args->getEntity();

        if (!$entity instanceof GenericEntityInterface) {
            return;
        }

        //Si l'action a été lancée depuis une commande le currentToken == null
        $currentToken = $this->tokenStorage->getToken();
        $utilisateur = null;

        //Si le currentToken est différent de null on récupère l'utilisateur du token
        if ($currentToken) {
            $utilisateur = $currentToken->getUser();
            if (!($utilisateur instanceof Utilisateur)) {
                $utilisateur = null;
            }
        }

        // Log de l'action de modification
        if($utilisateur){
        	$entity->setModifiePar($utilisateur);
        }
        
        $entity->setDateModification(new \DateTime('now'));
        
        // Log de l'action de création
        if (null === $entity->getId() && $utilisateur) {
            $entity->setCreePar($utilisateur);
        }
        
        $entity->setDateCreation(new \DateTime('now'));
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $this->logAction($args);
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->logAction($args);
    }
}
