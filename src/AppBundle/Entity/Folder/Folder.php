<?php

namespace AppBundle\Entity\Folder;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Folders class.
 *
 * @ORM\Table(name="folders")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Folder\FolderRepository")
 */
class Folder
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="text", length=255)
     * @JMS\Expose()
     * @JMS\Groups({"api"})
     */
    protected $name;

    /**
     * @var array
     * @ORM\Column(type="object")
     * @JMS\Expose()
     * @JMS\Groups({"api"})
     */
    protected $allowedExtensions;

    /**
     * @var Folder[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Folder\Folder", mappedBy="parent", orphanRemoval=true, cascade={"remove"})
     * @JMS\Expose()
     * @JMS\Groups({"api"})
     */
    protected $childrens;

    /**
     * @var Folder
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Folder\Folder", inversedBy="childrens")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $parent;

    /**
     * @var FoldersStructure|null
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Folder\FoldersStructure", inversedBy="folders")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $foldersStructure;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->childrens = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Folder
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set allowedExtensions
     *
     * @param array $allowedExtensions
     *
     * @return Folder
     */
    public function setAllowedExtensions($allowedExtensions)
    {
        $this->allowedExtensions = $allowedExtensions;

        return $this;
    }

    /**
     * Get allowedExtensions
     *
     * @return array
     */
    public function getAllowedExtensions()
    {
        return $this->allowedExtensions;
    }

    /**
     * Add children
     *
     * @param Folder $children
     *
     * @return Folder
     */
    public function addChildren(Folder $children)
    {
        $this->childrens[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param Folder $children
     */
    public function removeChildren(Folder $children)
    {
        $this->childrens->removeElement($children);
    }

    /**
     * Get childrens
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildrens()
    {
        return $this->childrens;
    }

    /**
     * Set parent
     *
     * @param Folder $parent
     *
     * @return Folder
     */
    public function setParent(Folder $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return Folder
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set foldersStructure
     *
     * @param FoldersStructure $foldersStructure
     *
     * @return Folder
     */
    public function setFoldersStructure(FoldersStructure $foldersStructure = null)
    {
        $this->foldersStructure = $foldersStructure;

        return $this;
    }

    /**
     * Get foldersStructure
     *
     * @return FoldersStructure
     */
    public function getFoldersStructure()
    {
        return $this->foldersStructure;
    }
}
