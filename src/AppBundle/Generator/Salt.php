<?php

namespace AppBundle\Generator;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Salt class.
 *
 * @package AppBundle\Generator
 */
class Salt
{

    /**
     * @param UserInterface $user
     * @return string
     */
    public function generate(UserInterface $user)
    {
        return uniqid();
    }

}
