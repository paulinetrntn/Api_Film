<?php
namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping\Entity;
use phpDocumentor\Reflection\Types\Boolean;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;


class Serie {
        private ?int $id;
        private ?string $name;
        private ?int $nbSeason;
        private ?string $language;
        private ?int $nbEpisodes;
        private ?int $nbRates;
        private ?string $country;
        private ?string $image;
        private ?string $realisation;
        private ?DateTime $publicationDate;
        private ?string $status;
        private ?bool $isAdult;
        private ?string $overview;
        private Collection $theme;
        private Collection $actors;
        private Collection $opinion;


    /**
     * @param int|null $id
     * @param string|null $name
     * @param int|null $nbSeason
     * @param string|null $language
     * @param int|null $nbEpisodes
     * @param int|null $nbRates
     * @param string|null $country
     * @param string|null $image
     * @param string|null $realisation
     * @param DateTime|null $publicationDate
     * @param string|null $status
     * @param bool|null $isAdult
     * @param string|null $overview
     * @param Collection $theme
     * @param Collection $actor
     * @param Collection $opinion
     */
    public function __construct(?int $id, ?string $name, ?string $image,?int $nbSeason , ?string $language,?int $nbEpisodes,?int $nbRates,?string $country,?DateTime $publicationDate, ?string $overview,?bool $isAdult)
    {
        $this->id = $id;
        $this->name = $name;
        $this->image = $image;
        $this->nbSeason = $nbSeason;
        $this->language = $language;
        $this->nbEpisodes = $nbEpisodes;
        $this->nbRates = $nbRates;
        $this->country = $country;
        $this->publicationDate = $publicationDate;
        $this->overview =$overview;
        $this->isAdult =$isAdult;
        $this->theme = new ArrayCollection();
        $this->actors = new ArrayCollection();
        $this->opinion = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Serie
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): Serie
    {
        $this->name = $name;
        return $this;
    }

    public function getNbSeason(): ?int
    {
        return $this->nbSeason;
    }

    public function setNbSeason(?int $nbSeason): Serie
    {
        $this->nbSeason = $nbSeason;
        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(?string $language): Serie
    {
        $this->language = $language;
        return $this;
    }

    public function getNbEpisodes(): ?int
    {
        return $this->nbEpisodes;
    }

    public function setNbEpisodes(?int $nbEpisodes): Serie
    {
        $this->nbEpisodes = $nbEpisodes;
        return $this;
    }

    public function getNbRates(): ?int
    {
        return $this->nbRates;
    }

    public function setNbRates(?int $nbRates): Serie
    {
        $this->nbRates = $nbRates;
        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): Serie
    {
        $this->country = $country;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): Serie
    {
        $this->image = $image;
        return $this;
    }

    public function getRealisation(): ?string
    {
        return $this->realisation;
    }

    public function setRealisation(?string $realisation): Serie
    {
        $this->realisation = $realisation;
        return $this;
    }

    public function getPublicationDate(): ?DateTime
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(?DateTime $publicationDate): Serie
    {
        $this->publicationDate = $publicationDate;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): Serie
    {
        $this->status = $status;
        return $this;
    }

    public function getIsAdult(): ?bool
    {
        return $this->isAdult;
    }

    public function setIsAdult(?bool $isAdult): Serie
    {
        $this->isAdult = $isAdult;
        return $this;
    }

    public function getOverview(): ?string
    {
        return $this->overview;
    }

    public function setOverview(?string $overview): Serie
    {
        $this->overview = $overview;
        return $this;
    }








    public function getOpinions(): Collection
    {
        return $this->opinion;
    }
    public function addOpinions(Opinion $opinion): static
    {
        if($this->opinion->contains($opinion)){
            $this->opinion->add($opinion);
            $opinion->setSerie($this);
        }
        return $this;
    }

    public function removeOpinions(Opinion $opinion): static
    {
        if($this->opinion->removeElement($opinion)){
            if($opinion->getSerie()===$this){
                $opinion->setSerie(null);
            }

        }
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
