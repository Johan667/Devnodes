<?php

namespace App\Entity;

use App\Repository\DatabaseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DatabaseRepository::class)]
class Database
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nameDatabase = null;

    #[ORM\ManyToMany(targetEntity: Freelance::class, inversedBy: 'databases')]
    private Collection $freelanceDatabase;

    public function __construct()
    {
        $this->freelanceDatabase = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameDatabase(): ?string
    {
        return $this->nameDatabase;
    }

    public function setNameDatabase(?string $nameDatabase): self
    {
        $this->nameDatabase = $nameDatabase;

        return $this;
    }

    /**
     * @return Collection<int, Freelance>
     */
    public function getFreelanceDatabase(): Collection
    {
        return $this->freelanceDatabase;
    }

    public function addFreelanceDatabase(Freelance $freelanceDatabase): self
    {
        if (!$this->freelanceDatabase->contains($freelanceDatabase)) {
            $this->freelanceDatabase->add($freelanceDatabase);
        }

        return $this;
    }

    public function removeFreelanceDatabase(Freelance $freelanceDatabase): self
    {
        $this->freelanceDatabase->removeElement($freelanceDatabase);

        return $this;
    }
}
