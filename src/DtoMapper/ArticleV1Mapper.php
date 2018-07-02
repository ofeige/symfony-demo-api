<?php
declare(strict_types=1);

namespace App\DtoMapper;
use Api\Dto\ArticleV1;
use App\Entity\Article;
use Ofeige\Rfc1Bundle\DtoMapper\MapperInterface;

/**
 * Class ArticleV1Mapper
 * @package App\DtoMapper
 */
class ArticleV1Mapper implements MapperInterface
{
    /**
     * @var UserV3Mapper
     */
    private $userMapper;
    /**
     * @var CommentV1Mapper
     */
    private $commentMapper;

    /**
     * @param UserV3Mapper $userMapper
     * @param CommentV1Mapper $commentMapper
     */
    public function __construct(UserV3Mapper $userMapper, CommentV1Mapper $commentMapper)
    {
        $this->userMapper = $userMapper;
        $this->commentMapper = $commentMapper;
    }

    /**
     * @param Article $data
     * @return ArticleV1
     */
    public function map($data)
    {
        $articleDto = new ArticleV1();

        $articleDto->setId($data->getId())
            ->setTitle($data->getTitle())
            ->setText($data->getText())
            ->setDate($data->getCreated())
            ->setUser($this->userMapper->map($data->getAuthor()));

        foreach ($data->getComments() as $comment) {
            $articleDto->addComment($this->commentMapper->map($comment));
        }

        return $articleDto;
    }
}