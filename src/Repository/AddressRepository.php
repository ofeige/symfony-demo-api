<?php

namespace App\Repository;

use App\Entity\Address;
use Doctrine\ORM\NonUniqueResultException;
use Shopping\ApiTKUrlBundle\Exception\PaginationException;
use Shopping\ApiTKUrlBundle\Repository\ApiToolkitRepository;
use Shopping\ApiTKUrlBundle\Service\ApiService;
use Symfony\Bridge\Doctrine\RegistryInterface;

class AddressRepository extends ApiToolkitRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Address::class);
    }

    /**
     * @param ApiService $apiService
     *
     * @return Address[]
     * @throws NonUniqueResultException
     * @throws PaginationException
     */
    public function findByRequest(ApiService $apiService): array
    {
        $qb = $this->createQueryBuilder('a');
        $qb->join('a.user', 'u')->distinct();

        $apiService->applyToQueryBuilder($qb);

        return $qb->getQuery()->getResult();
    }
}
