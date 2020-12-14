<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;


class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    private $slugify;
    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }

    public function getDependencies()
    {
        return [SeasonFixtures::class];
    }

    public function load(ObjectManager $manager)
    {
        $faker  =  Faker\Factory::create('fr_FR');
        for ($i=1; $i<200 ; $i++) {
            $episode = new Episode();
            $episode->setnumber($i%10 + 1);
            $episode->setTitle($faker->sentence($nbWords = 3, $variableNbWords = true));
            $slug = $this->slugify->generate($episode->getTitle());
            $episode->setSlug($slug);
            $episode->setSynopsis($faker->text);
            $episode->setSeason($this->getReference('season_'. floor($i/10)));
            $manager->persist($episode);
            $this->addReference('episode_' . $i, $episode);
        }
        $manager->flush();
    }
}
