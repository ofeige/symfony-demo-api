<?php
declare(strict_types=1);

namespace App\DtoMapper;
use Api\Dto\ItemV2;
use App\Entity\Item;
use Ofeige\Rfc1Bundle\DtoMapper\MapperInterface;

/**
 * Class ItemV2Mapper
 * @package App\DtoMapper
 */
class ItemV2Mapper implements MapperInterface
{
    /**
     * @var GroupV1Mapper
     */
    private $groupV2Mapper;
    /**
     * @var AttributeV2Mapper
     */
    private $attributeV2Mapper;

    /**
     * @param GroupV1Mapper $groupV2Mapper
     * @param AttributeV2Mapper $attributeV2Mapper
     */
    public function __construct(GroupV1Mapper $groupV2Mapper, AttributeV2Mapper $attributeV2Mapper)
    {
        $this->groupV2Mapper = $groupV2Mapper;
        $this->attributeV2Mapper = $attributeV2Mapper;
    }

    /**
     * @param Item $data
     * @return ItemV2
     */
    public function map($data): ItemV2
    {
        $itemDto = new ItemV2();

        $itemDto->setId($data->getId())
            ->setName($data->getName())
            ->setGroup($this->groupV2Mapper->map($data->getGroup()));

        foreach ($data->getAttributes() as $attribute) {
            $itemDto->getAttributes()->addAttribute($this->attributeV2Mapper->map($attribute));
        }

        return $itemDto;
    }
}