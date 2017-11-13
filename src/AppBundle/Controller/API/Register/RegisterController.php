<?php

namespace AppBundle\Controller\API\Register;

use AppBundle\Controller\API\DefaultAPIController;
use AppBundle\Entity\User\User;
use AppBundle\Entity\User\UserManager;
use AppBundle\Form\Register\RegisterType;
use JMS\Serializer\SerializationContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends DefaultAPIController
{
    /**
     * @Route(
     *     path="/api/register",
     *     name="app_api_register_register"
     * )
     * @Method({"POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function postRegisterAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->submit(json_decode($request->getContent(), true));

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);

        if (
            (true == $form->isSubmitted()) &&
            (true == $form->isValid())
        ) {
            $this->get(UserManager::class)->update($user);
            $em->flush();

            return new JsonResponse(
                $this->serialize($user, 'json', SerializationContext::create()->setGroups([ 'api' ]))
            );
        }

        $errors = $this->getErrorsFromForm($form);
        $data = [
            'type' => 'validation_error',
            'title' => 'There was a validation error',
            'errors' => $errors
        ];

        return new JsonResponse($data, 400);
    }
}
