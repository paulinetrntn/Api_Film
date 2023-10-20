<?php

namespace App\Entity;

use App\Repository\FavoriteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavoriteRepository::class)]
class Favorite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $idMovie = null;

    #[ORM\Column(nullable: true)]
    private ?int $idSerie = null;

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
}
