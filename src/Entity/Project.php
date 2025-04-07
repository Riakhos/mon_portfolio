<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    private ?string $github_link = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $demo_link = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated = null;

    #[ORM\Column(type: Types::JSON)]
    private array $skills = [];

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $frameworks = [];

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $apis = [];

    #[ORM\Column(nullable: true)]
    private ?int $hoursWorked = null;

    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable(); // Définit la date actuelle par défaut
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getGithubLink(): ?string
    {
        return $this->github_link;
    }

    public function setGithubLink(string $github_link): static
    {
        $this->github_link = $github_link;

        return $this;
    }

    public function getDemoLink(): ?string
    {
        return $this->demo_link;
    }

    public function setDemoLink(string $demo_link): static
    {
        $this->demo_link = $demo_link;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(?\DateTimeInterface $updated): static
    {
        $this->updated = $updated;

        return $this;
    }

    public function updateTimestamp(): void
    {
        $this->updated = new \DateTime(); // Met à jour la date à l'heure actuelle
    }

    public function getSkills(): array
    {
        $formattedSkills = [];

        foreach ($this->skills as $skill) {
            if (strpos($skill, ':') !== false) {
                [$key, $value] = explode(':', $skill);
                $formattedSkills[trim($key)] = (int) trim($value);
            }
        }

        return $formattedSkills;
    }

    public function setSkills(array $skills): static
    {
        $this->skills = $skills;

        return $this;
    }

    public function getFrameworks(): ?array
    {
        $formattedFrameworks = [];

        foreach ($this->frameworks as $framework) {
            if (strpos($framework, ':') !== false) {
                [$key, $value] = explode(':', $framework);
                $formattedFrameworks[trim($key)] = (int) trim($value);
            }
        }

        return $formattedFrameworks;
    }

    public function setFrameworks(?array $frameworks): static
    {
        $this->frameworks = $frameworks;

        return $this;
    }

    public function getApis(): ?array
    {
        $formattedApis = [];

        foreach ($this->apis as $api) {
            if (strpos($api, ':') !== false) {
                [$key, $value] = explode(':', $api);
                $formattedApis[trim($key)] = (int) trim($value);
            }
        }

        return $formattedApis;
    }

    public function setApis(?array $apis): static
    {
        $this->apis = $apis;

        return $this;
    }

    public function getHoursWorked(): ?int
    {
        return $this->hoursWorked;
    }

    public function setHoursWorked(?int $hoursWorked): static
    {
        $this->hoursWorked = $hoursWorked;

        return $this;
    }
}
