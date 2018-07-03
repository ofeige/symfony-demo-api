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
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use Ofeige\Rfc14Bundle\Service\Rfc14Service;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;
use Ofeige\Rfc14Bundle\Annotation as Rfc14;
use Ofeige\Rfc1Bundle\Annotation as Rfc1;

/**
 * Class UserController
 * @package App\Controller
 */
class UserController extends FOSRestController
{
    /**
     * Returns the users in the system.
     *
     * @Rest\Get("/v1/users")
     * @Rfc1\View(dtoMapper="App\DtoMapper\UserV1Mapper")
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
     *     @SWG\Schema(type="array", @SWG\Items(ref=@Model(type="Api\Dto\UserV1")))
     * )
     *
     * @param EntityManagerInterface $entityManager
     * @param Rfc14Service $rfc14Service
     * @return User[]
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Ofeige\Rfc14Bundle\Exception\PaginationException
     */
    public function getUsersV1(EntityManagerInterface $entityManager, Rfc14Service $rfc14Service)
    {
        /** @var UserRepository $userRepository */
        $userRepository = $entityManager->getRepository(User::class);

        $users = $userRepository->findByRfc14($rfc14Service);

        return $users;
    }

    /**
     * Returns the users in the system.
     *
     * @Rest\Get("/v2/users")
     * @Rfc1\View(dtoMapper="App\DtoMapper\UserV2Mapper")
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
     * @Rfc14\Result("users", entity="App\Entity\User")
     *
     * @SWG\Tag(name="User")
     * @SWG\Response(
     *     response=200,
     *     description="List of users matching the filter",
     *     @SWG\Schema(type="array", @SWG\Items(ref=@Model(type="Api\Dto\UserV2")))
     * )
     *
     * @param User[] $users
     * @return User[]
     */
    public function getUsersV2(array $users)
    {
        return $users;
    }

    /**
     * Returns the users in the system.
     *
     * @Rest\Get("/v3/users")
     * @Rfc1\View(dtoMapper="App\DtoMapper\UserV3Mapper")
     *
     * @Rfc14\Result("users", entity="App\Entity\User")
     *
     * @SWG\Tag(name="User")
     * @SWG\Response(
     *     response=200,
     *     description="List of users matching the filter",
     *     @SWG\Schema(type="array", @SWG\Items(ref=@Model(type="Api\Dto\UserV3")))
     * )
     *
     * @param User[] $users
     * @return User[]
     */
    public function getUsersV3(array $users)
    {
        return $users;
    }

    /**
     * Returns the users in the system.
     *
     * @Rest\Get("/v4/users")
     * @Rfc1\View(dtoMapper="App\DtoMapper\UserV4Mapper")
     *
     * @Rfc14\Result("users", entity="App\Entity\User")
     *
     * @SWG\Tag(name="User")
     * @SWG\Response(
     *     response=200,
     *     description="List of users matching the filter",
     *     @SWG\Schema(type="array", @SWG\Items(ref=@Model(type="Api\Dto\UserV4")))
     * )
     *
     * @param User[] $users
     * @return User[]
     */
    public function getUsersV4(array $users)
    {
        return $users;
    }

    /**
     * Returns the user object for the given id.
     *
     * @Rest\Get("/v1/users/{id}")
     * @Rfc1\View(dtoMapper="App\DtoMapper\UserV3Mapper")
     *
     * @SWG\Tag(name="User")
     * @SWG\Parameter(name="id", in="path", type="integer", description="User id")
     * @SWG\Response(
     *     response=200,
     *     description="User",
     *     @Model(type="Api\Dto\UserV3")
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
     * @Rest\Get("/v1/users/{id}/addresses")
     * @Rfc1\View(dtoMapper="App\DtoMapper\AddressV1Mapper")
     *
     * @SWG\Tag(name="User")
     * @SWG\Parameter(name="id", in="path", type="integer", description="User id")
     * @SWG\Response(
     *     response=200,
     *     description="List of addresses of the user",
     *     @SWG\Schema(type="array", @SWG\Items(ref=@Model(type="Api\Dto\AddressV1")))
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
     * @Rest\Get("/v1/users/{id}/addresses/{type}")
     * @Rfc1\View(dtoMapper="App\DtoMapper\AddressV1Mapper")
     *
     * @SWG\Tag(name="User")
     * @SWG\Parameter(name="id", in="path", type="integer", description="User id")
     * @SWG\Parameter(name="type", in="path", type="string", enum={"delivery","billing"}, description="Type of the address")
     * @SWG\Response(
     *     response=200,
     *     description="Specific address of the user",
     *     @Model(type="Api\Dto\AddressV1")
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
     * @Rest\Post("/v1/users")
     * @Rfc1\View(dtoMapper="App\DtoMapper\UserV1Mapper")
     *
     * @IsGranted("ROLE_ADMIN")
     *
     * @ParamConverter("user", converter="fos_rest.request_body")
     *
     * @SWG\Tag(name="User")
     * @SWG\Response(
     *     response=200,
     *     description="User",
     *     @Model(type="Api\Dto\UserV3")
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