<?php

namespace App\Entity;

use App\Repository\SchoolRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SchoolRepository::class)]
class School
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $diplomaTitle = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $schoolName = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDiplomaTitle(): ?string
    {
        return $this->diplomaTitle;
    }

    public function setDiplomaTitle(?string $diplomaTitle): self
    {
        $this->diplomaTitle = $diplomaTitle;

        return $this;
    }

    public function getSchoolName(): ?string
    {
        return $this->schoolName;
    }

    public function setSchoolName(?string $schoolName): self
    {
        $this->schoolName = $schoolName;

        return $this;
    }
}
