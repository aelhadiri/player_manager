<?php

namespace App\Entity;

use App\Repository\SeasonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=SeasonRepository::class)
 */
class Season
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $name;

    /**
     * @ORM\Column(name="position", type="integer")
     * @Gedmo\SortablePosition
     */
    private $position;

    /**
     * @ORM\OneToMany(targetEntity=TeamPlayer::class, mappedBy="season", orphanRemoval=true)
     */
    private $teamPlayers;

    public function __construct()
    {
        $this->teamPlayers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

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
            $teamPlayer->setSeason($this);
        }

        return $this;
    }

    public function removeTeamPlayer(TeamPlayer $teamPlayer): self
    {
        if ($this->teamPlayers->removeElement($teamPlayer)) {
            // set the owning side to null (unless already changed)
            if ($teamPlayer->getSeason() === $this) {
                $teamPlayer->setSeason(null);
            }
        }

        return $this;
    }
}
