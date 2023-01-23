<?php

namespace App\Entity;

use App\Repository\SchoolRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SchoolRepository::class)]
class School extends Path
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $diplomaTitle = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $schoolName = null;

    #[ORM\OneToMany(mappedBy: 'school', targetEntity: Path::class)]
    private Collection $study;

    public function __construct()
    {
        $this->study = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Path>
     */
    public function getStudy(): Collection
    {
        return $this->study;
    }

    public function addStudy(Path $study): self
    {
        if (!$this->study->contains($study)) {
            $this->study->add($study);
            $study->setSchool($this);
        }

        return $this;
    }

    public function removeStudy(Path $study): self
    {
        if ($this->study->removeElement($study)) {
            // set the owning side to null (unless already changed)
            if ($study->getSchool() === $this) {
                $study->setSchool(null);
            }
        }

        return $this;
    }
}
