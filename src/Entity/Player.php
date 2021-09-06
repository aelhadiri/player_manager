<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=PlayerRepository::class)
 */
class Player
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $firstName;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $birthAt;

    /**
     * @ORM\OneToMany(targetEntity=TeamPlayer::class, mappedBy="player", orphanRemoval=true)
     */
    private $teamPlayers;

    /**
     * @ORM\OneToMany(targetEntity=Statistic::class, mappedBy="player", orphanRemoval=true)
     */
    private $statistics;

    public function __construct()
    {
        $this->teamPlayers = new ArrayCollection();
        $this->statistics = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getBirthAt(): ?\DateTimeImmutable
    {
        return $this->birthAt;
    }

    public function setBirthAt(\DateTimeImmutable $birthAt): self
    {
        $this->birthAt = $birthAt;

        return $this;
    }

    /**
     * @return Collection|TeamPlayer[]
     */
    public function getTeamPlayers(): Collection
    {
        return $this->teamPlayers;
    }

    public function addTeamPlayer(TeamPlayer $teamPlayer): self
    {
        if (!$this->teamPlayers->contains($teamPlayer)) {
            $this->teamPlayers[] = $teamPlayer;
            $teamPlayer->setPlayer($this);
        }

        return $this;
    }

    public function removeTeamPlayer(TeamPlayer $teamPlayer): self
    {
        if ($this->teamPlayers->removeElement($teamPlayer)) {
            // set the owning side to null (unless already changed)
            if ($teamPlayer->getPlayer() === $this) {
                $teamPlayer->setPlayer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Statistic[]
     */
    public function getStatistics(): Collection
    {
        return $this->statistics;
    }

    public function addStatistic(Statistic $statistic): self
    {
        if (!$this->statistics->contains($statistic)) {
            $this->statistics[] = $statistic;
            $statistic->setPlayer($this);
        }

        return $this;
    }

    public function removeStatistic(Statistic $statistic): self
    {
        if ($this->statistics->removeElement($statistic)) {
            // set the owning side to null (unless already changed)
            if ($statistic->getPlayer() === $this) {
                $statistic->setPlayer(null);
            }
        }

        return $this;
    }
}
