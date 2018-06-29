<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Ofeige\Rfc14Bundle\Repository\Rfc14RepositoryInterface;
use Ofeige\Rfc14Bundle\Service\Rfc14Service;

class UserRepository extends EntityRepository implements Rfc14RepositoryInterface
{
    /**
     * @param Rfc14Service $rfc14Service
     * @return User[]
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Ofeige\Rfc14Bundle\Exception\PaginationException
     */
    public function findByRfc14(Rfc14Service $rfc14Service): array
    {
        $qb = $this->createQueryBuilder('u');
        $qb->leftJoin('u.addresses', 'a')->distinct();

        $rfc14Service->applyToQueryBuilder($qb);

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