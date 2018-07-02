<?php

namespace App\DtoMapper;

use App\Entity\User;

use Api\Dto as Dto;
use Ofeige\Rfc1Bundle\DtoMapper\MapperInterface;

/**
 * Class UserV5Mapper
 * @package App\DtoMapper
 */
class UserV5Mapper implements MapperInterface
{
    /**
     * @var AddressV1Mapper
     */
    private $addressMapper;
    /**
     * @var ArticleV1Mapper
     */
    private $articleMapper;

    /**
     * UserV5Mapper constructor.
     * @param AddressV1Mapper $addressMapper
     * @param ArticleV1Mapper $articleMapper
     */
    public function __construct(AddressV1Mapper $addressMapper, ArticleV1Mapper $articleMapper)
    {
        $this->addressMapper = $addressMapper;
        $this->articleMapper = $articleMapper;
    }

    /**
     * @param User $data
     * @return Dto\UserV5
     */
    public function map($data)
    {
        $userDto = new Dto\UserV5();
        $userDto->setId($data->getId())
            ->setUsername($data->getUsername())
            ->setEmail($data->getEmail())
            ->setForename($data->getForename())
            ->setSurname($data->getSurname());

        foreach ($data->getAddresses() as $address) {
            $userDto->addAddress($this->addressMapper->map($address));
        }

        foreach ($data->getParents() as $parent) {
            $userDto->addParent($this->map($parent));
        }

        foreach ($data->getArticles() as $article) {
            $userDto->addArticle($this->articleMapper->map($article));
        }

        return $userDto;
    }
}