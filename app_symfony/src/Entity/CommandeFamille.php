<?php

namespace App\Entity;

use App\Repository\CommandeFamilleRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Famille;
use App\Entity\Paiement;
use App\Entity\Cagnotte;
use App\Entity\CommandeVendeur;

#[ORM\Entity(repositoryClass: CommandeFamilleRepository::class)]
class CommandeFamille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $statut = null;

    #[ORM\Column(type: 'datetime')]
    #[Gedmo\Timestampable(on: 'create')]
    private \DateTimeInterface $dateCreation;

    #[ORM\Column(type: 'datetime')]
    #[Gedmo\Timestampable(on: 'update')]
    private \DateTimeInterface $dateMiseAJour;

    #[ORM\ManyToOne(targetEntity: Famille::class, inversedBy: 'commandesfamille')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Famille $famille = null;

    #[ORM\ManyToOne(targetEntity: Paiement::class, inversedBy: 'commandesFamille')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Paiement $paiement = null;

    #[ORM\OneToOne(mappedBy: 'commandeFamille', targetEntity: Cagnotte::class, cascade: ['persist', 'remove'])]
    private ?Cagnotte $cagnotte = null;

    #[ORM\OneToMany(mappedBy: 'commandeFamille', targetEntity: CommandeVendeur::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $commandesVendeur;

    public function __construct()
    {
        $this->commandesVendeur = new ArrayCollection();
    }

    /**
     * @return Collection<int, CommandeVendeur>
     */
    public function getCommandesVendeur(): Collection
    {
        return $this->commandesVendeur;
    }

    public function addCommandeVendeur(CommandeVendeur $commande): static
    {
        if (!$this->commandesVendeur->contains($commande)) {
            $this->commandesVendeur[] = $commande;
            $commande->setCommandeFamille($this);
        }

        return $this;
    }

    public function removeCommandeVendeur(CommandeVendeur $commande): static
    {
        if ($this->commandesVendeur->removeElement($commande)) {
            if ($commande->getCommandeFamille() === $this) {
                $commande->setCommandeFamille(null);
            }
        }

        return $this;
    }


    public function getCagnotte(): ?Cagnotte
    {
        return $this->cagnotte;
    }

    public function setCagnotte(?Cagnotte $cagnotte): static
    {
        $this->cagnotte = $cagnotte;
        // Synchronisation inverse
        if ($cagnotte && $cagnotte->getCommandeFamille() !== $this) {
            $cagnotte->setCommandeFamille($this);
        }
        return $this;
    }


    public function getId(): ?int
    {
        return $this->id;
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

    public function getFamille(): ?Famille
    {
        return $this->famille;
    }

    public function setFamille(?Famille $famille): static
    {
        $this->famille = $famille;
        return $this;
    }

    public function getPaiement(): ?Paiement
    {
        return $this->paiement;
    }

    public function setPaiement(?Paiement $paiement): static
    {
        $this->paiement = $paiement;
        return $this;
    }
}
