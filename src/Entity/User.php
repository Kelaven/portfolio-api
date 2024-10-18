<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $isAdmin = null;

    #[ORM\Column(length: 50)]
    private ?string $identifiant = null;

    #[ORM\Column(length: 50)]
    private ?string $password = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $confirmed_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deleted_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isAdmin(): ?bool
    {
        return $this->isAdmin;
    }

    public function setAdmin(bool $isAdmin): static
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    public function getIdentifiant(): ?string
    {
        return $this->identifiant;
    }

    public function setIdentifiant(string $identifiant): static
    {
        $this->identifiant = $identifiant;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getConfirmedAt(): ?\DateTimeImmutable
    {
        return $this->confirmed_at;
    }

    public function setConfirmedAt(?\DateTimeImmutable $confirmed_at): static
    {
        $this->confirmed_at = $confirmed_at;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(?\DateTimeImmutable $deleted_at): static
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }
}
