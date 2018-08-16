<?php
declare(strict_types=1);
namespace App\DtoMapper;

use App\Entity\User;

use Api\Dto as Dto;
use Shopping\ApiTKDtoMapperBundle\DtoMapper\MapperInterface;

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
    public function map($data): Dto\UserV1
    {
        $userDto = new Dto\UserV1();
        $userDto->setId($data->getId())
            ->setUsername($data->getUsername())
            ->setEmail($data->getEmail());

        return $userDto;
    }
}