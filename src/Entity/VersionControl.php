<?php

namespace App\Entity;

use App\Repository\VersionControlRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VersionControlRepository::class)]
class VersionControl
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nameVersionControl = null;

    #[ORM\ManyToMany(targetEntity: Freelance::class, inversedBy: 'versionControls')]
    private Collection $freelanceVersionControl;

    public function __construct()
    {
        $this->freelanceVersionControl = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameVersionControl(): ?string
    {
        return $this->nameVersionControl;
    }

    public function setNameVersionControl(?string $nameVersionControl): self
    {
        $this->nameVersionControl = $nameVersionControl;

        return $this;
    }

    /**
     * @return Collection<int, Freelance>
     */
    public function getFreelanceVersionControl(): Collection
    {
        return $this->freelanceVersionControl;
    }

    public function addFreelanceVersionControl(Freelance $freelanceVersionControl): self
    {
        if (!$this->freelanceVersionControl->contains($freelanceVersionControl)) {
            $this->freelanceVersionControl->add($freelanceVersionControl);
        }

        return $this;
    }

    public function removeFreelanceVersionControl(Freelance $freelanceVersionControl): self
    {
        $this->freelanceVersionControl->removeElement($freelanceVersionControl);

        return $this;
    }
}
