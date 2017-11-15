<?php


namespace AppBundle\Service;


use AppBundle\Entity\Folder\Folder;
use AppBundle\Entity\Folder\FoldersStructure;
use Doctrine\ORM\EntityManager;

class FolderManager
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function convertResponseDataToFolderStructure(FoldersStructure $folderStructure, $responseData)
    {
        $this->em->persist($folderStructure);
        foreach($responseData['folders'] as $folderRaw) {
            $folder = $this->createTree($folderRaw);
            $folder->setFoldersStructure($folderStructure);
            $folderStructure->addFolder($folder);
        }
    }

    /**
     * @param $folderRaw array
     *
     * @param Folder $parent
     *
     * @return Folder
     */
    private function createTree($folderRaw, Folder $parent = null)
    {
        $folder = $this->createFromArray($folderRaw);
        $folder->setParent($parent);
        $this->em->persist($folder);
        return $folder;
    }

    /**
     * @param $folderRaw array
     * @param Folder|null $parent
     *
     * @return Folder
     */
    private function createFromArray($folderRaw, Folder $parent = null)
    {
        $folder = new Folder();
        $folder->setAllowedExtensions($folderRaw['allowed_extensions'])
            ->setName($folderRaw['name'])
            ->setParent($parent);

        foreach ($folderRaw['childrens'] as $childrenRaw) {
            $folder->addChildren($this->createTree($childrenRaw, $folder));
        }

        return $folder;
    }
}