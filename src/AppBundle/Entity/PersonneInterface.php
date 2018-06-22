<?php

namespace AppBundle\Entity;

interface PersonneInterface
{
	public function getCivilite();
	
    public function setCivilite($civilite);
  
    public function getTitre();
    
    public function setTitre($titre);
    
    public function getNom();
    
    public function setNom($nom);
   
    public function getPrenom();

    public function setPrenom($prenom);

    public function getEmail();
    
    public function setEmail($email);
}
