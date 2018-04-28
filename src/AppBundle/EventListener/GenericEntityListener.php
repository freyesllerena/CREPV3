<?php

namespace AppBundle\EventListener;

use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use FOS\UserBundle\Doctrine\UserManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\GenericEntityInterface;
use AppBundle\Entity\Utilisateur;

/**
 * Custom login listener.
 */
class GenericEntityListener
{
    private $securityContext;

    /**
     * Constructor.
     *
     * @param AuthorizationChecker $authorizationChecker
     * @param Doctrine             $doctrine
     * @param UserManager          $userManager
     * @param Parametre_general    $nbConnexionsAvantBlocage
     */
    public function __construct($securityContext)
    {
        $this->securityContext = $securityContext;
    }

    private function logAction(LifecycleEventArgs $args)
    {
        /* @var $entity GenericEntityInterface */
        $entity = $args->getEntity();

        if (!$entity instanceof GenericEntityInterface) {
            return;
        }

        //Si l'action a été lancée depuis une commande le currentToken == null
        $currentToken = $this->securityContext->getToken();
        $utilisateur = null;

        //Si le currentToken est différent de null on récupère l'utilisateur du token
        if ($currentToken) {
            $utilisateur = $currentToken->getUser();
            if (!($utilisateur instanceof Utilisateur)) {
                $utilisateur = null;
            }
        }

        // Log de l'action de modification
        $entity->setModifiePar($utilisateur);
        $entity->setDateModification(new \DateTime('now'));

        // Log de l'action de création
        if (null === $entity->getId()) {
            $entity->setCreePar($utilisateur);
            $entity->setDateCreation(new \DateTime('now'));
        }
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
