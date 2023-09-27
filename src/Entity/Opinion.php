<?php
namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping\Entity;
use phpDocumentor\Reflection\Types\Boolean;


class Opinion
{
    private ?int $id;
    private ?int $note;
    private ?string $comment;
    private ?string $username;

    /**
     * @param int|null $id
     * @param int|null $note
     * @param string|null $comment
     * @param string|null $username
     */
    public function __construct(?int $id, ?int $note, ?string $comment, ?string $username)
    {
        $this->id = $id;
        $this->note = $note;
        $this->comment = $comment;
        $this->username = $username;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(?int $note): void
    {
        $this->note = $note;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }




}