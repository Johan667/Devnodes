<?php

namespace App\DataFixtures;

use App\Entity\Mission;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Repository\UserRepository;
use App\Repository\FreelanceRepository;
use Faker\Factory as Faker;


class MissionFixtures extends Fixture
{

    protected UserRepository $userRepository;
    protected FreelanceRepository $freelanceRepository;

    public function __construct(UserRepository $userRepository, FreelanceRepository $freelanceRepository)
    {
        $this->userRepository = $userRepository;
        $this->freelanceRepository = $freelanceRepository;
    }


    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create('fr_FR');
        $users = $this->userRepository->findAll();
        $freelancers = $this->freelanceRepository->findAll();
        $usersLength = count($users)-1;
        $freelancersLength = count($users)-1;

        for ($i=0; $i < 1000; $i++) {
            $userRandomKey = rand(0, $usersLength);
            $freelancersRandomKey = rand(0, $freelancersLength);

            $user = $users[$userRandomKey];
            $freelancer = $freelancers[$freelancersRandomKey];

            $mission = new Mission();
            $mission
                ->setSendMission($user)
                ->setReceiveMission($freelancer)
                ->setTitle($faker->words(3, true))
                ->setObject($faker->words(5, true))
                ->setStartDate($faker->dateTime)
                ->setDescription($faker->sentences(4, true))
                ->setFrenquency("whatever you want it to be LOL")
                ;
            $manager->persist($mission);
        }

        $manager->flush();
    }
}
