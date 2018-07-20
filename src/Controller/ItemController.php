<?php
declare(strict_types=1);

namespace App\Controller;
use App\Entity\Item;

use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;
use Shopping\ApiFilterBundle\Annotation as Rfc14;
use Shopping\ApiDtoMapperBundle\Annotation as Rfc1;

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
     * @Rfc1\View(dtoMapper="App\DtoMapper\ItemV1Mapper")
     *
     * @Rfc14\Filter(name="name")
     *
     * @Rfc14\Pagination
     *
     * @Rfc14\Result("items", entity="App\Entity\Item")
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