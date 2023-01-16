<?php

namespace App\Entity;

use App\Repository\FreelanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FreelanceRepository::class)]
class Freelance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

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

    #[ORM\OneToMany(mappedBy: 'freelance', targetEntity: Opinion::class)]
    private Collection $opinions;

    #[ORM\OneToMany(mappedBy: 'freelance', targetEntity: Path::class)]
    private Collection $belong;

    #[ORM\ManyToMany(targetEntity: WorkCategory::class, mappedBy: 'freelanceCategory')]
    private Collection $workCategories;

    #[ORM\ManyToMany(targetEntity: SpokenLanguage::class, mappedBy: 'freelanceSpokenLanguage')]
    private Collection $spokenLanguages;

    #[ORM\ManyToMany(targetEntity: Database::class, mappedBy: 'freelanceDatabase')]
    private Collection $databases;

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


    public function __construct()
    {
        $this->opinions = new ArrayCollection();
        $this->belong = new ArrayCollection();
        $this->freelanceCategory = new ArrayCollection();
        $this->workCategories = new ArrayCollection();
        $this->spokenLanguages = new ArrayCollection();
        $this->databases = new ArrayCollection();
        $this->platforms = new ArrayCollection();
        $this->versionControls = new ArrayCollection();
        $this->frameworks = new ArrayCollection();
        $this->methodologies = new ArrayCollection();
        $this->codingLanguages = new ArrayCollection();
        $this->missions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection<int, Opinion>
     */
    public function getOpinions(): Collection
    {
        return $this->opinions;
    }

    public function addOpinion(Opinion $opinion): self
    {
        if (!$this->opinions->contains($opinion)) {
            $this->opinions->add($opinion);
            $opinion->setFreelance($this);
        }

        return $this;
    }

    public function removeOpinion(Opinion $opinion): self
    {
        if ($this->opinions->removeElement($opinion)) {
            // set the owning side to null (unless already changed)
            if ($opinion->getFreelance() === $this) {
                $opinion->setFreelance(null);
            }
        }

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
     * @return Collection<int, Database>
     */
    public function getDatabases(): Collection
    {
        return $this->databases;
    }

    public function addDatabase(Database $database): self
    {
        if (!$this->databases->contains($database)) {
            $this->databases->add($database);
            $database->addFreelanceDatabase($this);
        }

        return $this;
    }

    public function removeDatabase(Database $database): self
    {
        if ($this->databases->removeElement($database)) {
            $database->removeFreelanceDatabase($this);
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

}
