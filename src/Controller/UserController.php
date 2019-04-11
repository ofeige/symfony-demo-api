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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Shopping\ApiTKUrlBundle\Service\ApiService;
use Symfony\Component\Validator\ConstraintViolationListInterface;

use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;
use Shopping\ApiTKUrlBundle\Annotation as ApiTK;
use Shopping\ApiTKDtoMapperBundle\Annotation as DtoMapper;
use Shopping\ApiTKDeprecationBundle\Annotation\Deprecated;

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
     * @DtoMapper\View(dtoMapper="App\DtoMapper\UserV1Mapper")
     *
     * @ApiTK\Filter(name="username")
     * @ApiTK\Filter(name="created")
     * @ApiTK\Filter(name="country", queryBuilderName="a.country")
     *
     * @ApiTK\Sort(name="username")
     * @ApiTK\Sort(name="zipcode", queryBuilderName="a.zipCode")
     *
     * @ApiTK\Pagination
     *
     * @Deprecated(hideInDoc=true)
     *
     * @SWG\Tag(name="User")
     * @SWG\Response(
     *     response=200,
     *     description="List of users matching the filter",
     *     @SWG\Schema(type="array", @SWG\Items(ref=@Model(type="Api\Dto\UserV1")))
     * )
     *
     * @param EntityManagerInterface $entityManager
     * @param ApiService             $apiService
     *
     * @return User[]
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Shopping\ApiTKUrlBundle\Exception\PaginationException
     */
    public function getUsersV1(EntityManagerInterface $entityManager, ApiService $apiService): array
    {
        /** @var UserRepository $userRepository */
        $userRepository = $entityManager->getRepository(User::class);

        $users = $userRepository->findByRequest($apiService);

        return $users;
    }

    /**
     * Returns the users in the system.
     *
     * @Rest\Get("/v2/users")
     * @DtoMapper\View(dtoMapper="App\DtoMapper\UserV2Mapper")
     *
     * @ApiTK\Filter(name="username")
     * @ApiTK\Filter(name="created")
     * @ApiTK\Filter(name="country", queryBuilderName="a.country")
     *
     * @ApiTK\Sort(name="username")
     * @ApiTK\Sort(name="zipcode", queryBuilderName="a.zipCode")
     *
     * @ApiTK\Pagination
     *
     * @ApiTK\Result("users", entity="App\Entity\User")
     *
     * @Deprecated(removedAfter="2018-10-09")
     *
     * @SWG\Tag(name="User")
     *
     * @param User[] $users
     * @return User[]
     */
    public function getUsersV2(array $users): array
    {
        return $users;
    }

    /**
     * Returns the users in the system.
     *
     * @Rest\Get("/v3/users")
     * @DtoMapper\View(dtoMapper="App\DtoMapper\UserV3Mapper")
     *
     * @ApiTK\Result("users", entity="App\Entity\User")
     *
     * @SWG\Tag(name="User")
     *
     * @param User[] $users
     * @return User[]
     */
    public function getUsersV3(array $users): array
    {
        return $users;
    }

    /**
     * Returns the user object for the given id.
     *
     * @Rest\Get("/v1/users/{id}")
     * @DtoMapper\View(dtoMapper="App\DtoMapper\UserV3Mapper")
     *
     * @SWG\Tag(name="User")
     * @SWG\Parameter(name="id", in="path", type="integer", description="User id")
     *
     * @param User $user
     *
     * @return User
     */
    public function getUserById(User $user): User
    {
        return $user;
    }

    /**
     * Returns all addresses for the given user.
     *
     * @Rest\Get("/v1/users/{id}/addresses")
     * @DtoMapper\View(dtoMapper="App\DtoMapper\AddressV1Mapper")
     *
     * @ApiTK\Filter(name="id", queryBuilderName="u.id")
     * @ApiTK\Filter(name="type")
     *
     * @ApiTK\Result("addresses", entity="App\Entity\Address")
     *
     * @SWG\Tag(name="User")
     *
     * @param Address[] $addresses
     * @return Address[]
     */
    public function getAddresses(array $addresses): array
    {
        return $addresses;
    }

    /**
     * Creates a new user.
     *
     * @Rest\Post("/v1/users")
     * @DtoMapper\View(dtoMapper="App\DtoMapper\UserV1Mapper")
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
    public function postUser(ConstraintViolationListInterface $validationErrors, User $user): User
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