<?php

namespace App\Entity;

use App\Repository\TransactionVendeurRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: TransactionVendeurRepository::class)]
class TransactionVendeur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $montant = null;

    #[ORM\Column(length: 50)]
    private ?string $moyen_transfert = null;

    #[ORM\Column(length: 50)]
    private ?string $statut = null;

    #[ORM\Column(type: 'datetime')]
    #[Gedmo\Timestampable(on: 'create')]
    private \DateTimeInterface $dateCreation;

    #[ORM\Column(type: 'datetime')]
    #[Gedmo\Timestampable(on: 'update')]
    private \DateTimeInterface $dateMiseAJour;

    // === Relations === //
    // CommandeVendeur
    #[ORM\OneToMany(mappedBy: 'transaction', targetEntity: CommandeVendeur::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
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
            $commande->setTransaction($this);
        }

        return $this;
    }

    public function removeCommandeVendeur(CommandeVendeur $commande): static
    {
        if ($this->commandesVendeur->removeElement($commande)) {
            if ($commande->getTransaction() === $this) {
                $commande->setTransaction(null);
            }
        }

        return $this;
    }

    //Plateforme
    #[ORM\ManyToOne(targetEntity: Plateforme::class, inversedBy: 'transactions')]
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


    /**
     * Getters and Setters
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getMoyenTransfert(): ?string
    {
        return $this->moyen_transfert;
    }

    public function setMoyenTransfert(string $moyen_transfert): static
    {
        $this->moyen_transfert = $moyen_transfert;

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
}
