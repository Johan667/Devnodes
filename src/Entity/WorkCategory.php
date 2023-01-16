<?php

namespace App\Entity;

use App\Repository\WorkCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorkCategoryRepository::class)]
class WorkCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nameCategory = null;

    #[ORM\ManyToMany(targetEntity: Freelance::class, mappedBy: 'freelanceCategory')]
    private Collection $freelances;

    #[ORM\ManyToMany(targetEntity: Freelance::class, inversedBy: 'workCategories')]
    private Collection $freelanceCategory;

    public function __construct()
    {
        $this->freelances = new ArrayCollection();
        $this->freelanceCategory = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameCategory(): ?string
    {
        return $this->nameCategory;
    }

    public function setNameCategory(?string $nameCategory): self
    {
        $this->nameCategory = $nameCategory;

        return $this;
    }

    /**
     * @return Collection<int, Freelance>
     */
    public function getFreelances(): Collection
    {
        return $this->freelances;
    }

    public function addFreelance(Freelance $freelance): self
    {
        if (!$this->freelances->contains($freelance)) {
            $this->freelances->add($freelance);
            $freelance->addFreelanceCategory($this);
        }

        return $this;
    }

    public function removeFreelance(Freelance $freelance): self
    {
        if ($this->freelances->removeElement($freelance)) {
            $freelance->removeFreelanceCategory($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Freelance>
     */
    public function getFreelanceCategory(): Collection
    {
        return $this->freelanceCategory;
    }

    public function addFreelanceCategory(Freelance $freelanceCategory): self
    {
        if (!$this->freelanceCategory->contains($freelanceCategory)) {
            $this->freelanceCategory->add($freelanceCategory);
        }

        return $this;
    }

    public function removeFreelanceCategory(Freelance $freelanceCategory): self
    {
        $this->freelanceCategory->removeElement($freelanceCategory);

        return $this;
    }
}
