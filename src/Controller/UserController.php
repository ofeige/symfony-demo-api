<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\User;
use App\Exception\ValidationException;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Ofeige\Rfc14Bundle\Service\Filter;
use Ofeige\Rfc14Bundle\Service\Pagination;
use Ofeige\Rfc14Bundle\Service\Sort;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Ofeige\Rfc14Bundle\Annotation as Rfc14;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class UserController extends FOSRestController
{

    /**
     * Returns the users in the system.
     *
     * @Rest\Get("/users")
     * @Rest\View(serializerGroups={"user"})
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
     * //TODO: Response to docs (autogenerate from return type and the serializerGroups above??)
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
     * @Rest\View(serializerGroups={"user"})
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
     * @Rest\View(serializerGroups={"address"})
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
     * @Rest\View(serializerGroups={"address"})
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

    /**
     * Creates a new user.
     *
     * @Rest\Post("/users")
     * @Rest\View(serializerGroups={"user"})
     *
     * @IsGranted("ROLE_ADMIN")
     *
     * @ParamConverter("user", converter="fos_rest.request_body")
     *
     * @param ConstraintViolationListInterface $validationErrors
     * @param User $user
     *
     * @return User
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function postUser(ConstraintViolationListInterface $validationErrors, User $user)
    {
        if (count($validationErrors) > 0) {
            throw new ValidationException($validationErrors);
        }

        /** @var UserRepository $userRepository */
        $userRepository = $this->getDoctrine()->getRepository(User::class);

        $userRepository->persist($user);

        return $user;
    }
}