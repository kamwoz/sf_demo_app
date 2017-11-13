<?php

namespace AppBundle\Model\User;

/**
 * Role interface.
 *
 * @package AppBundle\Model\User
 */
interface Role
{

    /**
     * @var string
     */
    const USER = 'ROLE_USER';

    /**
     * @var string
     */
    const SUPER_ADMIN = 'ROLE_SUPER_ADMIN';
}
