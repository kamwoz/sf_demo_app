<?php

namespace AppBundle\Entity\Folder;

use AppBundle\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Folders class.
 *
 * @ORM\Table(name="folders_structures")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Folder\FoldersStructureRepository")
 */
class FoldersStructure
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
     * @var Folder[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Folder\Folder", mappedBy="foldersStructure", cascade={"remove"})
     * @JMS\Expose()
     * @JMS\Groups({"api"})
     */
    protected $folders;

    /**
     * @var User
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User\User", inversedBy="folderStructure")
     */
    protected $user;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->folders = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add folder
     *
     * @param Folder $folder
     *
     * @return FoldersStructure
     */
    public function addFolder(Folder $folder)
    {
        $this->folders[] = $folder;

        return $this;
    }

    /**
     * Remove folder
     *
     * @param Folder $folder
     */
    public function removeFolder(Folder $folder)
    {
        $this->folders->removeElement($folder);
    }

    /**
     * Get folders
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFolders()
    {
        return $this->folders;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return FoldersStructure
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}
