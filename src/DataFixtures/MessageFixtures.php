<?php

namespace App\DataFixtures;

use App\Entity\Message;
use App\Repository\MissionRepository;
use App\Repository\UserRepository;
use App\Repository\FreelanceRepository;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;

class MessageFixtures extends Fixture implements DependentFixtureInterface
{
    private MissionRepository $missionRepository;
    private UserRepository $userRepository;

    public function __construct(MissionRepository $missionRepository, UserRepository $userRepository) 
    {
        $this->missionRepository = $missionRepository;
        $this->userRepository = $userRepository;
    }

    public function load(ObjectManager $manager): void
    {
        // d'abord il faut charger la fixtures 
        // charger les missions en BDD

        $faker = Faker::create('fr_FR');
        $missions = $this->missionRepository->findAll();
        $date =new DateTime();

        // prendre quelques mission aléatoire 
        // pour chaque missions on ajoutera un ou plusieurs
        foreach ($missions as $j => $mission) {
            $sender = $mission->getSendMission();
            $receiver = $mission->getReceiveMission();
            for ($i=0; $i<10; $i++)
                {
                    
                    $message = new Message();
                    $message
                        ->setContent($faker->sentences(3, true))
                        ->setDatetime(date_modify($date, '+1 hour'))
                        ->setRecipient($faker->randomElement([$sender, $receiver]))
                        ->setSender($faker->randomElement([$sender, $receiver]))
                        ->setMission($mission)
                        ;
                    $manager->persist($message);
                }
        }
        
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            MissionFixtures::class // = 'App\DataFixtures\MissionFixtures'
        ];
    }
}