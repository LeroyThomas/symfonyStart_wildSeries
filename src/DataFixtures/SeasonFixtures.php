<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i=0; $i<50; $i++) {
            $season = new Season();
            $season
                ->setNumber($i +1)
                ->setDescription($faker->text)
                ->setYear($faker->year($max = 'now'))
                ->setProgram($this->getReference('program_'. floor($i/10)))
                ;
            $manager->persist($season);
            $this->addReference('season_'. $i, $season);
        }

        $manager->flush();
    }
}
