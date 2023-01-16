<?php

namespace App\Entity;

use App\Repository\PlatformRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlatformRepository::class)]
class Platform
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $namePlateform = null;

    #[ORM\ManyToMany(targetEntity: Freelance::class, inversedBy: 'platforms')]
    private Collection $freelancePlatform;

    public function __construct()
    {
        $this->freelancePlatform = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNamePlateform(): ?string
    {
        return $this->namePlateform;
    }

    public function setNamePlateform(?string $namePlateform): self
    {
        $this->namePlateform = $namePlateform;

        return $this;
    }

    /**
     * @return Collection<int, Freelance>
     */
    public function getFreelancePlatform(): Collection
    {
        return $this->freelancePlatform;
    }

    public function addFreelancePlatform(Freelance $freelancePlatform): self
    {
        if (!$this->freelancePlatform->contains($freelancePlatform)) {
            $this->freelancePlatform->add($freelancePlatform);
        }

        return $this;
    }

    public function removeFreelancePlatform(Freelance $freelancePlatform): self
    {
        $this->freelancePlatform->removeElement($freelancePlatform);

        return $this;
    }
}
