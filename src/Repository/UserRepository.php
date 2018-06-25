<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;
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
}