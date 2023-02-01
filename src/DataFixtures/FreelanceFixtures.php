<?php

namespace App\DataFixtures;

use App\Entity\Freelance;
use App\Entity\SpokenLanguage;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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
            ->setEmail('kebsibadr123@gmail.com')
            ->setFirstname('FreelanceBadr')
            ->setLastname('al-Kebsi')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->encoder->hashPassword($freelancer, 'admint'))
            ->setPhone('0769553504')
            ->setDescription('SuperBadr')
            ->setPrice(500)
            ->setTitle("Best freelancer world")
            ->setCountry('Yemen')
            ->setAddress('Somewhere')
            ->setCity("Lyon")
            ->setCodePostal('67000')
        ;
        $manager->persist($freelancer);

        for($j=0; $j < 3; $j++) {
            $faker = Faker::create('fr_FR');
            $spokenLang = new SpokenLanguage;
            $spokenLang
                ->setNameLanguage($faker->randomElement(['English','French', 'Arabic']))
                ->addFreelanceSpokenLanguage($freelancer)
                ;
            $manager->persist($spokenLang);
        }

        $password = $this->encoder->hashPassword(new Freelance(), 'password');
        $faker = Faker::create('fr_FR');
        for ($i=0; $i < 500; $i++) {
            $freelancer = new Freelance();
            $freelancer
                ->setEmail($faker->email())
                ->setFirstname($faker->firstName)
                ->setLastname($faker->lastName)
                ->setPhone($faker->phoneNumber)
                ->setDescription($faker->sentences(3, true))
                ->setPassword($password)
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