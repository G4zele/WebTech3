<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=510)
     */
    private $text;

    /**
     * @ORM\Column(type="datetime")
     */
    private $commDateTime;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="commRel")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userRel;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="commRel")
     * @ORM\JoinColumn(nullable=false)
     */
    private $articleRel;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getCommDateTime(): ?\DateTimeInterface
    {
        return $this->commDateTime;
    }

    public function setCommDateTime(\DateTimeInterface $commDateTime): self
    {
        $this->commDateTime = $commDateTime;

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

    public function getArticleRel(): ?Article
    {
        return $this->articleRel;
    }

    public function setArticleRel(?Article $articleRel): self
    {
        $this->articleRel = $articleRel;

        return $this;
    }

    public function __toString(): string
    {
        return $this->text;
    }
}
