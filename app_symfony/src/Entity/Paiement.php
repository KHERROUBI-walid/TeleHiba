<?php

namespace App\Entity;

use App\Repository\PaiementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: PaiementRepository::class)]
class Paiement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $montantTotal = null;

    #[ORM\Column(length: 150)]
    private ?string $moyenPaiement = null;

    #[ORM\Column(length: 50)]
    private ?string $statut = null;

    #[ORM\Column(type: 'datetime')]
    #[Gedmo\Timestampable(on: 'create')]
    private \DateTimeInterface $dateCreation;

    #[ORM\Column(type: 'datetime')]
    #[Gedmo\Timestampable(on: 'update')]
    private \DateTimeInterface $dateMiseAJour;

    #[ORM\ManyToOne(targetEntity: Donateur::class, inversedBy: 'paiements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Donateur $donateur = null;

    #[ORM\OneToMany(mappedBy: 'paiement', targetEntity: CommandeFamille::class, cascade: ['persist', 'remove'])]
    private Collection $commandesFamille;

    #[ORM\ManyToOne(targetEntity: Plateforme::class, inversedBy: 'paiements')]
    private ?Plateforme $plateforme = null;

    public function getPlateforme(): ?Plateforme
    {
        return $this->plateforme;
    }

    public function setPlateforme(?Plateforme $plateforme): static
    {
        $this->plateforme = $plateforme;
        return $this;
    }


    public function __construct()
    {
        $this->commandesFamille = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantTotal(): ?float
    {
        return $this->montantTotal;
    }

    public function setMontantTotal(float $montantTotal): static
    {
        $this->montantTotal = $montantTotal;
        return $this;
    }

    public function getMoyenPaiement(): ?string
    {
        return $this->moyenPaiement;
    }

    public function setMoyenPaiement(string $moyenPaiement): static
    {
        $this->moyenPaiement = $moyenPaiement;
        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;
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

    public function getDonateur(): ?Donateur
    {
        return $this->donateur;
    }

    public function setDonateur(?Donateur $donateur): static
    {
        $this->donateur = $donateur;
        if ($donateur && !$donateur->getPaiements()->contains($this)) {
            $donateur->addPaiement($this);
        }
        return $this;
    }

    /**
     * @return Collection<int, CommandeFamille>
     */
    public function getCommandesFamille(): Collection
    {
        return $this->commandesFamille;
    }

    public function addCommandesFamille(CommandeFamille $commande): static
    {
        if (!$this->commandesFamille->contains($commande)) {
            $this->commandesFamille[] = $commande;
            $commande->setPaiement($this);
        }

        return $this;
    }

    public function removeCommandesFamille(CommandeFamille $commande): static
    {
        if ($this->commandesFamille->removeElement($commande)) {
            if ($commande->getPaiement() === $this) {
                $commande->setPaiement(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return sprintf("Paiement #%d - %.2f €", $this->id, $this->montantTotal ?? 0);
    }
}
