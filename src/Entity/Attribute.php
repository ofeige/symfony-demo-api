<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Attribute
 * @package App\Entity
 *
 * @ORM\Table(name="item_attribute")
 * @ORM\Entity
 */
class Attribute
{
    /**
     * @var int
     *
     * @ORM\Column(name="item_attribute_id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="item_attribute_key", type="string", length=255)
     */
    private $key;

    /**
     * @var string
     *
     * @ORM\Column(name="item_attribute_value", type="string", length=255)
     */
    private $value;

    /**
     * @var Item
     * @ORM\ManyToOne(targetEntity="App\Entity\Item", inversedBy="attributes")
     * @ORM\JoinColumn(name="item_attribute_item_id", referencedColumnName="item_id")
     */
    private $item;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Attribute
     */
    public function setId(int $id): Attribute
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     * @return Attribute
     */
    public function setKey(string $key): Attribute
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return Attribute
     */
    public function setValue(string $value): Attribute
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return Item
     */
    public function getItem(): Item
    {
        return $this->item;
    }

    /**
     * @param Item $item
     * @return Attribute
     */
    public function setItem(Item $item): Attribute
    {
        $this->item = $item;
        return $this;
    }
}