<?php

namespace App\Entity;

use App\Repository\FamilleRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\CommandeFamille;
use App\Entity\User;
use App\Entity\Donateur;

#[ORM\Entity(repositoryClass: FamilleRepository::class)]
class Famille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $nombreMembres = null;

    #[ORM\Column(nullable: true)]
    private ?float $revenuMensuel = null;

    // === Relations === //
    // User
    #[ORM\OneToOne(inversedBy: 'famille', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    // CommandeFamille
    #[ORM\OneToMany(mappedBy: 'famille', targetEntity: CommandeFamille::class, orphanRemoval: true)]
    private Collection $commandesFamille;

    public function __construct()
    {
        $this->commandesFamille = new ArrayCollection();
        $this->evaluations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreMembres(): ?int
    {
        return $this->nombreMembres;
    }

    public function setNombreMembres(?int $nombreMembres): static
    {
        $this->nombreMembres = $nombreMembres;
        return $this;
    }

    public function getRevenuMensuel(): ?float
    {
        return $this->revenuMensuel;
    }

    public function setRevenuMensuel(?float $revenuMensuel): static
    {
        $this->revenuMensuel = $revenuMensuel;
        return $this;
    }

    // Parrain
    #[ORM\ManyToOne(inversedBy: 'famillesParrainees')]
    private ?Donateur $parrain = null;

    public function getParrain(): ?Donateur
    {
        return $this->parrain;
    }

    public function setParrain(?Donateur $parrain): static
    {
        $this->parrain = $parrain;
        return $this;
    }


    // Evaluations
    #[ORM\OneToMany(mappedBy: 'famille', targetEntity: Evaluation::class, orphanRemoval: true)]
    private Collection $evaluations;

    public function getEvaluations(): Collection
    {
        return $this->evaluations;
    }

    public function addEvaluation(Evaluation $evaluation): static
    {
        if (!$this->evaluations->contains($evaluation)) {
            $this->evaluations[] = $evaluation;
            $evaluation->setFamille($this);
        }

        return $this;
    }

    public function removeEvaluation(Evaluation $evaluation): static
    {
        if ($this->evaluations->removeElement($evaluation)) {
            if ($evaluation->getFamille() === $this) {
                $evaluation->setFamille(null);
            }
        }

        return $this;
    }
    //getter and setter
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

        if ($user && $user->getFamille() !== $this) {
            $user->setFamille($this);
        }

        return $this;
    }


    public function getCommandesFamille(): Collection
    {
        return $this->commandesFamille;
    }

    public function addCommandeFamille(CommandeFamille $commandeFamille): static
    {
        if (!$this->commandesFamille->contains($commandeFamille)) {
            $this->commandesFamille[] = $commandeFamille;
            $commandeFamille->setFamille($this);
        }

        return $this;
    }

    public function removeCommandeFamille(CommandeFamille $commandeFamille): static
    {
        if ($this->commandesFamille->removeElement($commandeFamille)) {
            if ($commandeFamille->getFamille() === $this) {
                $commandeFamille->setFamille(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return 'Famille #' . $this->id;
    }
}
