<?php
namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Entity;
use phpDocumentor\Reflection\Types\Boolean;


class Movie {
    private ?int $id;
    private ?string $title;
    private ?string $picturePath;
    private ?bool $isVideo;
    private ?string $originalLanguage;
    private ?bool $isAdult;
    private ?DateTime $releaseDate;
    private ?int $voteAverage;
    private ?String $overview;
    private ArrayCollection $actors;


    public function __construct($id, $title, $picturePath, $isVideo, $overview, $originalLanguage, $isAdult, $releaseDate, $voteAverage)
    {
        $this->id = $id;
        $this->title = $title;
        $this->picturePath = $picturePath;
        $this->isVideo = $isVideo;
        $this->overview = $overview;
        $this->originalLanguage = $originalLanguage;
        $this->isAdult = $isAdult;
        $this->releaseDate = $releaseDate;
        $this->voteAverage = $voteAverage;
        $this->actors = new ArrayCollection();
    }

    public function getActors(): ArrayCollection
    {
        return $this->actors;
    }

    public function setActors(ArrayCollection $actors): Movie
    {
        $this->actors = $actors;
        return $this;
    }

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

    public function getPicturePath(): ?string
    {
        return $this->picturePath;
    }

    public function setPicturePath(?string $picturePath): Movie
    {
        $this->picturePath = $picturePath;
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

    public function getOriginalLanguage(): ?string
    {
        return $this->originalLanguage;
    }

    public function setOriginalLanguage(?string $originalLanguage): Movie
    {
        $this->originalLanguage = $originalLanguage;
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

    public function getVoteAverage(): ?int
    {
        return $this->voteAverage;
    }

    public function setVoteAverage(?int $voteAverage): Movie
    {
        $this->voteAverage = $voteAverage;
        return $this;
    }

    public function getOverview(): ?string
    {
        return $this->overview;
    }

    public function setOverview(?string $overview): Movie
    {
        $this->overview = $overview;
        return $this;
    }

    public function addActor(Actor $actor):static{
        if(!$this->actors->contains($actor)){
            $this->actors->add($actor);
            //$actor->addMovie($this);
        }
        return $this;
    }

    public function removeActor(Actor $actor):static{
        if(!$this->actors->removeElement($actor)){
            //$actor->removeMovie($this);
        }
        return $this;
    }
}
