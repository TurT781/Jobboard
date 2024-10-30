<?php

namespace App\Entity;

use App\Repository\AdvertisementsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdvertisementsRepository::class)]
class Advertisements
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    private ?string $title = null;

    #[ORM\Column(length: 128)]
    private ?string $company = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(length: 64)]
    private ?string $salary_min = null;

    #[ORM\Column(length: 255)]
    private ?string $experience_level = null;

    #[ORM\Column(length: 255)]
    private ?string $education_level = null;

    #[ORM\Column(length: 128)]
    private ?string $working_time = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(length: 255, nullable: false)]
    private string $address;

    /**
     * @var Collection<int, Applications>
     */
    #[ORM\OneToMany(targetEntity: Applications::class, mappedBy: 'advertisements')]
    private Collection $applications;

    #[ORM\ManyToOne(inversedBy: 'advertisements')]
    private ?Users $users = null;

    public function __construct()
    {
        $this->applications = new ArrayCollection();
    }


    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getCompany(): ?string 
    {
        return $this->company;
    }

    public function setCompany(string $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getSalaryMin(): ?string
    {
        return $this->salary_min;
    }

    public function setSalaryMin(string $salary_min): static
    {
        $this->salary_min = $salary_min;

        return $this;
    }

    public function getExperienceLevel(): ?string
    {
        return $this->experience_level;
    }

    public function setExperienceLevel(string $experience_level): static
    {
        $this->experience_level = $experience_level;

        return $this;
    }

    public function getEducationLevel(): ?string
    {
        return $this->education_level;
    }

    public function setEducationLevel(string $education_level): static
    {
        $this->education_level = $education_level;

        return $this;
    }

    public function getWorkingTime(): ?string
    {
        return $this->working_time;
    }

    public function setWorkingTime(string $working_time): static
    {
        $this->working_time = $working_time;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Collection<int, Applications>
     */
    public function getApplications(): Collection
    {
        return $this->applications;
    }

    public function addApplication(Applications $application): static
    {
        if (!$this->applications->contains($application)) {
            $this->applications->add($application);
            $application->setAdvertisements($this);
        }

        return $this;
    }

    public function removeApplication(Applications $application): static
    {
        if ($this->applications->removeElement($application)) {
            // set the owning side to null (unless already changed)
            if ($application->getAdvertisements() === $this) {
                $application->setAdvertisements(null);
            }
        }

        return $this;
    }

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): static
    {
        $this->users = $users;

        return $this;
    }
}
