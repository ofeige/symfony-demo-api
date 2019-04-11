<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Shopping\ApiTKUrlBundle\Exception\PaginationException;
use Shopping\ApiTKUrlBundle\Repository\ApiToolkitRepository;
use Shopping\ApiTKUrlBundle\Service\ApiService;
use Symfony\Bridge\Doctrine\RegistryInterface;

class UserRepository extends ApiToolkitRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param ApiService $apiService
     *
     * @return User[]
     * @throws NonUniqueResultException
     * @throws PaginationException
     */
    public function findByRequest(ApiService $apiService): array
    {
        $qb = $this->createQueryBuilder('u');
        $qb->leftJoin('u.addresses', 'a');

        $apiService->applyToQueryBuilder($qb);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param User $user
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function persist(User $user): void
    {
        if ($user->getPlainPassword() !== null) {
            $user->setPasswordSalt(uniqid())
                ->setPasswordHash(md5($user->getPlainPassword() . $user->getPasswordSalt()));
        }

        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush($user);
    }
}
