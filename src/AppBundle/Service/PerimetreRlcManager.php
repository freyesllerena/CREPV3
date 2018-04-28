<?php

namespace AppBundle\Service;

use AppBundle\Entity\Ministere;
use FOS\UserBundle\Model\UserManagerInterface;

class PerimetreRlcManager extends BaseManager
{
    protected $utilisateurManager;

    /* @var $repository RLCRepository */
    protected $repository;

    protected $fos_user_manager;

    public function init(UtilisateurManager $utilisateurManager, UserManagerInterface $fos_user_manager)
    {
        //call_user_func_array(array($this, 'parent::__construct'), func_get_args());
        $this->utilisateurManager = $utilisateurManager;
        $this->fos_user_manager = $fos_user_manager;
        $this->repository = $this->em->getRepository('AppBundle:PerimetreRlc');
    }

    /**
     * Permet de récumétre les périmètre d'un ministère.
     *
     * @param Ministere $ministere
     */
    public function getPerimetreRlc(Ministere $ministere)
    {
        return $this->repository->findByMinistere($ministere, ['libelle' => 'asc']);
    }
}
