<?php

namespace App\DtoMapper;

use App\Entity\User;

use App\Dto as Dto;
use Ofeige\Rfc1Bundle\DtoMapper\MapperInterface;

/**
 * Class UserV1Mapper
 * @package App\DtoMapper
 */
class UserV1Mapper implements MapperInterface
{
    /**
     * @param User $data
     * @return Dto\UserV1
     */
    public function map($data)
    {
        $userDto = new Dto\UserV1();
        $userDto->setId($data->getId())
            ->setUsername($data->getUsername())
            ->setEmail($data->getEmail());

        return $userDto;
    }
}