<?php

namespace App\DtoMapper;

use App\Entity\User;

use App\Dto as Dto;
use Ofeige\Rfc1Bundle\DtoMapper\MapperInterface;

/**
 * Class UserV2Mapper
 * @package App\DtoMapper
 */
class UserV2Mapper implements MapperInterface
{
    /**
     * @param User $data
     * @return Dto\UserV2
     */
    public function map($data)
    {
        $userDto = new Dto\UserV2();
        $userDto->setId($data->getId())
            ->setUsername($data->getUsername())
            ->setEmail($data->getEmail())
            ->setForename($data->getForename())
            ->setSurname($data->getSurname());

        return $userDto;
    }
}