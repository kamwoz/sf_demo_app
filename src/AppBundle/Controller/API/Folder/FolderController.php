<?php

namespace AppBundle\Controller\API\Folder;

use AppBundle\Controller\API\DefaultAPIController;
use AppBundle\Entity\Folder\FoldersStructure;
use AppBundle\Form\Folder\FolderStructureType;
use AppBundle\Service\FolderManager;
use JMS\Serializer\SerializationContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class FolderController extends DefaultAPIController
{
    /**
     * @Route(
     *     path="/api/folder",
     *     name="app_api_folder_post_structure"
     * )
     * @Method({"POST"})
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function postFolderStructureAction(Request $request)
    {
        $folderStructure = new FoldersStructure();
        $form = $this->createForm(FolderStructureType::class, $folderStructure);
        $data['folders'] = json_decode($request->getContent(), true);
        $form->submit($data);
        $em = $this->getDoctrine()->getManager();

        if (
            (true == $form->isSubmitted()) &&
            (true == $form->isValid())
        ) {
            $em->getConnection()->beginTransaction();
            try {
                // remove old structure and update schema
                $em->merge($this->getUser());
                $this->getUser()->setFolderStructure(null);
                $em->flush();

                $em->getConnection()->commit();
            } catch (\Exception $e) {
                $em->getConnection()->rollBack();
                throw $e;
            }

            /** @var $manager FolderManager */
            $manager = $this->get(FolderManager::class);
            $folderStructure = new FoldersStructure();
            $folderStructure->setUser($this->getUser());
            $manager->convertResponseDataToFolderStructure($folderStructure, $data);

            $em->getConnection()->beginTransaction();
            try {
                $em->flush();
                $em->getConnection()->commit();
            } catch (\Exception $e) {
                $em->getConnection()->rollBack();
                throw $e;
            }
            $em->persist($folderStructure);
            $em->flush();

            return new JsonResponse($this->serialize($folderStructure, 'json', SerializationContext::create()->setGroups([ 'api' ])));
        }

        $errors = $this->getErrorsFromForm($form);
        $data = [
            'type' => 'validation_error',
            'title' => 'There was a validation error',
            'errors' => $errors
        ];

        return new JsonResponse($data, 400);
    }

    /**
     * @Route(
     *     path="/api/folder",
     *     name="app_api_folder_get_structure"
     * )
     * @Method({"GET"})
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function getFolderStructureAction()
    {
        $folder = $this->getUser()->getFolderStructure();
        return new JsonResponse($this->serialize($folder, 'json', SerializationContext::create()->setGroups([ 'api' ])));
    }
}
