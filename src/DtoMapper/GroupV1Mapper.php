<?php
declare(strict_types=1);

namespace App\DtoMapper;
use Api\Dto\GroupV1;
use App\Entity\Group;
use Ofeige\Rfc1Bundle\DtoMapper\MapperInterface;

/**
 * Class GroupV1Mapper
 * @package App\DtoMapper
 */
class GroupV1Mapper implements MapperInterface
{
    /**
     * @param Group $data
     * @return GroupV1
     */
    public function map($data): GroupV1
    {
        $groupDto = new GroupV1();

        $groupDto->setName($data->getName());

        return $groupDto;
    }
}