<?php

namespace App\Repository;

use App\Entity\Item;
use Doctrine\ORM\EntityRepository;
use Ofeige\Rfc14Bundle\Repository\Rfc14RepositoryInterface;
use Ofeige\Rfc14Bundle\Service\Rfc14Service;

class ItemRepository extends EntityRepository implements Rfc14RepositoryInterface
{
    /**
     * @param Rfc14Service $rfc14Service
     * @return Item[]
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Ofeige\Rfc14Bundle\Exception\PaginationException
     */
    public function findByRfc14(Rfc14Service $rfc14Service): array
    {
        $qb = $this->createQueryBuilder('i');
        $qb->join('i.group', 'g')
            ->leftJoin('i.attributes', 'a')
            ->distinct();

        $rfc14Service->applyToQueryBuilder($qb);

        return $qb->getQuery()->getResult();
    }
}