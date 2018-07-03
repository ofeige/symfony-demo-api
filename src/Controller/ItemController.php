<?php
declare(strict_types=1);

namespace App\Controller;
use App\Entity\Item;
use Nelmio\ApiDocBundle\Annotation\Model;

use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;
use Ofeige\Rfc14Bundle\Annotation as Rfc14;
use Ofeige\Rfc1Bundle\Annotation as Rfc1;

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
     * @Rfc14\Filter(name="group", queryBuilderName="g.name")
     *
     * @Rfc14\Pagination
     *
     * @Rfc14\Result("items", entity="App\Entity\Item")
     *
     * @SWG\Tag(name="Item")
     * @SWG\Response(
     *     response=200,
     *     description="List of items matching the filter",
     *     @SWG\Schema(type="array", @SWG\Items(ref=@Model(type="Api\Dto\ItemV1")))
     * )
     *
     * @param Item[] $items
     * @return Item[]
     */
    public function itemsV1(array $items)
    {
        return $items;
    }

    /**
     * Returns the items in the system.
     *
     * @Rest\Get("/v2/items")
     * @Rfc1\View(dtoMapper="App\DtoMapper\ItemV2Mapper")
     *
     * @Rfc14\Filter(name="name")
     * @Rfc14\Filter(name="group", queryBuilderName="g.name")
     *
     * @Rfc14\Pagination
     *
     * @Rfc14\Result("items", entity="App\Entity\Item")
     *
     * @SWG\Tag(name="Item")
     * @SWG\Response(
     *     response=200,
     *     description="List of items matching the filter",
     *     @SWG\Schema(type="array", @SWG\Items(ref=@Model(type="Api\Dto\ItemV2")))
     * )
     *
     * @param Item[] $items
     * @return Item[]
     */
    public function itemsV2(array $items)
    {
        return $items;
    }
}