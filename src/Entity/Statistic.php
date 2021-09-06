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
     * @ORM\ManyToOne(targetEntity=StatisticItem::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $feature;

    /**
     * @ORM\ManyToOne(targetEntity=StatisticItem::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $season;

    /**
     * @ORM\ManyToOne(targetEntity=Player::class, inversedBy="statistics")
     * @ORM\JoinColumn(nullable=false)
     */
    private $player;

    /**
     * @ORM\Column(type="integer")
     */
    private $value;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFeature(): ?StatisticItem
    {
        return $this->feature;
    }

    public function setFeature(?StatisticItem $feature): self
    {
        $this->feature = $feature;

        return $this;
    }

    public function getSeason(): ?StatisticItem
    {
        return $this->season;
    }

    public function setSeason(?StatisticItem $season): self
    {
        $this->season = $season;

        return $this;
    }

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(?Player $player): self
    {
        $this->player = $player;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }
}
