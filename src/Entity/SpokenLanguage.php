<?php

namespace App\Entity;

use App\Repository\SpokenLanguageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpokenLanguageRepository::class)]
class SpokenLanguage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nameLanguage = null;

    #[ORM\ManyToMany(targetEntity: freelance::class, inversedBy: 'spokenLanguages')]
    private Collection $freelanceSpokenLanguage;

    public function __construct()
    {
        $this->freelanceSpokenLanguage = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameLanguage(): ?string
    {
        return $this->nameLanguage;
    }

    public function setNameLanguage(?string $nameLanguage): self
    {
        $this->nameLanguage = $nameLanguage;

        return $this;
    }

    /**
     * @return Collection<int, freelance>
     */
    public function getFreelanceSpokenLanguage(): Collection
    {
        return $this->freelanceSpokenLanguage;
    }

    public function addFreelanceSpokenLanguage(freelance $freelanceSpokenLanguage): self
    {
        if (!$this->freelanceSpokenLanguage->contains($freelanceSpokenLanguage)) {
            $this->freelanceSpokenLanguage->add($freelanceSpokenLanguage);
        }

        return $this;
    }

    public function removeFreelanceSpokenLanguage(freelance $freelanceSpokenLanguage): self
    {
        $this->freelanceSpokenLanguage->removeElement($freelanceSpokenLanguage);

        return $this;
    }
}
