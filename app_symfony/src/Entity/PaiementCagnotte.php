<?php

namespace App\Entity;

use App\Repository\PaiementCagnotteRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: PaiementCagnotteRepository::class)]
class PaiementCagnotte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private float $montant;

    #[ORM\Column(length: 50)]
    private string $statut = 'effectue';

    #[ORM\Column(type: 'datetime')]
    #[Gedmo\Timestampable(on: 'create')]
    private \DateTimeInterface $dateCreation;

    #[ORM\ManyToOne(targetEntity: Donateur::class, inversedBy: 'paiementCagnottes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Donateur $donateur = null;

    #[ORM\ManyToOne(targetEntity: Cagnotte::class, inversedBy: 'paiements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cagnotte $cagnotte = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): static
    {
        $this->montant = $montant;
        return $this;
    }

    public function getStatut(): string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;
        return $this;
    }

    public function getDateCreation(): \DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): static
    {
        $this->dateCreation = $dateCreation;
        return $this;
    }

    public function getDonateur(): ?Donateur
    {
        return $this->donateur;
    }

    public function setDonateur(?Donateur $donateur): static
    {
        $this->donateur = $donateur;
        return $this;
    }

    public function getCagnotte(): ?Cagnotte
    {
        return $this->cagnotte;
    }

    public function setCagnotte(?Cagnotte $cagnotte): static
    {
        $this->cagnotte = $cagnotte;
        return $this;
    }

    public function __toString(): string
    {
        return sprintf("Don de %.2f € à la cagnotte #%d", $this->montant, $this->cagnotte?->getId());
    }
}
