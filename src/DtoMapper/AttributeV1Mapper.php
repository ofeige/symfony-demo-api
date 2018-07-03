<?php
declare(strict_types=1);

namespace App\DtoMapper;
use Api\Dto\AttributeV1;
use App\Entity\Attribute;
use Ofeige\Rfc1Bundle\DtoMapper\MapperInterface;

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
    public function map($data)
    {
        $attributeDto = new AttributeV1();

        $attributeDto->setKey($data->getKey())
            ->setValue($data->getValue());

        return $attributeDto;
    }
}