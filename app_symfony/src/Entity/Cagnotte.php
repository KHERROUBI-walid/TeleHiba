<?php

namespace App\Entity;

use App\Repository\CagnotteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CagnotteRepository::class)]
class Cagnotte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private float $montantObjectif;

    #[ORM\Column]
    private float $montantActuel = 0;

    #[ORM\Column(length: 30)]
    private string $statut = 'en_cours';

    #[ORM\OneToMany(mappedBy: 'cagnotte', targetEntity: PaiementCagnotte::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $paiements;

    #[ORM\OneToOne(inversedBy: 'cagnotte', targetEntity: CommandeFamille::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?CommandeFamille $commandeFamille = null;

    public function __construct()
    {
        $this->paiements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantObjectif(): float
    {
        return $this->montantObjectif;
    }

    public function setMontantObjectif(float $montantObjectif): static
    {
        $this->montantObjectif = $montantObjectif;
        return $this;
    }

    public function getMontantActuel(): float
    {
        return $this->montantActuel;
    }

    public function setMontantActuel(float $montantActuel): static
    {
        $this->montantActuel = $montantActuel;
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

    /**
     * @return Collection<int, PaiementCagnotte>
     */
    public function getPaiements(): Collection
    {
        return $this->paiements;
    }

    public function addPaiement(PaiementCagnotte $paiement): static
    {
        if (!$this->paiements->contains($paiement)) {
            $this->paiements[] = $paiement;
            $paiement->setCagnotte($this);
        }
        return $this;
    }

    public function removePaiement(PaiementCagnotte $paiement): static
    {
        if ($this->paiements->removeElement($paiement)) {
            if ($paiement->getCagnotte() === $this) {
                $paiement->setCagnotte(null);
            }
        }
        return $this;
    }

    public function getCommandeFamille(): ?CommandeFamille
    {
        return $this->commandeFamille;
    }

    public function setCommandeFamille(?CommandeFamille $commande): static
    {
        $this->commandeFamille = $commande;

        // synchronisation inverse si nécessaire
        if ($commande && $commande->getCagnotte() !== $this) {
            $commande->setCagnotte($this);
        }

        return $this;
    }
}
