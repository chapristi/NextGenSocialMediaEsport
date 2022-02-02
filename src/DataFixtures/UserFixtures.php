<?php


namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{

    public function load(ObjectManager $manager):void
    {
        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setEmail("mail${$i}@gmail.com");
            $user->setPassword("0000");
            $user->setIsVerified(true);
            $manager->persist($user);
        }
        $manager->flush();


    }
}