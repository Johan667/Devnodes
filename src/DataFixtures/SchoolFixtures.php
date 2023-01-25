<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\School;
use App\Repository\FreelanceRepository;
use Faker\Factory as Faker;

class SchoolFixtures extends Fixture
{
    protected $freelanceRepository;

    public function __construct(FreelanceRepository $freelanceRepository)
    {
        $this->freelanceRepository = $freelanceRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $school = new School();
        $freelancers = $this->freelanceRepository->findAll();
        $badr = $freelancers[0];

        $school
            ->setTitle('best title')
            ->setDiplomaTitle('Mechatronichs')
            ->setSchoolName('Strasbourg University')
            ->setCity('Strasbourg')
            ->setCodePostal('67000')
            ->setCountry('France')
            ->setFreelance($badr)
        ;
        $manager->persist($school);

        $faker = Faker::create('fr_FR');
        for ($i=0; $i < 500; $i++) {
            $freelancer = $freelancers[$i+1];
            $school
                ->setTitle($faker->title)
                ->setDiplomaTitle($faker->randomElement($array = array('engineering', 'informatique', 'web', 'developpement', 'mobile')))
                ->setSchoolName($faker->words(3, true))
                ->setCity($faker->city)
                ->setCodePostal($faker->postcode)
                ->setCountry($faker->country)
                ->setFreelance($freelancer)
            ;
            $manager->persist($school);
        }

        $manager->flush();
    }
}
