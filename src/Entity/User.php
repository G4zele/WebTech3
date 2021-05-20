<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $surName;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="userRel", orphanRemoval=true)
     */
    private $commRel;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="userRel", orphanRemoval=true)
     */
    private $articleRel;

    public function __construct()
    {
        $this->commRel = new ArrayCollection();
        $this->articleRel = new ArrayCollection();
    }

    


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getSurName(): ?string
    {
        return $this->surName;
    }

    public function setSurName(string $surName): self
    {
        $this->surName = $surName;

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
            $commRel->setUserRel($this);
        }

        return $this;
    }

    public function removeCommRel(Comment $commRel): self
    {
        if ($this->commRel->removeElement($commRel)) {
            // set the owning side to null (unless already changed)
            if ($commRel->getUserRel() === $this) {
                $commRel->setUserRel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticleRel(): Collection
    {
        return $this->articleRel;
    }

    public function addArticleRel(Article $articleRel): self
    {
        if (!$this->articleRel->contains($articleRel)) {
            $this->articleRel[] = $articleRel;
            $articleRel->setUserRel($this);
        }

        return $this;
    }

    public function removeArticleRel(Article $articleRel): self
    {
        if ($this->articleRel->removeElement($articleRel)) {
            // set the owning side to null (unless already changed)
            if ($articleRel->getUserRel() === $this) {
                $articleRel->setUserRel(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->email;
    }

}
