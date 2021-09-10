<?php

namespace App\DataFixtures;

use App\Entity\Team;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TeamFixtures extends Fixture
{
    public const TEAM_REFERENCE = 'team';

    public function load(ObjectManager $manager)
    {

        $levels = ['Ligue 1', 'Ligue 1', 'National', 'National 2', 'National 3'];

        for ($i = 1; $i <= 5; $i++) {
            for ($j = 1; $j <= 5; $j++) {
                $team = new Team();
                $team->setName(sprintf("team-%d-%d", $i, $j));
                $team->setLevel($levels[$j - 1]);
                $team->setClub($this->getReference(ClubFixtures::CLUB_REFERENCE . $i));
                $this->addReference(sprintf("%s-%d",self::TEAM_REFERENCE, ($i-1) * 5 + $j), $team);
                $manager->persist($team);
            }
        }
        $manager->flush();
    }
}

