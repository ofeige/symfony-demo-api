<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Ofeige\Rfc14Bundle\Service\Filter;
use Ofeige\Rfc14Bundle\Service\Pagination;
use Ofeige\Rfc14Bundle\Service\Sort;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Ofeige\Rfc14Bundle\Annotation as Rfc14;

class UserController extends FOSRestController
{

    /**
     * Returns the users in the system.
     *
     * @Rest\Get("/users")
     * @Rest\View()
     *
     * @Rfc14\Filter(name="username")
     * @Rfc14\Filter(name="created")
     * @Rfc14\Filter(name="country", queryBuilderName="a.country")
     *
     * @Rfc14\Sort(name="username")
     * @Rfc14\Sort(name="zipcode", queryBuilderName="a.zipCode")
     *
     * @Rfc14\Pagination
     *
     * @param EntityManagerInterface $entityManager
     * @param Filter $filter
     * @param Sort $sort
     * @param Pagination $pagination
     *
     * @return User[]
     */
    public function getUsers(EntityManagerInterface $entityManager, Filter $filter, Sort $sort, Pagination $pagination)
    {
        /** @var UserRepository $userRepository */
        $userRepository = $entityManager->getRepository(User::class);

        $users = $userRepository->findByRfc14($filter, $sort, $pagination);

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
     * @Security("has_role('ROLE_ADMIN')")
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