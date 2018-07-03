<?php

namespace App\DtoMapper;

use App\Entity\User;

use Api\Dto as Dto;
use Ofeige\Rfc1Bundle\DtoMapper\MapperInterface;

/**
 * Class UserV4Mapper
 * @package App\DtoMapper
 */
class UserV4Mapper implements MapperInterface
{
    /**
     * @var AddressV1Mapper
     */
    private $addressMapper;

    /**
     * UserV4Mapper constructor.
     * @param AddressV1Mapper $addressMapper
     */
    public function __construct(AddressV1Mapper $addressMapper)
    {
        $this->addressMapper = $addressMapper;
    }

    /**
     * @param User $data
     * @return Dto\UserV4
     */
    public function map($data): Dto\UserV4
    {
        $userDto = new Dto\UserV4();
        $userDto->setId($data->getId())
            ->setUsername($data->getUsername())
            ->setEmail($data->getEmail())
            ->setForename($data->getForename())
            ->setSurname($data->getSurname());

        foreach ($data->getAddresses() as $address) {
            $userDto->getAddresses()->addAddress($this->addressMapper->map($address));
        }

        return $userDto;
    }
}