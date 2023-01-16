<?php

namespace App\Entity;

use App\Repository\DbRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DbRepository::class)]
class Db
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nameDb = null;

    #[ORM\ManyToMany(targetEntity: Freelance::class, inversedBy: 'dbs')]
    private Collection $freelanceDb;

    public function __construct()
    {
        $this->freelanceDb = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameDb(): ?string
    {
        return $this->nameDb;
    }

    public function setNameDb(?string $nameDb): self
    {
        $this->nameDb = $nameDb;

        return $this;
    }

    /**
     * @return Collection<int, Freelance>
     */
    public function getFreelanceDb(): Collection
    {
        return $this->freelanceDb;
    }

    public function addFreelanceDb(Freelance $freelanceDb): self
    {
        if (!$this->freelanceDb->contains($freelanceDb)) {
            $this->freelanceDb->add($freelanceDb);
        }

        return $this;
    }

    public function removeFreelanceDb(Freelance $freelanceDb): self
    {
        $this->freelanceDb->removeElement($freelanceDb);

        return $this;
    }
}
