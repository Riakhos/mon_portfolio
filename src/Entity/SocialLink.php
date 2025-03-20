<?php

namespace App\Entity;

use App\Repository\SocialLinkRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SocialLinkRepository::class)]
class SocialLink
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $platform = null;

    #[ORM\Column(length: 255)]
    private ?string $href = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imgSrc = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imgAlt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imgTitle = null;

    #[ORM\ManyToOne(inversedBy: 'socialLinks')]
    private ?About $about = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlatform(): ?string
    {
        return $this->platform;
    }

    public function setPlatform(string $platform): static
    {
        $this->platform = $platform;

        $platformData = [
            'facebook' => [
                'src' => 'images/social-links/facebook.png',
                'alt' => 'Logo Facebook',
                'title' => 'Suivez-moi sur Facebook'
            ],
            'linkedin' => [
                'src' => 'images/social-links/linkedin.png',
                'alt' => 'Logo LinkedIn',
                'title' => 'Suivez-moi sur LinkedIn'
            ],
            'google' => [
                'src' => 'images/social-links/gmail.png',
                'alt' => 'Logo Google',
                'title' => 'Suivez-moi sur Google'
            ],
            'instagram' => [
                'src' => 'images/social-links/instagram.png',
                'alt' => 'Logo Instagram',
                'title' => 'Suivez-moi sur Instagram'
            ],
            'github' => [
                'src' => 'images/social-links/github.png',
                'alt' => 'Logo GitHub',
                'title' => 'Suivez-moi sur GitHub'
            ],
            'twitter' => [
                'src' => 'images/social-links/twitter.png',
                'alt' => 'Logo Twitter',
                'title' => 'Suivez-moi sur Twitter'
            ],
            'youtube' => [
                'src' => 'images/social-links/youtube.png',
                'alt' => 'Logo YouTube',
                'title' => 'Suivez-moi sur YouTube'
            ],
            'pinterest' => [
                'src' => 'images/social-links/pinterest.png',
                'alt' => 'Logo Pinterest',
                'title' => 'Suivez-moi sur Pinterest'
            ],
            'snapchat' => [
                'src' => 'images/social-links/snapchat.png',
                'alt' => 'Logo Snapchat',
                'title' => 'Suivez-moi sur Snapchat'
            ],
            'tiktok' => [
                'src' => 'images/social-links/tic-tac.png',
                'alt' => 'Logo TikTok',
                'title' => 'Suivez-moi sur TikTok'
            ],
            'whatsapp' => [
                'src' => 'images/social-links/whatsapp.png',
                'alt' => 'Logo WhatsApp',
                'title' => 'Suivez-moi sur WhatsApp'
            ],
            'discord' => [
                'src' => 'images/social-links/discord.png',
                'alt' => 'Logo Discord',
                'title' => 'Suivez-moi sur Discord'
            ]
        ];

        if (isset($platformData[$platform])) {
            $this->imgSrc = $platformData[$platform]['src'];
            $this->imgAlt = $platformData[$platform]['alt'];
            $this->imgTitle = $platformData[$platform]['title'];
        }

        return $this;
    }

    public function getHref(): ?string
    {
        return $this->href;
    }

    public function setHref(string $href): static
    {
        $this->href = $href;

        return $this;
    }

    public function getImgSrc(): ?string
    {
        return $this->imgSrc;
    }

    public function getImgAlt(): ?string
    {
        return $this->imgAlt;
    }

    public function getImgTitle(): ?string
    {
        return $this->imgTitle;
    }

    public function getAbout(): ?About
    {
        return $this->about;
    }

    public function setAbout(?About $about): static
    {
        $this->about = $about;

        return $this;
    }
}
