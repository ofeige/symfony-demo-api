<?php

namespace App\DtoMapper;

use App\Entity\User;

use Api\Dto as Dto;
use Ofeige\Rfc1Bundle\DtoMapper\MapperInterface;

/**
 * Class UserV6Mapper
 * @package App\DtoMapper
 */
class UserV6Mapper implements MapperInterface
{
    /**
     * @var AddressV1Mapper
     */
    private $addressMapper;
    /**
     * @var ArticleV2Mapper
     */
    private $articleMapper;

    /**
     * UserV6Mapper constructor.
     * @param AddressV1Mapper $addressMapper
     * @param ArticleV2Mapper $articleMapper
     */
    public function __construct(AddressV1Mapper $addressMapper, ArticleV2Mapper $articleMapper)
    {
        $this->addressMapper = $addressMapper;
        $this->articleMapper = $articleMapper;
    }

    /**
     * @param User $data
     * @return Dto\UserV6
     */
    public function map($data)
    {
        $userDto = new Dto\UserV6();
        $userDto->setId($data->getId())
            ->setUsername($data->getUsername())
            ->setEmail($data->getEmail())
            ->setForename($data->getForename())
            ->setSurname($data->getSurname());

        foreach ($data->getAddresses() as $address) {
            $userDto->getAddresses()->addAddress($this->addressMapper->map($address));
        }

        foreach ($data->getParents() as $parent) {
            $userDto->getParents()->addUser($this->map($parent));
        }

        foreach ($data->getArticles() as $article) {
            $userDto->getArticles()->addArticle($this->articleMapper->map($article));
        }

        return $userDto;
    }
}