<?php
namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping\Entity;
use phpDocumentor\Reflection\Types\Boolean;
use Doctrine\Common\Collections\ArrayCollection;

class Actor {
    private ?int $id;
    private ?string $name;
    private ?string $urlPicture;
    private ?string $gender;
    private ?string $biography;
    private ArrayCollection $movies;

    public function __construct($id, $gender, $urlPicture, $name)
    {
        $this->id = $id;
        $this->gender = $gender;
        $this->name = $name;
        $this->urlPicture = $urlPicture;
        $this->movies = new ArrayCollection();
    }

    public function getUrlPicture(): ?string
    {
        return $this->urlPicture;
    }

    public function setUrlPicture(?string $urlPicture): Actor
    {
        $this->urlPicture = $urlPicture;
        return $this;
    }

    public function getMovies(): ArrayCollection
    {
        return $this->movies;
    }

    public function setMovies(ArrayCollection $movies): Actor
    {
        $this->movies = $movies;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): void
    {
        $this->gender = $gender;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function setBiography(?string $biography): void
    {
        $this->biography = $biography;
    }
}