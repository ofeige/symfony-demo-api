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
use Nelmio\ApiDocBundle\Annotation\Model;
use Ofeige\Rfc14Bundle\Service\Rfc14Service;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
     *
     * @param User[] $users
     * @return User[]
     */
    public function getUsersV3(array $users)
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
     * @Rfc14\Filter(name="id", queryBuilderName="u.id")
     * @Rfc14\Filter(name="type")
     *
     * @Rfc14\Result("addresses", entity="App\Entity\Address")
     *
     * @SWG\Tag(name="User")
     *
     * @param Address[] $addresses
     * @return Address[]
     */
    public function getAddresses(array $addresses)
    {
        return $addresses;
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