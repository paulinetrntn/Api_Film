<?php
namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping\Entity;
use phpDocumentor\Reflection\Types\Boolean;


class Movie {
    private ?int $id;
    private ?string $title;
    private ?string $image;
    private ?string $video;
    private ?string $language;
    private ?boolean $isAdult;
    private ?DateTime $realeaseDate;

    /**
     * @param int|null $id
     * @param string|null $title
     * @param string|null $image
     * @param string|null $video
     * @param string|null $language
     * @param bool|null $isAdult
     * @param DateTime|null $realeaseDate
     */
    public function __construct(?int $id, ?string $title, ?string $image, ?string $video, ?string $language, ?bool $isAdult, ?DateTime $realeaseDate)
    {
        $this->id = $id;
        $this->title = $title;
        $this->image = $image;
        $this->video = $video;
        $this->language = $language;
        $this->isAdult = $isAdult;
        $this->realeaseDate = $realeaseDate;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): void
    {
        $this->video = $video;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(?string $language): void
    {
        $this->language = $language;
    }

    public function getIsAdult(): ?bool
    {
        return $this->isAdult;
    }

    public function setIsAdult(?bool $isAdult): void
    {
        $this->isAdult = $isAdult;
    }

    public function getRealeaseDate(): ?DateTime
    {
        return $this->realeaseDate;
    }

    public function setRealeaseDate(?DateTime $realeaseDate): void
    {
        $this->realeaseDate = $realeaseDate;
    }



}
