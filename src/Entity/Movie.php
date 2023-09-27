<?php
namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping\Entity;
use phpDocumentor\Reflection\Types\Boolean;


class Movie {

    private ?int $id;
    private ?string $title;
    private ?string $image;
    private ?bool $isVideo;
    private ?string $language;
    private ?bool $isAdult;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Movie
    {
        $this->id = $id;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): Movie
    {
        $this->title = $title;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): Movie
    {
        $this->image = $image;
        return $this;
    }

    public function getIsVideo(): ?bool
    {
        return $this->isVideo;
    }

    public function setIsVideo(?bool $isVideo): Movie
    {
        $this->isVideo = $isVideo;
        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(?string $language): Movie
    {
        $this->language = $language;
        return $this;
    }

    public function getIsAdult(): ?bool
    {
        return $this->isAdult;
    }

    public function setIsAdult(?bool $isAdult): Movie
    {
        $this->isAdult = $isAdult;
        return $this;
    }

    public function getReleaseDate(): ?DateTime
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(?DateTime $releaseDate): Movie
    {
        $this->releaseDate = $releaseDate;
        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(?int $note): Movie
    {
        $this->note = $note;
        return $this;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(?string $synopsis): Movie
    {
        $this->synopsis = $synopsis;
        return $this;
    }
    private ?DateTime $releaseDate;
    private ?int $note;
    private ?String $synopsis;


    public function __construct()
    {

    }


}
