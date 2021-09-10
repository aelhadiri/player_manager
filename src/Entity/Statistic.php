<?php

namespace App\Entity;

use App\Repository\StatisticRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=StatisticRepository::class)
 */
class Statistic
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $played_games;

    /**
     * @ORM\Column(type="integer")
     */
    private $played_minutes;

    /**
     * @ORM\Column(type="integer")
     */
    private $number_of_assists;

    /**
     * @ORM\Column(type="integer")
     */
    private $number_of_goals;

    /**
     * @ORM\ManyToOne(targetEntity=TeamPlayer::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $teamPlayer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayedGames()
    {
        return $this->played_games;
    }

    public function setPlayedGames(int $played_games): self
    {
        $this->played_games = $played_games;

        return $this;
    }

    public function getPlayedMinutes()
    {
        return $this->played_minutes;
    }

    public function setPlayedMinutes(int $played_minutes): self
    {
        $this->played_minutes = $played_minutes;

        return $this;
    }

    public function getNumberOfAssists()
    {
        return $this->number_of_assists;
    }

    public function setNumberOfAssists(int $number_of_assists): self
    {
        $this->number_of_assists = $number_of_assists;

        return $this;
    }

    public function getNumberOfGoals()
    {
        return $this->number_of_goals;
    }

    public function setNumberOfGoals(int $number_of_goals): self
    {
        $this->number_of_goals = $number_of_goals;

        return $this;
    }

    public function getTeamPlayer(): TeamPlayer
    {
        return $this->teamPlayer;
    }

    public function setTeamPlayer(TeamPlayer $teamPlayer): self
    {
        $this->teamPlayer = $teamPlayer;

        return $this;
    }

    public function getSeason(): int
    {
        return $this->teamPlayer->getSeason();
    }

    public function getPlayer(): ?Player
    {
        return $this->teamPlayer->getPlayer();
    }

}
