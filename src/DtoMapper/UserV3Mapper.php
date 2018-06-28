<?php

namespace App\DtoMapper;

use App\Entity\User;

use Api\Dto as Dto;
use Ofeige\Rfc1Bundle\DtoMapper\MapperInterface;

/**
 * Class UserV3Mapper
 * @package App\DtoMapper
 */
class UserV3Mapper implements MapperInterface
{
    /**
     * @var AddressV1Mapper
     */
    private $addressMapper;

    /**
     * UserV3Mapper constructor.
     * @param AddressV1Mapper $addressMapper
     */
    public function __construct(AddressV1Mapper $addressMapper)
    {
        $this->addressMapper = $addressMapper;
    }

    /**
     * @param User $data
     * @return Dto\UserV3
     */
    public function map($data)
    {
        $userDto = new Dto\UserV3();
        $userDto->setId($data->getId())
            ->setUsername($data->getUsername())
            ->setEmail($data->getEmail())
            ->setForename($data->getForename())
            ->setSurname($data->getSurname());

        foreach ($data->getAddresses() as $address) {
            $userDto->addAddress($this->addressMapper->map($address));
        }

        return $userDto;
    }
}