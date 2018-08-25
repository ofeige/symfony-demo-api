<?php

namespace App\Repository;

use App\Entity\Address;
use Shopping\ApiTKUrlBundle\Repository\ApiToolkitRepository;
use Shopping\ApiTKUrlBundle\Service\ApiService;

class AddressRepository extends ApiToolkitRepository
{
    /**
     * @param ApiService $apiService
     *
     * @return Address[]
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Shopping\ApiTKUrlBundle\Exception\PaginationException
     */
    public function findByRequest(ApiService $apiService): array
    {
        $qb = $this->createQueryBuilder('a');
        $qb->join('a.user', 'u')->distinct();

        $apiService->applyToQueryBuilder($qb);

        return $qb->getQuery()->getResult();
    }
}