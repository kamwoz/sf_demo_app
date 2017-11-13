<?php

namespace AppBundle\Entity\User;

use AppBundle\Generator\Salt as SaltGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Manager class.
 *
 * @package AppBundle\Entity\User
 */
class UserManager
{

    /**
     * @var SaltGenerator
     */
    protected $saltGenerator;

    /**
     * @var UserPasswordEncoderInterface
     */
    protected $userPasswordEncoder;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;


    /**
     * Manager constructor.
     *
     * @param SaltGenerator $saltGenerator
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        SaltGenerator $saltGenerator,
        UserPasswordEncoderInterface $userPasswordEncoder,
        EntityManagerInterface $entityManager
    )
    {
        $this->saltGenerator = $saltGenerator;
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->entityManager = $entityManager;
    }


    /**
     * @param UserInterface $user
     *
     * @return UserInterface
     */
    public function update(UserInterface $user)
    {
        if (false == is_null($plainPassword = $user->getPlainPassword())) {
            if (true == is_null($user->getSalt())) {
                $salt = $this->saltGenerator->generate($user);

                $user->setSalt($salt);
            }

            $password = $this->userPasswordEncoder->encodePassword($user, $plainPassword);

            $user->setPassword($password);
        }

        $this->entityManager->persist($user);

        return $user;
    }
}
