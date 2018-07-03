<?php

namespace App\DtoMapper;

use App\Entity\Address;

use Api\Dto as Dto;
use Ofeige\Rfc1Bundle\DtoMapper\MapperInterface;

/**
 * Class AddressV1Mapper
 * @package App\DtoMapper
 */
class AddressV1Mapper implements MapperInterface
{
    /**
     * @param Address $data
     * @return Dto\AddressV1
     */
    public function map($data): Dto\AddressV1
    {
        $address = new Dto\AddressV1();
        $address->setType($data->getType())
            ->setName($data->getName())
            ->setStreet($data->getStreet())
            ->setZipCode($data->getZipCode())
            ->setCity($data->getCity())
            ->setCountry($data->getCountry());

        return $address;
    }
}