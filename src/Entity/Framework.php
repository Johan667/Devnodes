<?php

namespace App\Entity;

use App\Repository\FrameworkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FrameworkRepository::class)]
class Framework
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nameFramework = null;

    #[ORM\ManyToMany(targetEntity: Freelance::class, inversedBy: 'frameworks')]
    private Collection $freelanceFramework;

    public function __construct()
    {
        $this->freelanceFramework = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameFramework(): ?string
    {
        return $this->nameFramework;
    }

    public function setNameFramework(?string $nameFramework): self
    {
        $this->nameFramework = $nameFramework;

        return $this;
    }

    /**
     * @return Collection<int, Freelance>
     */
    public function getFreelanceFramework(): Collection
    {
        return $this->freelanceFramework;
    }

    public function addFreelanceFramework(Freelance $freelanceFramework): self
    {
        if (!$this->freelanceFramework->contains($freelanceFramework)) {
            $this->freelanceFramework->add($freelanceFramework);
        }

        return $this;
    }

    public function removeFreelanceFramework(Freelance $freelanceFramework): self
    {
        $this->freelanceFramework->removeElement($freelanceFramework);

        return $this;
    }
}
