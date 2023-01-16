<?php

namespace App\Entity;

use App\Repository\MethodologyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MethodologyRepository::class)]
class Methodology
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nameMethodology = null;

    #[ORM\ManyToMany(targetEntity: Freelance::class, inversedBy: 'methodologies')]
    private Collection $freelanceMethodology;

    public function __construct()
    {
        $this->freelanceMethodology = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameMethodology(): ?string
    {
        return $this->nameMethodology;
    }

    public function setNameMethodology(?string $nameMethodology): self
    {
        $this->nameMethodology = $nameMethodology;

        return $this;
    }

    /**
     * @return Collection<int, Freelance>
     */
    public function getFreelanceMethodology(): Collection
    {
        return $this->freelanceMethodology;
    }

    public function addFreelanceMethodology(Freelance $freelanceMethodology): self
    {
        if (!$this->freelanceMethodology->contains($freelanceMethodology)) {
            $this->freelanceMethodology->add($freelanceMethodology);
        }

        return $this;
    }

    public function removeFreelanceMethodology(Freelance $freelanceMethodology): self
    {
        $this->freelanceMethodology->removeElement($freelanceMethodology);

        return $this;
    }
}
