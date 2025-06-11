<?php

namespace App\Entity;

use App\Repository\LigneProduitRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: LigneProduitRepository::class)]
class LigneProduit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $quantite = null;

    #[ORM\Column]
    private ?float $prix_unitaire = null;

    #[ORM\Column]
    private ?float $total_ligne = null;

    #[ORM\Column]
    private ?bool $est_validee = null;

    #[ORM\Column(type: 'datetime')]
    #[Gedmo\Timestampable(on: 'create')]
    private \DateTimeInterface $dateCreation;

    #[ORM\Column(type: 'datetime')]
    #[Gedmo\Timestampable(on: 'update')]
    private \DateTimeInterface $dateMiseAJour;

    // === Relations === //
    #[ORM\ManyToOne(inversedBy: 'lignes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Produit $produit = null;

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): static
    {
        $this->produit = $produit;
        return $this;
    }

    // CommandeVendeur
    #[ORM\ManyToOne(targetEntity: CommandeVendeur::class, inversedBy: 'lignes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CommandeVendeur $commandeVendeur = null;

    public function getCommandeVendeur(): ?CommandeVendeur
    {
        return $this->commandeVendeur;
    }

    public function setCommandeVendeur(?CommandeVendeur $commandeVendeur): static
    {
        $this->commandeVendeur = $commandeVendeur;
        return $this;
    }


    // === Getters et Setters === //

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?float
    {
        return $this->quantite;
    }

    public function setQuantite(float $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPrixUnitaire(): ?float
    {
        return $this->prix_unitaire;
    }

    public function setPrixUnitaire(float $prix_unitaire): static
    {
        $this->prix_unitaire = $prix_unitaire;

        return $this;
    }

    public function getPrixLigne(): ?float
    {
        return $this->total_ligne;
    }

    public function setPrixLigne(float $total_ligne): static
    {
        $this->total_ligne = $total_ligne;

        return $this;
    }

    public function getEstValidee(): ?bool
    {
        return $this->est_validee;
    }
    public function setEstValidee(bool $est_validee): static
    {
        $this->est_validee = $est_validee;

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
