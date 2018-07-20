<?php
declare(strict_types=1);

namespace App\DtoMapper;
use Api\Dto\AttributeV1;
use App\Entity\Attribute;
use Shopping\ApiDtoMapperBundle\DtoMapper\MapperInterface;

/**
 * Class AttributeV1Mapper
 * @package App\DtoMapper
 */
class AttributeV1Mapper implements MapperInterface
{
    /**
     * @param Attribute $data
     * @return AttributeV1
     */
    public function map($data): AttributeV1
    {
        $attributeDto = new AttributeV1();

        $attributeDto->setKey($data->getKey())
            ->setValue($data->getValue());

        return $attributeDto;
    }
}