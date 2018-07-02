<?php
declare(strict_types=1);

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Comment
 * @package App\Entity
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity
 */
class Comment
{
    /**
     * @var int
     *
     * @ORM\Column(name="comment_id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="comment_user_id", referencedColumnName="user_id")
     */
    private $author;

    /**
     * @var Article
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Article", inversedBy="comments")
     * @ORM\JoinColumn(name="comment_article_id", referencedColumnName="article_id")
     */
    private $article;

    /**
     * @var string
     *
     * @ORM\Column(name="comment_text", type="string", length=100000)
     */
    private $text;

    /**
     * @var User[]
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\User")
     * @ORM\JoinTable(name="comments_likes",
     *     joinColumns={@ORM\JoinColumn(name="comment_id", referencedColumnName="comment_id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="user_id")}
     * )
     */
    private $likes;

    public function __construct()
    {
        $this->likes = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Comment
     */
    public function setId(int $id): Comment
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return User
     */
    public function getAuthor(): User
    {
        return $this->author;
    }

    /**
     * @param User $author
     * @return Comment
     */
    public function setAuthor(User $author): Comment
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return Article
     */
    public function getArticle(): Article
    {
        return $this->article;
    }

    /**
     * @param Article $article
     * @return Comment
     */
    public function setArticle(Article $article): Comment
    {
        $this->article = $article;
        return $this;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return Comment
     */
    public function setText(string $text): Comment
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return User[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    /**
     * @param User[] $likes
     * @return Comment
     */
    public function setLikes(Collection $likes): Comment
    {
        $this->likes = $likes;
        return $this;
    }

    /**
     * @param User $like
     * @return Comment
     */
    public function addLike(User $like): Comment
    {
        $this->likes[] = $like;
        return $this;
    }
}