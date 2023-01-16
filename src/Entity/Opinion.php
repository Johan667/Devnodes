<?php

namespace App\Entity;

use App\Repository\OpinionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OpinionRepository::class)]
class Opinion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateOpinion = null;

    #[ORM\Column(nullable: true)]
    private ?int $star = null;

    #[ORM\ManyToOne(inversedBy: 'opinions')]
    private ?User $users = null;

    #[ORM\ManyToOne(inversedBy: 'opinions')]
    private ?Freelance $freelance = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getDateOpinion(): ?\DateTimeInterface
    {
        return $this->dateOpinion;
    }

    public function setDateOpinion(?\DateTimeInterface $dateOpinion): self
    {
        $this->dateOpinion = $dateOpinion;

        return $this;
    }

    public function getStar(): ?int
    {
        return $this->star;
    }

    public function setStar(?int $star): self
    {
        $this->star = $star;

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function getFreelance(): ?Freelance
    {
        return $this->freelance;
    }

    public function setFreelance(?Freelance $freelance): self
    {
        $this->freelance = $freelance;

        return $this;
    }
}
