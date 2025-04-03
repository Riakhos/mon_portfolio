<?php

namespace App\Entity;

use App\Repository\PricingPlanRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PricingPlanRepository::class)]
class PricingPlan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'decimal', scale: 2)]
    private ?string $price = null;

    #[ORM\Column(length: 255)]
    private ?string $currency = null;

    #[ORM\Column(length: 255)]
    private ?string $storage = null;

    #[ORM\Column(length: 255)]
    private ?string $projects = null;

    #[ORM\Column(length: 255)]
    private ?string $domains = null;

    #[ORM\Column(length: 255)]
    private ?string $users = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function getStorage(): ?string
    {
        return $this->storage;
    }

    public function setStorage(string $storage): static
    {
        $this->storage = $storage;

        return $this;
    }

    public function getProjects(): ?string
    {
        return $this->projects;
    }

    public function setProjects(string $projects): static
    {
        $this->projects = $projects;

        return $this;
    }

    public function getDomains(): ?string
    {
        return $this->domains;
    }

    public function setDomains(string $domains): static
    {
        $this->domains = $domains;

        return $this;
    }

    public function getUsers(): ?string
    {
        return $this->users;
    }

    public function setUsers(string $users): static
    {
        $this->users = $users;

        return $this;
    }
}
