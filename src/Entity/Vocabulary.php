<?php

namespace App\Entity;

use App\Repository\VocabularyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VocabularyRepository::class)
 */
class Vocabulary
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $french;

    /**
     * @ORM\Column(type="text")
     */
    private $english;

    /**
     * @ORM\Column(type="text")
     */
    private $englishWrongOne;

    /**
     * @ORM\Column(type="text")
     */
    private $englishWrongTwo;

    /**
     * @ORM\Column(type="text")
     */
    private $englishWrongThree;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="vocabularies")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="vocabularies")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFrench(): ?string
    {
        return $this->french;
    }

    public function setFrench(string $french): self
    {
        $this->french = $french;

        return $this;
    }

    public function getEnglish(): ?string
    {
        return $this->english;
    }

    public function setEnglish(string $english): self
    {
        $this->english = $english;

        return $this;
    }

    public function getEnglishWrongOne(): ?string
    {
        return $this->englishWrongOne;
    }

    public function setEnglishWrongOne(string $englishWrongOne): self
    {
        $this->englishWrongOne = $englishWrongOne;

        return $this;
    }

    public function getEnglishWrongTwo(): ?string
    {
        return $this->englishWrongTwo;
    }

    public function setEnglishWrongTwo(string $englishWrongTwo): self
    {
        $this->englishWrongTwo = $englishWrongTwo;

        return $this;
    }

    public function getEnglishWrongThree(): ?string
    {
        return $this->englishWrongThree;
    }

    public function setEnglishWrongThree(string $englishWrongThree): self
    {
        $this->englishWrongThree = $englishWrongThree;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

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
