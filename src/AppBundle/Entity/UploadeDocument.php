<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UploadeDocument.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UploadeDocumentRepository")
 * @ORM\HasLifecycleCallbacks
 */
class UploadeDocument extends Document
{
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function save()
    {
        if (null === $this->file) {
            return;
        }

        // s'il y a une erreur lors du déplacement du fichier, une exception
        // va automatiquement être lancée par la méthode deplacer(). Cela va empêcher
        // proprement l'entité d'être persistée dans la base de données si
        // erreur il y a
        $this->file->move($this->getRootDir(), $this->path);

        unset($this->file);
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function prePersist()
    {
        if (null !== $this->file) {
            // faites ce que vous voulez pour générer un nom unique
            $this->path = sha1(uniqid(mt_rand(), true)).'.'.$this->file->guessExtension();

            $this->nom = $this->file->getClientOriginalName();
            $this->dateModification = new \DateTime();
        }

        if (null === $this->path || null === $this->nom) {
            throw new \Exception('Erreur lors du chargement du fichier');
        }
    }

    protected static function getDir()
    {
        // on se débarrasse de « __DIR__ » afin de ne pas avoir de problème lorsqu'on affiche
        // le document/image dans la vue.
        return 'documents/uploads';
    }

    // Cette methode doit être réécrite sinon l'apple à la méthode getDir() se fait
    // sur la classe mère et retourne le mauvais répértoire
    public static function getRootDir()
    {
        // le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
        return __DIR__.'/../../../web/'.self::getDir();
    }

    // Cette methode doit être réécrite sinon l'apple à la méthode getDir() se fait
    // sur la classe mère et retourne le mauvais répértoire
    public function getWebPath()
    {
        return null === $this->path ? null : self::getDir().'/'.$this->path;
    }
}
