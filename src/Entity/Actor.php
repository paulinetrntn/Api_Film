<?php
namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping\Entity;
use phpDocumentor\Reflection\Types\Boolean;
use Doctrine\Common\Collections\ArrayCollection;


class Actor {

    private ?int $id;
    private ?string $name;
    private ?string $gender;
    private ?string $biography;


    public function __construct($id, $gender, $name)
    {
        $this->id = $id;
        $this->gender = $gender;
        $this->name = $name;
        $this->movies = new ArrayCollection();
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