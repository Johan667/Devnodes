<?php

namespace App\DataFixtures;

use App\Entity\Freelance;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * génère de fausses données pour l'entité freelance
 */
class FreelanceFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $freelancer = new Freelance();
        $freelancer
            ->setEmail('freelance@devnodes.com')
            ->setFirstname('Freelance')
            ->setLastname('Devnodes')
            ->setRoles(['ROLE_ADMIN', 'ROLE_FREELANCE'])
            ->setPassword($this->encoder->hashPassword($freelancer, 'admint'))
            ->setPrice(500)
        ;
        $manager->persist($freelancer);

        $password = $this->encoder->hashPassword(new Freelance(), 'password');
        $faker = Faker::create('fr_FR');
        for ($i=0; $i < 10; $i++) {
            $freelancer = new Freelance();
            $freelancer
                ->setEmail($faker->email())
                ->setFirstname($faker->firstName)
                ->setLastname($faker->lastName)
                ->setPicture($faker->randomElement(['img1.jpg', 'img2.jpg', 'img3.jpg', 'img4.jpg', 'img5.jpg', 'img6.png', 'img7.png']))
                ->setBiographie($faker->sentences(3, true))
                ->setPassword($password)
                ->setRoles(['ROLE_FREELANCE'])
                ->setPrice(($faker->randomDigitNotNull)*100)
                ->setTitle("Best freelancer world")
                ->setCountry($faker->country)
                ->setAddress($faker->address)
                ->setCity("Lyon")
                ->setCodePostal($faker->postcode)
            ;
            $manager->persist($freelancer);
        }

        $manager->flush();
    }
}