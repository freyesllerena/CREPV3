<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Psr\Log\LoggerInterface;

class ConstanteManager
{
    protected $kernelRootDir;
    protected $certificat;
    protected $repScripts;
    protected $defaultPassword;
    protected $companyName;
    protected $fromAddress;
    protected $replyAddress;
    protected $appName;
    protected $nbConnexionsAvantBlocage;
    protected $sessionTimeout;
    
    public function __construct(
    		$kernelRootDir, 
    		$certificat,
    		$repScripts,
    		$defaultPassword,
    		$companyName,
    		$fromAddress,
    		$replyAddress,
    		$appName,
    		$nbConnexionsAvantBlocage,
    		$sessionTimeout
    		)
    {
        $this->kernelRootDir = $kernelRootDir;
        $this->certificat = $certificat;
        $this->repScripts = $repScripts;
        $this->defaultPassword = $defaultPassword;
        $this->companyName = $companyName;
        $this->fromAddress = $fromAddress;
        $this->replyAddress = $replyAddress;
        $this->appName = $appName;
        $this->nbConnexionsAvantBlocage = $nbConnexionsAvantBlocage;
        $this->sessionTimeout = $sessionTimeout;
    }

    public function getKernelRootDir() {
    	return $this->kernelRootDir;
    }
    
    public function getCertificat() {
    	return $this->certificat;
    }
    
    public function getRepScripts() {
    	return $this->repScripts;
    }
    
    public function getDefaultPassword() {
    	return $this->defaultPassword;
    }
    
    public function getCompanyName() {
    	return $this->companyName;
    }
    
    public function getFromAddress() {
    	return $this->fromAddress;
    }
    
    public function getReplyAddress() {
    	return $this->replyAddress;
    }
    
    public function getAppName() {
    	return $this->appName;
    }
    
    public function getNbConnexionsAvantBlocage(){
    	return $this->nbConnexionsAvantBlocage;
    }
    
    public function getSessionTimeout(){
    	return $this->sessionTimeout;
    }
}
