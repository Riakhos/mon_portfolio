<?php

namespace App\Entity;

use App\Repository\BlogPostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BlogPostRepository::class)]
class BlogPost
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $framework = [];

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $updated = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $category = [];

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'blogPost', cascade: ['persist', 'remove'])]
    private Collection $comments;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $likes = 0;

    #[ORM\ManyToOne(inversedBy: 'blogPosts')]
    private ?About $author = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $selectedSocialLinkType = null;

    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable(); // Définit la date actuelle par défaut
        $this->comments = new ArrayCollection();
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function getFramework(): ?array
    {
        return $this->framework;
    }

    public function setFramework(?array $framework): static
    {
        $this->framework = $framework;

        return $this;
    }

    public function getUpdated(): ?\DateTimeImmutable
    {
        return $this->updated;
    }

    public function setUpdated(?\DateTimeImmutable $updated): static
    {
        $this->updated = $updated;

        return $this;
    }

    public function getCategory(): ?array
    {
        return $this->category;
    }

    public function setCategory(?array $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setBlogPost($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getBlogPost() === $this) {
                $comment->setBlogPost(null);
            }
        }

        return $this;
    }

    public function getAuthor(): ?About
    {
        return $this->author;
    }

    public function setAuthor(?About $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getLikes(): ?int
    {
        return $this->likes;
    }

    public function setLikes(?int $likes): static
    {
        $this->likes = $likes;

        return $this;
    }

    public function incrementLikes(): static
    {
        $this->likes++;

        return $this;
    }

    public function decrementLikes(): static
    {
        if ($this->likes > 0) {
            $this->likes--;
        }

        return $this;
    }

    public function getSelectedSocialLinkType(): ?string
    {
        return $this->selectedSocialLinkType;
    }

    public function setSelectedSocialLinkType(?string $selectedSocialLinkType): static
    {
        $this->selectedSocialLinkType = $selectedSocialLinkType;

        return $this;
    }
}
