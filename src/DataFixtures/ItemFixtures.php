<?php

namespace App\DataFixtures;

use App\Entity\Attribute;
use App\Entity\Group;
use App\Entity\Item;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use KnpU\LoremIpsumBundle\KnpUIpsum;

/**
 * Class ItemFixtures
 * @package App\DataFixtures
 */
class ItemFixtures extends Fixture
{
    /**
     * @var KnpUIpsum
     */
    private $ipsum;

    public function __construct(KnpUIpsum $ipsum)
    {
        $this->ipsum = $ipsum;
    }

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $groups = [];
        for ($i = 0; $i < 10; $i++) {
            $group = new Group();
            $group->setName($this->ipsum->getWords(2));

            $manager->persist($group);

            $groups[] = $group;
        }

        for ($i = 0; $i < 100; $i++) {
            $item = new Item();
            $item->setName($this->ipsum->getWords(2))
                ->setGroup($groups[$i % count($groups)]);

            $manager->persist($item);

            for ($j = 0; $j < ($i + 1); $j++) {
                $attribute = new Attribute();
                $attribute->setKey($this->ipsum->getWords(1))
                    ->setValue($j)
                    ->setItem($item);

                $manager->persist($attribute);
            }
        }

        $manager->flush();
    }
}