<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
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
     * @ORM\OneToMany(targetEntity="App\Entity\Vocabulary", mappedBy="category", cascade={"remove"})
     */
    private $vocabularies;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Session", mappedBy="category", cascade={"remove"})
     */
    private $sessions;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="categories")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Promotion", inversedBy="categories")
     */
    private $promotion;

    public function __construct()
    {
        $this->vocabularies = new ArrayCollection();
        $this->sessions = new ArrayCollection();
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

    /**
     * @return Collection|Vocabulary[]
     */
    public function getVocabularies(): Collection
    {
        return $this->vocabularies;
    }

    public function addVocabulary(Vocabulary $vocabulary): self
    {
        if (!$this->vocabularies->contains($vocabulary)) {
            $this->vocabularies[] = $vocabulary;
            $vocabulary->setCategory($this);
        }

        return $this;
    }

    public function removeVocabulary(Vocabulary $vocabulary): self
    {
        if ($this->vocabularies->removeElement($vocabulary)) {
            // set the owning side to null (unless already changed)
            if ($vocabulary->getCategory() === $this) {
                $vocabulary->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Session[]
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(Session $session): self
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions[] = $session;
            $session->setCategory($this);
        }

        return $this;
    }

    public function removeSession(Session $session): self
    {
        if ($this->sessions->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getCategory() === $this) {
                $session->setCategory(null);
            }
        }

        return $this;
    }

    public function getPromotion(): ?Promotion
    {
        return $this->promotion;
    }

    public function setPromotion(?Promotion $promotion): self
    {
        $this->promotion = $promotion;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
