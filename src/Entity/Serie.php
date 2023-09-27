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
        private ?string $publicationDate;
        private ?string $status;
        private ?boolean $isAdult;

        private Collection $theme;
        private Collection $actor;
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
     * @param string|null $publicationDate
     * @param string|null $status
     * @param bool|null $isAdult
     */

    public function __construct(){
        $this->theme = new ArrayCollection();
        $this->actor = new ArrayCollection();
        $this->opinion = new ArrayCollection();
    }

    public function ___construct(?int $id, ?string $name, ?int $nbSeason, ?string $language, ?int $nbEpisodes, ?int $nbRates, ?string $country, ?string $image, ?string $realisation, ?string $publicationDate, ?string $status, ?bool $isAdult)
    {
        $this->id = $id;
        $this->name = $name;
        $this->nbSeason = $nbSeason;
        $this->language = $language;
        $this->nbEpisodes = $nbEpisodes;
        $this->nbRates = $nbRates;
        $this->country = $country;
        $this->image = $image;
        $this->realisation = $realisation;
        $this->publicationDate = $publicationDate;
        $this->status = $status;
        $this->isAdult = $isAdult;
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

    public function getNbSeason(): ?int
    {
        return $this->nbSeason;
    }

    public function setNbSeason(?int $nbSeason): void
    {
        $this->nbSeason = $nbSeason;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(?string $language): void
    {
        $this->language = $language;
    }

    public function getNbEpisodes(): ?int
    {
        return $this->nbEpisodes;
    }

    public function setNbEpisodes(?int $nbEpisodes): void
    {
        $this->nbEpisodes = $nbEpisodes;
    }

    public function getNbRates(): ?int
    {
        return $this->nbRates;
    }

    public function setNbRates(?int $nbRates): void
    {
        $this->nbRates = $nbRates;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): void
    {
        $this->country = $country;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    public function getRealisation(): ?string
    {
        return $this->realisation;
    }

    public function setRealisation(?string $realisation): void
    {
        $this->realisation = $realisation;
    }

    public function getPublicationDate(): ?string
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(?string $publicationDate): void
    {
        $this->publicationDate = $publicationDate;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    public function getIsAdult(): ?bool
    {
        return $this->isAdult;
    }

    public function setIsAdult(?bool $isAdult): void
    {
        $this->isAdult = $isAdult;
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

}
