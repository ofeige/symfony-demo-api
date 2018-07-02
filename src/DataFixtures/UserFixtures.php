<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use KnpU\LoremIpsumBundle\KnpUIpsum;

/**
 * Class UserFixtures
 * @package App\DataFixtures
 */
class UserFixtures extends Fixture
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
        $users = [
            'Some Guy',
            'Some Gril',
            'Awesome Peperoni',
            'Arthas Menethil',
            'King Arthur',
            'Old Guy',
            'Old Gril',
            'Ash Ketchum',
            'Taichi Yagami',
            'Ryuuji Takasu',
            'Taiga Aisaka'
        ];

        $savedUsers = [];
        foreach ($users as $index => $name) {
            $parts = explode(' ', $name);

            $salt = uniqid();

            $user = new User();
            $user->setUsername(strtolower($parts[0]) . '.' . strtolower($parts[1]))
                ->setEmail(strtolower($parts[0]) . '.' . strtolower($parts[1]) . '@demo.test')
                ->setForename($parts[0])
                ->setSurname($parts[1])
                ->setPasswordHash(md5($parts[0][0] . $parts[1][0] . $salt))
                ->setPasswordSalt($salt)
                ->setActive($index > 1 ? User::ACTIVE_YES : User::ACTIVE_NO)
                ->setCreated((new \DateTime())->sub(new \DateInterval('P' . ($index + 1) . 'W')));

            if ($index >= 2) {
                $user->addParent($savedUsers[floor(($index - 2) / 2) * 2])
                    ->addParent($savedUsers[floor(($index - 2) / 2) * 2 + 1]);
            }

            $manager->persist($user);
            $savedUsers[] = $user;

            $deliveryAddress = new Address();
            $deliveryAddress->setUser($user)
                ->setType(Address::TYPE_DELIVERY)
                ->setName($name)
                ->setStreet(substr($parts[0], 0, 3) . 'straße ' . pow($index + 1, 3))
                ->setZipCode(($index % 3) . '2345')
                ->setCity(substr($parts[1], 0, 3) . 'hausen')
                ->setCountry($index > 3 ? 'AT' : 'DE');
            $manager->persist($deliveryAddress);

            if ($index % 2) {
                $billingAddress = new Address();
                $billingAddress->setUser($user)
                    ->setType(Address::TYPE_BILLING)
                    ->setName($parts[0][0] . $parts[1][0] . ' GmbH')
                    ->setStreet(substr($parts[0], 0, 3) . 'straße ' . (pow($index + 1, 3) + 1))
                    ->setZipCode(($index % 3) . '2345')
                    ->setCity(substr($parts[1], 0, 3) . 'hausen')
                    ->setCountry($index > 3 ? 'AT' : 'DE');
                $manager->persist($billingAddress);
            }
            
            //Articles
            for ($i = 0; $i < $index * 3; $i++) {
                $article = new Article();
                $article->setCreated(new \DateTime())
                    ->setTitle(substr($this->ipsum->getSentences(), 0, 255))
                    ->setText($this->ipsum->getParagraphs(3))
                    ->setAuthor($user);
                $manager->persist($article);

                foreach ($savedUsers as $commentIndex => $commentUser) {
                    $comment = new Comment();
                    $comment->setAuthor($commentUser)
                        ->setText($this->ipsum->getParagraphs(1))
                        ->setArticle($article);

                    foreach ($savedUsers as $likeUser) {
                        $comment->addLike($likeUser);
                    }

                    $manager->persist($comment);
                }
            }
        }

        $manager->flush();
    }
}