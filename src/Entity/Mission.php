<?php

namespace App\Entity;

use App\Repository\MissionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MissionRepository::class)]
class Mission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $object = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isRead = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $addFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $state = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $frenquency = null;

    #[ORM\ManyToOne(inversedBy: 'missions')]
    private ?User $sendMission = null;

    #[ORM\ManyToOne(inversedBy: 'missions')]
    private ?Freelance $receiveMission = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getObject(): ?string
    {
        return $this->object;
    }

    public function setObject(?string $object): self
    {
        $this->object = $object;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function isIsRead(): ?bool
    {
        return $this->isRead;
    }

    public function setIsRead(?bool $isRead): self
    {
        $this->isRead = $isRead;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAddFile(): ?string
    {
        return $this->addFile;
    }

    public function setAddFile(?string $addFile): self
    {
        $this->addFile = $addFile;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getFrenquency(): ?string
    {
        return $this->frenquency;
    }

    public function setFrenquency(?string $frenquency): self
    {
        $this->frenquency = $frenquency;

        return $this;
    }

    public function getSendMission(): ?User
    {
        return $this->sendMission;
    }

    public function setSendMission(?User $sendMission): self
    {
        $this->sendMission = $sendMission;

        return $this;
    }

    public function getReceiveMission(): ?Freelance
    {
        return $this->receiveMission;
    }

    public function setReceiveMission(?Freelance $receiveMission): self
    {
        $this->receiveMission = $receiveMission;

        return $this;
    }
}