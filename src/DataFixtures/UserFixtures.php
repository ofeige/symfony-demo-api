<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class UserFixtures
 * @package App\DataFixtures
 */
class UserFixtures extends Fixture
{
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
            'King Arthur'
        ];

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
            $manager->persist($user);

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
        }

        $manager->flush();
    }
}