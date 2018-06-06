<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Document.
 *
 * @ORM\Table(name="document")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DocumentRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\HasLifecycleCallbacks
 */
class Document extends GenericEntity
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=512)
     */
    protected $nom;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=1024)
     */
    protected $path;

    /**
     * @var \Boolean
     *
     * @ORM\Column(type="boolean")
     */
    protected $brouillon;

    // propriété utilisé temporairement pour la suppression
    protected $filenameForRemove;

    /**
     * @Assert\File(maxSize="12M",
     * 				mimeTypes={"application/vnd.ms-excel", "text/plain", "text/csv", "application/pdf", "application/msword", "application/vnd.oasis.opendocument.text", "application/vnd.oasis.opendocument.spreadsheet", "application/vnd.ms-powerpoint", "application/vnd.oasis.opendocument.presentation", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "application/vnd.openxmlformats-officedocument.presentationml.presentation"},
     * 			 	mimeTypesMessage="Le fichier chargé est corrompu.",  groups={"Default"})
     *
     * @Assert\File(maxSize="12M", mimeTypes={"application/pdf"}, mimeTypesMessage="Le fichier chargé est corrompu",  groups={"chargement_crep_pdf"})
     *
     * @ Assert\NotBlank(message = "Champ obligatoire")
     */
    protected $file;

    /**
     * @var string
     *
     * @ORM\Column(type="text",  nullable=false)
     */
    protected $checksum;

    /**
     * Set nom.
     *
     * @param string $nom
     *
     * @return Document
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom.
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set path.
     *
     * @param string $path
     *
     * @return Document
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set file.
     *
     * @param string $nom
     *
     * @return Document
     */
    public function setFile($file)
    {
        $this->file = $file;
        $this->checksum = md5_file($this->file);

        return $this;
    }

    /**
     * Get file.
     *
     * @return Document
     */
    public function getFile()
    {
        return $this->file;
    }

    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : self::getDir().'/'.$this->path;
    }

    public static function getRootDir()
    {
        // le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
        return __DIR__.'/../../../web/'.self::getDir();
    }

    protected static function getDir()
    {
        // on se débarrasse de « __DIR__ » afin de ne pas avoir de problème lorsqu'on affiche
        // le document/image dans la vue.
        return 'documents';
    }

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
        // va automatiquement être lancée par la méthode rename(). Cela va empêcher
        // proprement l'entité d'être persistée dans la base de données si
        // erreur il y a

        $docrootDir = realpath(__DIR__.'/../../../../web/');
        $realpathDocument = realpath($this->file->getPathname());
        $docrootDirLength = strlen($docrootDir);

        // déplace du fichier s'il n'est pas dans web
        if (substr($realpathDocument, 0, $docrootDirLength) !== $docrootDir) {
            rename($this->file->getPathname(), $this->getRootDir().'/'.$this->path);
            unset($this->file);
        } else {
            // S'il est dans web, on le copie sans le déplacer
            copy($this->file->getPathname(), $this->getRootDir().'/'.$this->path);
        }
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function prePersist()
    {
        if (null !== $this->file) {
            // génére un nom unique
            $this->path = sha1(uniqid(mt_rand(), true)).'.'.$this->file->getExtension();

            $this->dateModification = new \DateTime();
        } else {
            return;
        }

        if (null === $this->path || null === $this->nom) {
            throw new \Exception('Erreur lors du chargement du fichier');
        }
    }

    /**
     * @ORM\PreRemove()
     */
    public function storeFilenameForRemove()
    {
        $this->filenameForRemove = $this->getAbsolutePath();
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($this->filenameForRemove && file_exists($this->filenameForRemove)) {
            unlink($this->filenameForRemove);
        }
    }

    public function __construct($fileName = null)
    {
        $this->dateCreation = new \DateTime();
        $this->dateModification = new \DateTime();
        $this->brouillon = false;

        if ($fileName) {
            $this->nom = $fileName;
            $filePath = $this->getRootDir().'/'.$fileName;

            $this->setFile(new \Symfony\Component\HttpFoundation\File\File($filePath));
        }
    }

    /**
     * Set brouillon.
     *
     * @param bool $brouillon
     *
     * @return Document
     */
    public function setBrouillon($brouillon)
    {
        $this->brouillon = $brouillon;

        return $this;
    }

    /**
     * Get brouillon.
     *
     * @return bool
     */
    public function getBrouillon()
    {
        return $this->brouillon;
    }

    public function getChecksum()
    {
        return $this->checksum;
    }

    private function setChecksum($checksum)
    {
        $this->checksum = $checksum;

        return $this;
    }

    /**
     * @Assert\Callback(groups = {"Default"})
     */
    public function validate(ExecutionContextInterface $context)
    {
        $extensionsAcceptees = ['csv', 'pdf', 'xls', 'xlsx', 'doc', 'docx', 'odt', 'ods', 'ppt', 'pptx', 'odp'];

        if ($this->file) {
            $fileName = $this->file->getClientOriginalName();

            $arrayTmp = explode('.', $fileName);
            $fileExtension = end($arrayTmp);

            if (!in_array($fileExtension, $extensionsAcceptees)) {
                $context->buildViolation('Extension non valide')
                ->atPath('file')
                ->addViolation();
            }
        }
    }

    /**
     * @Assert\Callback(groups = {"injection_referentiel"})
     */
    public function validateInjectionReferentiel(ExecutionContextInterface $context)
    {
        if ($this->file) {
            $fileName = $this->file->getClientOriginalName();

            $arrayTmp = explode('.', $fileName);
            $fileExtension = end($arrayTmp);

            if ('csv' !== $fileExtension) {
                $context->buildViolation('Extension non valide')
                ->atPath('file')
                ->addViolation();
            }
        }
    }

    /**
     * @Assert\Callback(groups = {"chargement_crep_pdf"})
     */
    public function validateChargementCrepPdf(ExecutionContextInterface $context)
    {
        if ($this->file) {
            $fileName = $this->file->getClientOriginalName();

            $arrayTmp = explode('.', $fileName);
            $fileExtension = end($arrayTmp);

            if ('pdf' !== $fileExtension) {
                $context->buildViolation('Extension non valide')
                ->atPath('file')
                ->addViolation();
            }
        }
    }
    
    /**
     * @Assert\Callback(groups = {"agent_edit", "Default"})
     */
    public function validateFile(ExecutionContextInterface $context){
    	if(null === $this->getId() && null === $this->file){
    		$context->buildViolation('Champ obligatoire')
    		->atPath('file')
    		->addViolation();
    	}
    }
}
