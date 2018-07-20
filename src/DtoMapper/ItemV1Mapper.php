<?php
declare(strict_types=1);

namespace App\DtoMapper;
use Api\Dto\ItemV1;
use App\Entity\Item;
use Shopping\ApiDtoMapperBundle\DtoMapper\MapperInterface;

/**
 * Class ItemV1Mapper
 * @package App\DtoMapper
 */
class ItemV1Mapper implements MapperInterface
{
    /**
     * @var GroupV1Mapper
     */
    private $groupV1Mapper;
    /**
     * @var AttributeV1Mapper
     */
    private $attributeV1Mapper;

    /**
     * @param GroupV1Mapper $groupV1Mapper
     * @param AttributeV1Mapper $attributeV1Mapper
     */
    public function __construct(GroupV1Mapper $groupV1Mapper, AttributeV1Mapper $attributeV1Mapper)
    {
        $this->groupV1Mapper = $groupV1Mapper;
        $this->attributeV1Mapper = $attributeV1Mapper;
    }

    /**
     * @param Item $data
     * @return ItemV1
     */
    public function map($data): ItemV1
    {
        $itemDto = new ItemV1();

        $itemDto->setId($data->getId())
            ->setName($data->getName())
            ->setGroup($this->groupV1Mapper->map($data->getGroup()));

        foreach ($data->getAttributes() as $attribute) {
            $itemDto->addAttribute($this->attributeV1Mapper->map($attribute));
        }

        return $itemDto;
    }
}