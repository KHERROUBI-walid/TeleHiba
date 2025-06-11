<?php

namespace App\Entity;

use App\Repository\NotificationRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: NotificationRepository::class)]
class Notification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $message = null;

    #[ORM\Column(length: 50)]
    private ?string $type = null;

    #[ORM\Column]
    private ?bool $vue = null;

    #[ORM\Column(type: 'datetime')]
    #[Gedmo\Timestampable(on: 'create')]
    private \DateTimeInterface $dateCreation;

    #[ORM\Column(type: 'datetime')]
    #[Gedmo\Timestampable(on: 'update')]
    private \DateTimeInterface $dateMiseAJour;

    // === Relations === //
    #[ORM\ManyToOne(inversedBy: 'notifications')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    // === Getters et Setters === //
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function isVue(): ?bool
    {
        return $this->vue;
    }

    public function setVue(bool $vue): static
    {
        $this->vue = $vue;

        return $this;
    }
    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $date): static
    {
        $this->dateCreation = $date;
        return $this;
    }

    public function getDateMiseAJour(): ?\DateTimeInterface
    {
        return $this->dateMiseAJour;
    }

    public function setDateMiseAJour(\DateTimeInterface $date): static
    {
        $this->dateMiseAJour = $date;
        return $this;
    }

    // === Relations  === //
    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }

    public function __toString(): string
    {
        return $this->message;
    }
}
