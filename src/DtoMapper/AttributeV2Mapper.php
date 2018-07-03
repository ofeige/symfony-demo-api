<?php
declare(strict_types=1);

namespace App\DtoMapper;
use Api\Dto\AttributeV2;
use App\Entity\Attribute;
use Ofeige\Rfc1Bundle\DtoMapper\MapperInterface;

/**
 * Class AttributeV2Mapper
 * @package App\DtoMapper
 */
class AttributeV2Mapper implements MapperInterface
{
    /**
     * @param Attribute $data
     * @return AttributeV2
     */
    public function map($data)
    {
        $attributeDto = new AttributeV2();

        $attributeDto->setKey($data->getKey())
            ->setValue($data->getValue());

        return $attributeDto;
    }
}