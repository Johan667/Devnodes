<?php

namespace App\DataFixtures;

use App\Repository\MissionRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MessageFixtures extends Fixture implements DependentFixtureInterface
{
    private MissionRepository $missionRepository; // propriété

    public function __construct(MissionRepository $missionRepository) 
    {
        $this->missionRepository = $missionRepository;
    }

    public function load(ObjectManager $manager): void
    {
        // d'abord il faut charger la fixtures 
        // charger les missions en BDD
        $missions = $this->missionRepository->findAll();
        // prendre quelques mission aléatoire 
        // pour chaque missions on ajoutera un ou plusieurs
        foreach ($missions as $mission) 
        {
           dump($mission->getReceiveMission()->getFirstname());
           die;
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