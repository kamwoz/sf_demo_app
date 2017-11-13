<?php

namespace AppBundle\Controller\API;

use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;

class DefaultAPIController extends Controller
{

    /**
     * @param $data
     * @param string $format
     * @param SerializationContext|null $context
     * @return string
     */
    protected function serialize($data, string $format = 'json', SerializationContext $context = null): string
    {
        return $this->getSerializer()->serialize($data, $format, $context);
    }

    /**
     * @return SerializerInterface
     */
    protected function getSerializer()
    {
        return $this->get('jms_serializer');
    }

    /**
     * @param FormInterface $form
     * @return array
     */
    protected function getErrorsFromForm(FormInterface $form): array
    {
        $errors = [];

        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $childForm) {
            if (false == ($childForm instanceof FormInterface)) {
                continue;
            }

            if (0 == count($childErrors = $this->getErrorsFromForm($childForm))) {
                continue;
            }

            $errors[$childForm->getName()] = $childErrors;
        }

        return $errors;
    }
}
