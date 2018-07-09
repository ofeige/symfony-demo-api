<?php

namespace App\Repository;

use App\Entity\Address;
use Doctrine\ORM\EntityRepository;
use Ofeige\Rfc14Bundle\Repository\Rfc14RepositoryInterface;
use Ofeige\Rfc14Bundle\Service\Rfc14Service;

class AddressRepository extends EntityRepository implements Rfc14RepositoryInterface
{
    /**
     * @param Rfc14Service $rfc14Service
     * @return Address[]
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Ofeige\Rfc14Bundle\Exception\PaginationException
     */
    public function findByRfc14(Rfc14Service $rfc14Service): array
    {
        $qb = $this->createQueryBuilder('a');
        $qb->join('a.user', 'u')->distinct();

        $rfc14Service->applyToQueryBuilder($qb);

        return $qb->getQuery()->getResult();
    }
}