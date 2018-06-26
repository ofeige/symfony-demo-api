<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Ofeige\Rfc14Bundle\Service\Filter;
use Ofeige\Rfc14Bundle\Service\Pagination;
use Ofeige\Rfc14Bundle\Service\Sort;

class UserRepository extends EntityRepository
{
    /**
     * @param Filter $filter
     * @param Sort $sort
     * @param Pagination $pagination
     * @return User[]
     */
    public function findByRfc14(Filter $filter, Sort $sort, Pagination $pagination): array
    {
        $qb = $this->createQueryBuilder('u');
        $qb->leftJoin('u.addresses', 'a')->distinct();

        $filter->applyToQueryBuilder($qb);
        $sort->applyToQueryBuilder($qb);
        $pagination->applyToQueryBuilder($qb);

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