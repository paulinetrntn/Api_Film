<?php
namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping\Entity;
use phpDocumentor\Reflection\Types\Boolean;


class Opinion
{
    private ?int $id;
    private ?int $rating;
    private ?string $content;
    private ?string $username;
    private ?string $avatarPath;

    /**
     * @param int|null $id
     * @param int|null $rating
     * @param string|null $content
     * @param string|null $username
     * @param string|null $avatarPath
     */
    public function __construct(?int $id, ?int $rating, ?string $content, ?string $username,?string $avatarPath)
    {
        $this->id = $id;
        $this->rating = $rating;
        $this->content = $content;
        $this->username = $username;
        $this->avatarPath = $avatarPath;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): Opinion
    {
        $this->rating = $rating;
        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): Opinion
    {
        $this->content = $content;
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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    public function getAvatarPath(): ?string
    {
        return $this->avatarPath;
    }

    public function setAvatarPath(?string $avatarPath): Opinion
    {
        $this->avatarPath = $avatarPath;
        return $this;
    }
}