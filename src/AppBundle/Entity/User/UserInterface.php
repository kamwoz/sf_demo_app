<?php

namespace AppBundle\Entity\User;

use Symfony\Component\Security\Core\User\UserInterface as BaseUserInterface;

/**
 * UserInterface interface.
 *
 * @package AppBundle\Entity\User
 */
interface UserInterface extends BaseUserInterface
{

    /**
     * @return int
     */
    public function getId();


    /**
     * @param string $salt
     */
    public function setSalt($salt);

    /**
     * @param string $password
     */
    public function setPassword($password);


    /**
     * @return string
     */
    public function getPlainPassword();

    /**
     * @param $plainPassword
     */
    public function setPlainPassword($plainPassword);

}
