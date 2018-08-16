<?php
declare(strict_types=1);

namespace App\Controller;
use App\Entity\Item;

use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;
use Shopping\ApiTKUrlBundle\Annotation as ApiTK;
use Shopping\ApiTKDtoMapperBundle\Annotation as DtoMapper;

/**
 * Class ItemController
 * @package App\Controller
 */
class ItemController
{

    /**
     * Returns the items in the system.
     *
     * @Rest\Get("/v1/items")
     * @DtoMapper\View(dtoMapper="App\DtoMapper\ItemV1Mapper")
     *
     * @ApiTK\Filter(name="name")
     *
     * @ApiTK\Pagination
     *
     * @ApiTK\Result("items", entity="App\Entity\Item")
     *
     * @SWG\Tag(name="Item")
     *
     * @param Item[] $items
     * @return Item[]
     */
    public function itemsV1(array $items): array
    {
        return $items;
    }
}