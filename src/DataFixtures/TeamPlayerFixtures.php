<?php

namespace App\DataFixtures;

use App\Entity\Player;
use App\Entity\Statistic;
use App\Entity\TeamPlayer;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class TeamPlayerFixtures extends Fixture
{
    public const TEAM_PLAYER_REFERENCE = 'team-player-';

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 1; $i <= 500; $i++) {
            $player = new Player();
            $player->setEmail($faker->email());
            $player->setFirstName($faker->firstName());
            $player->setLastName($faker->lastName());
            $player->setBirthAt(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-30 years', '-20 years')));
            $manager->persist($player);


            for ($j = 1; $j <= 3; $j++) {
                $team_player = new TeamPlayer();
                $team_player->setSeason(2019 + ($j-1));
                $team_player->setTeam($this->getReference(TeamFixtures::TEAM_REFERENCE . '-' . (($i%25)+1)));
                $team_player->setPlayer($player);
                $manager->persist($team_player);

                $statistic = new Statistic();
                $playedGames = $faker->numberBetween(4, 38);
                $statistic->setPlayedGames($playedGames);
                $statistic->setPlayedMinutes($faker->numberBetween($playedGames, $playedGames * 90));
                $statistic->setNumberOfAssists($faker->numberBetween(0, 20));
                $statistic->setNumberOfGoals($faker->numberBetween(0, 30));
                $statistic->setTeamPlayer($team_player);
                $manager->persist($statistic);
            }

        }
        $manager->flush();
    }
}

