<?php


namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{


    public function __construct
    (
        private UserPasswordHasherInterface $passwordHasher
    )
    {}
    public function load(ObjectManager $manager):void
    {
        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setEmail("mail${$i}@gmail.com");
            $user->setPassword($this->passwordHasher->hashPassword($user, '0000'));
            $user->setIsVerified(true);
            $manager->persist($user);
        }
        $manager->flush();


    }
}