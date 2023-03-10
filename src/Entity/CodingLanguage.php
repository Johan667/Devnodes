<?php

namespace App\Entity;

use App\Repository\CodingLanguageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CodingLanguageRepository::class)]
class CodingLanguage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nameCodingLanguage = null;

    #[ORM\ManyToMany(targetEntity: Freelance::class, inversedBy: 'codingLanguages')]
    private Collection $freelanceCodingLanguage;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'testi')]
    private Collection $users;


    public function __construct()
    {
        $this->freelanceCodingLanguage = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameCodingLanguage(): ?string
    {
        return $this->nameCodingLanguage;
    }

    public function setNameCodingLanguage(?string $nameCodingLanguage): self
    {
        $this->nameCodingLanguage = $nameCodingLanguage;

        return $this;
    }

    /**
     * @return Collection<int, Freelance>
     */
    public function getFreelanceCodingLanguage(): Collection
    {
        return $this->freelanceCodingLanguage;
    }

    public function addFreelanceCodingLanguage(Freelance $freelanceCodingLanguage): self
    {
        if (!$this->freelanceCodingLanguage->contains($freelanceCodingLanguage)) {
            $this->freelanceCodingLanguage->add($freelanceCodingLanguage);
        }

        return $this;
    }

    public function removeFreelanceCodingLanguage(Freelance $freelanceCodingLanguage): self
    {
        $this->freelanceCodingLanguage->removeElement($freelanceCodingLanguage);

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addTesti($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeTesti($this);
        }

        return $this;
    }


}
