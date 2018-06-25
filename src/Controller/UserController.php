<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

class UserController extends FOSRestController
{

    /**
     * @Rest\Get("/users")
     * @Rest\View()
     *
     * @param EntityManagerInterface $entityManager
     * @return User[]|array
     */
    public function getUsers(EntityManagerInterface $entityManager)
    {
        $userRepository = $entityManager->getRepository(User::class);

        $users = $userRepository->findAll();

        return $users;
    }

    /**
     * @Rest\Get("/users/{id}")
     * @Rest\View()
     *
     * @param User $user
     *
     * @return User
     */
    public function getUserById(User $user)
    {
        return $user;
    }

    /**
     * @Rest\Get("/users/{id}/addresses")
     * @Rest\View()
     *
     * @param User $user
     *
     * @return Address[]
     */
    public function getAddresses(User $user)
    {
        return $user->getAddresses();
    }

    /**
     * @Rest\Get("/users/{id}/addresses/{type}")
     * @Rest\View()
     *
     * @param User $user
     * @param string $type
     *
     * @return Address|View
     */
    public function getAddressByType(User $user, string $type)
    {
        foreach ($user->getAddresses() as $address) {
            if ($address->getType() === $type) {
                return $address;
            }
        }

        return $this->view('No matching address found.', Response::HTTP_NOT_FOUND);
    }
}