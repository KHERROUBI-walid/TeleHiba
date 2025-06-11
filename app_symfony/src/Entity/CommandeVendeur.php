<?php

namespace App\Entity;

use App\Repository\CommandeVendeurRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: CommandeVendeurRepository::class)]
class CommandeVendeur
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

    #[ORM\Column(nullable: true)]
    private ?float $total_commandeV = null;

    // === Relations === //
    // CommandeeFamille
    #[ORM\ManyToOne(targetEntity: CommandeFamille::class, inversedBy: 'commandesVendeur')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CommandeFamille $commandeFamille = null;

    public function getCommandeFamille(): ?CommandeFamille
    {
        return $this->commandeFamille;
    }

    public function setCommandeFamille(?CommandeFamille $commandeFamille): static
    {
        $this->commandeFamille = $commandeFamille;
        return $this;
    }

    //
    // LigneProduit
    #[ORM\OneToMany(mappedBy: 'commandeVendeur', targetEntity: LigneProduit::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $lignes;

    public function __construct()
    {
        $this->lignes = new ArrayCollection();
    }

    /**
     * @return Collection<int, LigneProduit>
     */
    public function getLignes(): Collection
    {
        return $this->lignes;
    }

    public function addLigne(LigneProduit $ligne): static
    {
        if (!$this->lignes->contains($ligne)) {
            $this->lignes[] = $ligne;
            $ligne->setCommandeVendeur($this);
        }

        return $this;
    }

    public function removeLigne(LigneProduit $ligne): static
    {
        if ($this->lignes->removeElement($ligne)) {
            if ($ligne->getCommandeVendeur() === $this) {
                $ligne->setCommandeVendeur(null);
            }
        }

        return $this;
    }

    //TransactionVendeur
    #[ORM\ManyToOne(targetEntity: TransactionVendeur::class, inversedBy: 'commandesVendeur')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TransactionVendeur $transaction = null;

    public function getTransaction(): ?TransactionVendeur
    {
        return $this->transaction;
    }

    public function setTransaction(?TransactionVendeur $transaction): static
    {
        $this->transaction = $transaction;
        return $this;
    }



    // === Getters et Setters === //
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

    public function getTotalCommandeV(): ?float
    {
        return $this->total_commandeV;
    }

    public function setTotalCommandeV(float $total_commandeV): static
    {
        $this->total_commandeV = $total_commandeV;

        return $this;
    }
}
