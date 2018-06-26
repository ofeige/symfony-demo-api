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
use Nelmio\ApiDocBundle\Annotation\Model;
use Ofeige\Rfc14Bundle\Service\Filter;
use Ofeige\Rfc14Bundle\Service\Pagination;
use Ofeige\Rfc14Bundle\Service\Sort;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Swagger\Annotations as SWG;
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
     * @SWG\Tag(name="User")
     * @SWG\Response(
     *     response=200,
     *     description="List of users matching the filter",
     *     @SWG\Schema(type="array", @SWG\Items(ref=@Model(type=User::class, groups={"user"})))
     * )
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
     * Returns the user object for the given id.
     *
     * @Rest\Get("/users/{id}")
     * @Rest\View(serializerGroups={"user"})
     *
     * @SWG\Tag(name="User")
     * @SWG\Parameter(name="id", in="path", type="integer", description="User id")
     * @SWG\Response(
     *     response=200,
     *     description="User",
     *     @Model(type=User::class, groups={"user"})
     * )
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
     * Returns all addresses for the given user.
     *
     * @Rest\Get("/users/{id}/addresses")
     * @Rest\View(serializerGroups={"address"})
     *
     * @SWG\Tag(name="User")
     * @SWG\Parameter(name="id", in="path", type="integer", description="User id")
     * @SWG\Response(
     *     response=200,
     *     description="List of addresses of the user",
     *     @SWG\Schema(type="array", @SWG\Items(ref=@Model(type=Address::class, groups={"address"})))
     * )
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
     * Returns the specific address for the given user.
     *
     * @Rest\Get("/users/{id}/addresses/{type}")
     * @Rest\View(serializerGroups={"address"})
     *
     * @SWG\Tag(name="User")
     * @SWG\Parameter(name="id", in="path", type="integer", description="User id")
     * @SWG\Parameter(name="type", in="path", type="string", enum={"delivery","billing"}, description="Type of the address")
     * @SWG\Response(
     *     response=200,
     *     description="Specific address of the user",
     *     @Model(type=Address::class, groups={"address"})
     * )
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
     * @SWG\Tag(name="User")
     * @SWG\Response(
     *     response=200,
     *     description="User",
     *     @Model(type=User::class, groups={"user"})
     * )
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