<?php

namespace App\Entity;

use App\Entity\User as Manager;
use App\Repository\ClubRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=ClubRepository::class)
 */
class Club
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     * @Gedmo\Slug(fields={"name"})
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="clubs")
     */
    private $manager;

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

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug): void
    {
        $this->slug = $slug;
    }

    public function getManager(): ?Manager
    {
        return $this->manager;
    }

    public function setClubManager(?Manager $manager): self
    {
        $this->manager = $manager;

        return $this;
    }
}
