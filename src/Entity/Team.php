<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=TeamRepository::class)
 */
class Team
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     * @Gedmo\Slug(fields={"name"})
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $level;

    /**
     * @ORM\ManyToOne(targetEntity=Club::class, inversedBy="teams")
     */
    private $club;

    /**
     * @ORM\OneToMany(targetEntity=TeamPlayer::class, mappedBy="team")
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getLevel(): string
    {
        return $this->level;
    }

    public function setLevel(string $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getClub(): ?Club
    {
        return $this->club;
    }

    public function setClub(?Club $club): self
    {
        $this->club = $club;

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
            $teamPlayer->setTeam($this);
        }

        return $this;
    }

    public function removeTeamPlayer(TeamPlayer $teamPlayer): self
    {
        if ($this->teamPlayers->removeElement($teamPlayer)) {
            // set the owning side to null (unless already changed)
            if ($teamPlayer->getTeam() === $this) {
                $teamPlayer->setTeam(null);
            }
        }

        return $this;
    }
}
