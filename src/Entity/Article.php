<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $annotation;

    /**
     * @ORM\Column(type="text", length=4080)
     */
    private $content;

    /**
     * @ORM\Column(type="integer")
     */
    private $views;

    /**
     * @ORM\Column(type="datetime")
     */
    private $artDateTime;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="articleRel")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userRel;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="articleRel", orphanRemoval=true)
     */
    private $commRel;

    public function __construct()
    {
        $this->commRel = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getAnnotation(): ?string
    {
        return $this->annotation;
    }

    public function setAnnotation(string $annotation): self
    {
        $this->annotation = $annotation;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getViews(): ?int
    {
        return $this->views;
    }

    public function setViews(int $views): self
    {
        $this->views = $views;

        return $this;
    }

    public function getArtDateTime(): ?\DateTimeInterface
    {
        return $this->artDateTime;
    }

    public function setArtDateTime(\DateTimeInterface $artDateTime): self
    {
        $this->artDateTime = $artDateTime;

        return $this;
    }

    public function getUserRel(): ?User
    {
        return $this->userRel;
    }

    public function setUserRel(?User $userRel): self
    {
        $this->userRel = $userRel;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getCommRel(): Collection
    {
        return $this->commRel;
    }

    public function addCommRel(Comment $commRel): self
    {
        if (!$this->commRel->contains($commRel)) {
            $this->commRel[] = $commRel;
            $commRel->setArticleRel($this);
        }

        return $this;
    }

    public function removeCommRel(Comment $commRel): self
    {
        if ($this->commRel->removeElement($commRel)) {
            // set the owning side to null (unless already changed)
            if ($commRel->getArticleRel() === $this) {
                $commRel->setArticleRel(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->title;
    }

    
    
    public function incrementView()
    {
        $currentViews = $this->getViews();
        if ($currentViews) 
        {
            $this->setViews($currentViews + 1);
        } 
        else 
        {
            $this->setViews(1);
        }
    }

    public function kostylForView()
    {
        $currentViews = $this->getViews();
        if ($currentViews) 
        {
            $this->setViews($currentViews - 2);
        } 
        else 
        {
            $this->setViews(1);
        }
    }
}
