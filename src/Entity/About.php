<?php

namespace App\Entity;

use App\Repository\AboutRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AboutRepository::class)]
class About
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthdate = null;

    #[ORM\Column(length: 255)]
    private ?string $birthplace = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    private ?string $zoom = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    private ?string $postal = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    private ?string $country = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $aboutMe = null;

    #[ORM\Column(length: 255)]
    private ?string $titleExperience = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $descriptionExperience = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $skills = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $languages = null;

    #[ORM\Column(length: 255)]
    private ?string $jobTitle = null;

    /**
     * @var Collection<int, SocialLink>
     */
    #[ORM\OneToMany(targetEntity: SocialLink::class, mappedBy: 'about', cascade: ['persist', 'remove'])]
    private Collection $socialLinks;

    #[ORM\Column(length: 255)]
    private ?string $birthcountry = null;

    /**
     * @var Collection<int, Experience>
     */
    #[ORM\OneToMany(targetEntity: Experience::class, mappedBy: 'about', cascade: ['persist', 'remove'])]
    private Collection $experiences;

    public function __construct()
    {
        $this->socialLinks = new ArrayCollection();
        $this->experiences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): static
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getBirthplace(): ?string
    {
        return $this->birthplace;
    }

    public function setBirthplace(string $birthplace): static
    {
        $this->birthplace = $birthplace;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getZoom(): ?string
    {
        return $this->zoom;
    }

    public function setZoom(string $zoom): static
    {
        $this->zoom = $zoom;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getPostal(): ?string
    {
        return $this->postal;
    }

    public function setPostal(string $postal): static
    {
        $this->postal = $postal;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getAboutMe(): ?string
    {
        return $this->aboutMe;
    }

    public function setAboutMe(string $aboutMe): static
    {
        $this->aboutMe = $aboutMe;

        return $this;
    }

    public function getTitleExperience(): ?string
    {
        return $this->titleExperience;
    }

    public function setTitleExperience(string $titleExperience): static
    {
        $this->titleExperience = $titleExperience;

        return $this;
    }

    public function getDescriptionExperience(): ?string
    {
        return $this->descriptionExperience;
    }

    public function setDescriptionExperience(string $descriptionExperience): static
    {
        $this->descriptionExperience = $descriptionExperience;

        return $this;
    }

    public function getSkills(): ?string
    {
        return $this->skills;
    }

    public function setSkills(string $skills): static
    {
        $this->skills = $skills;

        return $this;
    }

    public function getLanguages(): ?string
    {
        return $this->languages;
    }

    public function setLanguages(string $languages): static
    {
        $this->languages = $languages;

        return $this;
    }

    public function getJobTitle(): ?string
    {
        return $this->jobTitle;
    }

    public function setJobTitle(string $jobTitle): static
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    /**
     * @return Collection<int, SocialLink>
     */
    public function getSocialLinks(): Collection
    {
        return $this->socialLinks;
    }

    public function addSocialLink(SocialLink $socialLink): static
    {
        if (!$this->socialLinks->contains($socialLink)) {
            $this->socialLinks->add($socialLink);
            $socialLink->setAbout($this);
        }

        return $this;
    }

    public function removeSocialLink(SocialLink $socialLink): static
    {
        if ($this->socialLinks->removeElement($socialLink)) {
            // set the owning side to null (unless already changed)
            if ($socialLink->getAbout() === $this) {
                $socialLink->setAbout(null);
            }
        }

        return $this;
    }

    public function getBirthcountry(): ?string
    {
        return $this->birthcountry;
    }

    public function setBirthcountry(string $birthcountry): static
    {
        $this->birthcountry = $birthcountry;

        return $this;
    }

    /**
     * @return Collection<int, Experience>
     */
    public function getExperiences(): Collection
    {
        return $this->experiences;
    }

    public function addExperience(Experience $experience): static
    {
        if (!$this->experiences->contains($experience)) {
            $this->experiences->add($experience);
            $experience->setAbout($this);
        }

        return $this;
    }

    public function removeExperience(Experience $experience): static
    {
        if ($this->experiences->removeElement($experience)) {
            // set the owning side to null (unless already changed)
            if ($experience->getAbout() === $this) {
                $experience->setAbout(null);
            }
        }

        return $this;
    }
}
