<?php

namespace App\DataFixtures;

use App\Entity\Level;
use App\Entity\Season;
use App\Entity\TeamPlayer;
use App\Factory\PlayerFactory;
use App\Factory\TeamFactory;
use App\Factory\UserFactory;
use App\Repository\PlayerRepository;
use App\Repository\TeamRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    private $levels;
    private $seasons;
    private $userRepository;
    private $teamRepository;
    private $playerRepository;

    public function __construct(UserRepository $userRepository, TeamRepository $teamRepository, PlayerRepository $playerRepository)
    {
        $this->userRepository = $userRepository;
        $this->teamRepository = $teamRepository;
        $this->playerRepository = $playerRepository;
    }

    public function load(ObjectManager $manager)
    {
        $this->populateLevelEntity($manager);
        $this->populateSeasonEntity($manager);

        $users = UserFactory::createMany(5);

        TeamFactory::createMany(20);
        $this->updateTeams($manager, $users);

        PlayerFactory::createMany(200);
        $this->updatePlayerTeams($manager);
    }

    protected function populateLevelEntity(ObjectManager $manager)
    {
        $level_names = ['cadet', 'junior', 'senior'];
        foreach ($level_names as $position => $level_name) {
            $level = new Level();
            $level->setName($level_name);
            $level->setPosition($position);
            $manager->persist($level);
            $this->levels[] = $level;
        }
    }

    protected function populateSeasonEntity(ObjectManager $manager)
    {
        $season_names = ['2018-2019', '2019-2020', '2020-2021', '2021-2022'];
        foreach ($season_names as $position => $season_name) {
            $season = new Season();
            $season->setName($season_name);
            $season->setPosition($position);
            $manager->persist($season);
            $this->seasons[] = $season;
        }
    }

    protected function updateTeams(ObjectManager $manager, $users)
    {
        $teams = $this->teamRepository->findBy(['level' => null]);
        foreach ($teams as $team) {

            $key = array_rand($this->levels);
            $team->setLevel($this->levels[$key]);
            $team->setOwner($users[array_rand($users)]->object());
            $manager->persist($team);
        }
        $manager->flush();
    }

    protected function updatePlayerTeams(ObjectManager $manager)
    {
        $players = $this->playerRepository->findBy([], [], 200);
        $teams = $this->teamRepository->findBy([], [], 8);
        $number_of_players = [20, 30, 15, 25, 40, 18, 30, 22];
        $player_partition = [];
        $season_partition = [];
        foreach($number_of_players as $k => $number_of_player){
            $player_partition[$k] = array_splice($players,0, $number_of_player);
            $key = array_rand($this->seasons);
            $season_partition[$k] = $this->seasons[$key];
        }

        foreach ($teams as $i => $team) {

            foreach($player_partition[$i] as $player) {
                $team_player = new TeamPlayer();
                $team_player->setSeason($season_partition[$i]);
                $team_player->setTeam($team);
                $team_player->setPlayer($player);
                $manager->persist($team_player);
            }
        }
        $manager->flush();
    }
}
