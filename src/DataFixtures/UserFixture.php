<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user
            ->setEmail('kebsibadr@gmail.com')
            ->setFirstname('Badr')
            ->setLastname('Kebsi')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->encoder->hashPassword($user, 'admint'))
            ->setPhone('0769553504')
            ->setDescription('SuprBadr')
        ;
        $manager->persist($user);

        $password = $this->encoder->hashPassword(new user(), 'password');
        $faker = Faker::create('fr_FR');
        for ($i=0; $i < 500; $i++) {
            $user = new User();
            $user
                ->setEmail($faker->email())
                ->setFirstname($faker->firstName)
                ->setLastname($faker->lastName)
                ->setPhone($faker->phoneNumber)
                ->setDescription($faker->sentences(3, true))
                ->setPassword($password)
                ;
            $manager->persist($user);
        }

        $manager->flush();
    }
}
