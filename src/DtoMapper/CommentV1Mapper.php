<?php
declare(strict_types=1);

namespace App\DtoMapper;
use Api\Dto\CommentV1;
use App\Entity\Comment;
use Ofeige\Rfc1Bundle\DtoMapper\MapperInterface;

/**
 * Class CommentV1Mapper
 * @package App\DtoMapper
 */
class CommentV1Mapper implements MapperInterface
{
    /**
     * @var UserV2Mapper
     */
    private $userV2Mapper;
    /**
     * @var UserV1Mapper
     */
    private $userV1Mapper;

    /**
     * @param UserV2Mapper $userV2Mapper
     * @param UserV1Mapper $userV1Mapper
     */
    public function __construct(UserV2Mapper $userV2Mapper, UserV1Mapper $userV1Mapper)
    {
        $this->userV2Mapper = $userV2Mapper;
        $this->userV1Mapper = $userV1Mapper;
    }

    /**
     * @param Comment $data
     * @return CommentV1
     */
    public function map($data)
    {
        $commentDto = new CommentV1();

        $commentDto->setId($data->getId())
            ->setUser($this->userV2Mapper->map($data->getAuthor()))
            ->setText($data->getText());

        foreach ($data->getLikes() as $like) {
            $commentDto->addLike($this->userV1Mapper->map($like));
        }

        return $commentDto;
    }
}