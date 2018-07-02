<?php
declare(strict_types=1);

namespace App\DtoMapper;
use Api\Dto\ArticleV2;
use App\Entity\Article;
use Ofeige\Rfc1Bundle\DtoMapper\MapperInterface;

/**
 * Class ArticleV2Mapper
 * @package App\DtoMapper
 */
class ArticleV2Mapper implements MapperInterface
{
    /**
     * @var UserV3Mapper
     */
    private $userMapper;
    /**
     * @var CommentV2Mapper
     */
    private $commentMapper;

    /**
     * @param UserV3Mapper $userMapper
     * @param CommentV2Mapper $commentMapper
     */
    public function __construct(UserV3Mapper $userMapper, CommentV2Mapper $commentMapper)
    {
        $this->userMapper = $userMapper;
        $this->commentMapper = $commentMapper;
    }

    /**
     * @param Article $data
     * @return ArticleV2
     */
    public function map($data)
    {
        $articleDto = new ArticleV2();

        $articleDto->setId($data->getId())
            ->setTitle($data->getTitle())
            ->setText($data->getText())
            ->setDate($data->getCreated())
            ->setUser($this->userMapper->map($data->getAuthor()));

        foreach ($data->getComments() as $comment) {
            $articleDto->getComments()->addComment($this->commentMapper->map($comment));
        }

        return $articleDto;
    }
}