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
            ->setEmail('client@devnodes.com')
            ->setFirstname('Saloui')
            ->setLastname('Martin')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->encoder->hashPassword($user, 'admint'))
        ;
        $manager->persist($user);

        $password = $this->encoder->hashPassword(new user(), 'password');
        $faker = Faker::create('fr_FR');
        for ($i=0; $i < 10; $i++) {
            $user = new User();
            $user
                ->setEmail($faker->email())
                ->setFirstname($faker->firstName)
                ->setLastname($faker->lastName)
                ->setPassword($password)
            ;
            $manager->persist($user);
        }

        $manager->flush();
    }
}