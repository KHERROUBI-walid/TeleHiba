<?php

namespace App\Entity;

use App\Repository\DonateurRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\User;
use App\Entity\Paiement;

#[ORM\Entity(repositoryClass: DonateurRepository::class)]
class Donateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?bool $estAnonyme = null;

    #[ORM\Column(nullable: true)]
    private ?float $montantTotalDon = null;

    #[ORM\OneToOne(inversedBy: 'donateur', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'donateur', targetEntity: Paiement::class, orphanRemoval: true)]
    private Collection $paiements;

    #[ORM\OneToMany(mappedBy: 'donateur', targetEntity: PaiementCagnotte::class, cascade: ['persist', 'remove'])]
    private Collection $paiementCagnottes;

    #[ORM\OneToMany(mappedBy: 'parrain', targetEntity: Famille::class)]
    private Collection $famillesParrainees;

    public function getFamillesParrainees(): Collection
    {
        return $this->famillesParrainees;
    }

    public function addFamilleParrainee(Famille $famille): static
    {
        if (!$this->famillesParrainees->contains($famille)) {
            $this->famillesParrainees[] = $famille;
            $famille->setParrain($this);
        }

        return $this;
    }

    public function removeFamilleParrainee(Famille $famille): static
    {
        if ($this->famillesParrainees->removeElement($famille)) {
            if ($famille->getParrain() === $this) {
                $famille->setParrain(null);
            }
        }

        return $this;
    }


    public function getPaiementCagnottes(): Collection
    {
        return $this->paiementCagnottes;
    }

    public function addPaiementCagnotte(PaiementCagnotte $paiement): static
    {
        if (!$this->paiementCagnottes->contains($paiement)) {
            $this->paiementCagnottes[] = $paiement;
            $paiement->setDonateur($this);
        }
        return $this;
    }

    public function removePaiementCagnotte(PaiementCagnotte $paiement): static
    {
        if ($this->paiementCagnottes->removeElement($paiement)) {
            if ($paiement->getDonateur() === $this) {
                $paiement->setDonateur(null);
            }
        }
        return $this;
    }


    public function __construct()
    {
        $this->paiements = new ArrayCollection();
        $this->famillesParrainees = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEstAnonyme(): ?bool
    {
        return $this->estAnonyme;
    }

    public function setEstAnonyme(?bool $estAnonyme): static
    {
        $this->estAnonyme = $estAnonyme;
        return $this;
    }

    public function getMontantTotalDon(): ?float
    {
        return $this->montantTotalDon;
    }

    public function setMontantTotalDon(?float $montantTotalDon): static
    {
        $this->montantTotalDon = $montantTotalDon;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        if ($this->user === $user) {
            return $this;
        }

        $this->user = $user;

        if ($user && $user->getDonateur() !== $this) {
            $user->setDonateur($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Paiement>
     */
    public function getPaiements(): Collection
    {
        return $this->paiements;
    }

    public function addPaiement(Paiement $paiement): static
    {
        if (!$this->paiements->contains($paiement)) {
            $this->paiements[] = $paiement;
            $paiement->setDonateur($this);
        }
        return $this;
    }

    public function removePaiement(Paiement $paiement): static
    {
        if ($this->paiements->removeElement($paiement)) {
            if ($paiement->getDonateur() === $this) {
                $paiement->setDonateur(null);
            }
        }
        return $this;
    }

    public function __toString(): string
    {
        return (string) $this->user; // Affiche l’utilisateur associé
    }
}
