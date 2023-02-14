<?php

namespace App\Entity;

use App\Repository\FreelanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FreelanceRepository::class)]
class Freelance extends User
{

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $location = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $country = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $city = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $codePostal = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $durationPreference = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $remoteWork = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $xpYears = null;


    #[ORM\OneToMany(mappedBy: 'freelance', targetEntity: Path::class)]
    private Collection $belong;

    #[ORM\ManyToMany(targetEntity: WorkCategory::class, mappedBy: 'freelanceCategory')]
    private Collection $workCategories;

    #[ORM\ManyToMany(targetEntity: SpokenLanguage::class, mappedBy: 'freelanceSpokenLanguage')]
    private Collection $spokenLanguages;


    #[ORM\ManyToMany(targetEntity: Platform::class, mappedBy: 'freelancePlatform')]
    private Collection $platforms;

    #[ORM\ManyToMany(targetEntity: VersionControl::class, mappedBy: 'freelanceVersionControl')]
    private Collection $versionControls;

    #[ORM\ManyToMany(targetEntity: Framework::class, mappedBy: 'freelanceFramework')]
    private Collection $frameworks;

    #[ORM\ManyToMany(targetEntity: Methodology::class, mappedBy: 'freelanceMethodology')]
    private Collection $methodologies;

    #[ORM\ManyToMany(targetEntity: CodingLanguage::class, mappedBy: 'freelanceCodingLanguage')]
    private Collection $codingLanguages;

    #[ORM\OneToMany(mappedBy: 'receiveMission', targetEntity: Mission::class)]
    private Collection $missions;

    #[ORM\ManyToMany(targetEntity: Db::class, mappedBy: 'freelanceDb')]
    private Collection $dbs;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $biographie = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'favoriteFreelance')]
    private Collection $users;

    #[ORM\Column(nullable: true)]
    private ?bool $isVip = null;


    public function __construct()
    {
        parent::__construct();
        $this->belong = new ArrayCollection();
        $this->freelanceCategory = new ArrayCollection();
        $this->workCategories = new ArrayCollection();
        $this->spokenLanguages = new ArrayCollection();
        $this->platforms = new ArrayCollection();
        $this->versionControls = new ArrayCollection();
        $this->frameworks = new ArrayCollection();
        $this->methodologies = new ArrayCollection();
        $this->codingLanguages = new ArrayCollection();
        $this->missions = new ArrayCollection();
        $this->dbs = new ArrayCollection();
        $this->users = new ArrayCollection();
    }



    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(?string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDurationPreference(): ?string
    {
        return $this->durationPreference;
    }

    public function setDurationPreference(?string $durationPreference): self
    {
        $this->durationPreference = $durationPreference;

        return $this;
    }

    public function getRemoteWork(): ?string
    {
        return $this->remoteWork;
    }

    public function setRemoteWork(?string $remoteWork): self
    {
        $this->remoteWork = $remoteWork;

        return $this;
    }

    public function getXpYears(): ?string
    {
        return $this->xpYears;
    }

    public function setXpYears(?string $xpYears): self
    {
        $this->xpYears = $xpYears;

        return $this;
    }

    /**
     * @return Collection<int, Path>
     */
    public function getBelong(): Collection
    {
        return $this->belong;
    }

    public function addBelong(Path $belong): self
    {
        if (!$this->belong->contains($belong)) {
            $this->belong->add($belong);
            $belong->setFreelance($this);
        }

        return $this;
    }

    public function removeBelong(Path $belong): self
    {
        if ($this->belong->removeElement($belong)) {
            // set the owning side to null (unless already changed)
            if ($belong->getFreelance() === $this) {
                $belong->setFreelance(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, WorkCategory>
     */
    public function getWorkCategories(): Collection
    {
        return $this->workCategories;
    }

    public function addWorkCategory(WorkCategory $workCategory): self
    {
        if (!$this->workCategories->contains($workCategory)) {
            $this->workCategories->add($workCategory);
            $workCategory->addFreelanceCategory($this);
        }

        return $this;
    }

    public function removeWorkCategory(WorkCategory $workCategory): self
    {
        if ($this->workCategories->removeElement($workCategory)) {
            $workCategory->removeFreelanceCategory($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, SpokenLanguage>
     */
    public function getSpokenLanguages(): Collection
    {
        return $this->spokenLanguages;
    }

    public function addSpokenLanguage(SpokenLanguage $spokenLanguage): self
    {
        if (!$this->spokenLanguages->contains($spokenLanguage)) {
            $this->spokenLanguages->add($spokenLanguage);
            $spokenLanguage->addFreelanceSpokenLanguage($this);
        }

        return $this;
    }

    public function removeSpokenLanguage(SpokenLanguage $spokenLanguage): self
    {
        if ($this->spokenLanguages->removeElement($spokenLanguage)) {
            $spokenLanguage->removeFreelanceSpokenLanguage($this);
        }

        return $this;
    }


    /**
     * @return Collection<int, Platform>
     */
    public function getPlatforms(): Collection
    {
        return $this->platforms;
    }

    public function addPlatform(Platform $platform): self
    {
        if (!$this->platforms->contains($platform)) {
            $this->platforms->add($platform);
            $platform->addFreelancePlatform($this);
        }

        return $this;
    }

    public function removePlatform(Platform $platform): self
    {
        if ($this->platforms->removeElement($platform)) {
            $platform->removeFreelancePlatform($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, VersionControl>
     */
    public function getVersionControls(): Collection
    {
        return $this->versionControls;
    }

    public function addVersionControl(VersionControl $versionControl): self
    {
        if (!$this->versionControls->contains($versionControl)) {
            $this->versionControls->add($versionControl);
            $versionControl->addFreelanceVersionControl($this);
        }

        return $this;
    }

    public function removeVersionControl(VersionControl $versionControl): self
    {
        if ($this->versionControls->removeElement($versionControl)) {
            $versionControl->removeFreelanceVersionControl($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Framework>
     */
    public function getFrameworks(): Collection
    {
        return $this->frameworks;
    }

    public function addFramework(Framework $framework): self
    {
        if (!$this->frameworks->contains($framework)) {
            $this->frameworks->add($framework);
            $framework->addFreelanceFramework($this);
        }

        return $this;
    }

    public function removeFramework(Framework $framework): self
    {
        if ($this->frameworks->removeElement($framework)) {
            $framework->removeFreelanceFramework($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Methodology>
     */
    public function getMethodologies(): Collection
    {
        return $this->methodologies;
    }

    public function addMethodology(Methodology $methodology): self
    {
        if (!$this->methodologies->contains($methodology)) {
            $this->methodologies->add($methodology);
            $methodology->addFreelanceMethodology($this);
        }

        return $this;
    }

    public function removeMethodology(Methodology $methodology): self
    {
        if ($this->methodologies->removeElement($methodology)) {
            $methodology->removeFreelanceMethodology($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, CodingLanguage>
     */
    public function getCodingLanguages(): Collection
    {
        return $this->codingLanguages;
    }

    public function addCodingLanguage(CodingLanguage $codingLanguage): self
    {
        if (!$this->codingLanguages->contains($codingLanguage)) {
            $this->codingLanguages->add($codingLanguage);
            $codingLanguage->addFreelanceCodingLanguage($this);
        }

        return $this;
    }

    public function removeCodingLanguage(CodingLanguage $codingLanguage): self
    {
        if ($this->codingLanguages->removeElement($codingLanguage)) {
            $codingLanguage->removeFreelanceCodingLanguage($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Mission>
     */
    public function getMissions(): Collection
    {
        return $this->missions;
    }

    public function addMission(Mission $mission): self
    {
        if (!$this->missions->contains($mission)) {
            $this->missions->add($mission);
            $mission->setReceiveMission($this);
        }

        return $this;
    }

    public function removeMission(Mission $mission): self
    {
        if ($this->missions->removeElement($mission)) {
            // set the owning side to null (unless already changed)
            if ($mission->getReceiveMission() === $this) {
                $mission->setReceiveMission(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Db>
     */
    public function getDbs(): Collection
    {
        return $this->dbs;
    }

    public function addDb(Db $db): self
    {
        if (!$this->dbs->contains($db)) {
            $this->dbs->add($db);
            $db->addFreelanceDb($this);
        }

        return $this;
    }

    public function removeDb(Db $db): self
    {
        if ($this->dbs->removeElement($db)) {
            $db->removeFreelanceDb($this);
        }

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getBiographie(): ?string
    {
        return $this->biographie;
    }

    public function setBiographie(?string $biographie): self
    {
        $this->biographie = $biographie;

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
            $user->addFavoriteFreelance($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeFavoriteFreelance($this);
        }

        return $this;
    }

    public function isIsVip(): ?bool
    {
        return $this->isVip;
    }

    public function setIsVip(?bool $isVip): self
    {
        $this->isVip = $isVip;

        return $this;
    }

}
