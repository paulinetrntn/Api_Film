<?php

namespace App\Entity;

use App\Repository\AvisRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvisRepository::class)]
class Avis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $idMovie = null;

    #[ORM\Column(nullable: true)]
    private ?int $idSerie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $username = null;

    #[ORM\Column(nullable: true)]
    private ?int $rates = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date = null;

    //BDD Form Avis
    /**
     * @ORM\ManyToOne(targetEntity=Serie::class, inversedBy="avis")
     * @ORM\JoinColumn(nullable=false)
     */
    private $serie;

    /**
     * @ORM\ManyToOne(targetEntity=Movie::class, inversedBy="avis")
     * @ORM\JoinColumn(nullable=false)
     */
    private $movie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdMovie(): ?int
    {
        return $this->idMovie;
    }

    public function setIdMovie(?int $idMovie): static
    {
        $this->idMovie = $idMovie;
        return $this;
    }

    public function getIdSerie(): ?int
    {
        return $this->idSerie;
    }

    public function setIdSerie(?int $idSerie): static
    {
        $this->idSerie = $idSerie;
        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): static
    {
        $this->username = $username;
        return $this;
    }

    public function getRates(): ?int
    {
        return $this->rates;
    }

    public function setRates(?int $rates): static
    {
        $this->rates = $rates;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): static
    {
        $this->date = $date;
        return $this;
    }
}
