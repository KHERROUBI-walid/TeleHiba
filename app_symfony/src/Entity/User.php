<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Entity\Notification;
use App\Entity\Probleme;
use App\Entity\Famille;
use App\Entity\Donateur;
use App\Entity\Vendeur;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    // === Identifiants / Connexion ===
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    // === Type utilisateur ===
    #[ORM\Column(length: 15)]
    private ?string $typeUtilisateur = null;

    // === Infos personnelles ===
    #[ORM\Column(length: 10, nullable: true)]
    private ?string $civilite = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    private ?string $prenom = null;

    // === Coordonnées ===
    #[ORM\Column(length: 20, nullable: true)]
    private ?string $telephone = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $complAdresse = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $codePostal = null;

    #[ORM\Column(length: 70, nullable: true)]
    private ?string $ville = null;

    #[ORM\Column(length: 70, nullable: true)]
    private ?string $pays = null;

    // === Statut et dates système ===
    #[ORM\Column(length: 30, nullable: true)]
    private ?string $statut = null;

    #[ORM\Column]
    private bool $isVerified = false;

    #[ORM\Column(type: 'datetime')]
    #[Gedmo\Timestampable(on: 'create')]
    private \DateTimeInterface $dateCreation;

    #[ORM\Column(type: 'datetime')]
    #[Gedmo\Timestampable(on: 'update')]
    private \DateTimeInterface $dateMiseAJour;

    // === Relations ===

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Donateur $donateur = null;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Vendeur $vendeur = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Notification::class, orphanRemoval: true)]
    private Collection $notifications;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Probleme::class, orphanRemoval: true)]
    private Collection $problemes;

    public function __construct()
    {
        $this->notifications = new ArrayCollection();
        $this->problemes = new ArrayCollection();
    }

    // === Interface utilisateur / sécurité ===

    public function getId(): ?int { return $this->id; }

    public function getEmail(): ?string { return $this->email; }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    public function hasRole(string $role): bool
    {
        return in_array($role, $this->getRoles(), true);
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function eraseCredentials(): void {}

    // === Données personnelles ===

    public function getTypeUtilisateur(): ?string { return $this->typeUtilisateur; }

    public function setTypeUtilisateur(string $typeUtilisateur): static
    {
        $this->typeUtilisateur = $typeUtilisateur;
        return $this;
    }

    public function getCivilite(): ?string { return $this->civilite; }

    public function setCivilite(?string $civilite): static
    {
        $this->civilite = $civilite;
        return $this;
    }

    public function getNom(): ?string { return $this->nom; }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): ?string { return $this->prenom; }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getTelephone(): ?string { return $this->telephone; }

    public function setTelephone(?string $telephone): static
    {
        $this->telephone = $telephone;
        return $this;
    }

    public function getAdresse(): ?string { return $this->adresse; }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;
        return $this;
    }

    public function getComplAdresse(): ?string { return $this->complAdresse; }

    public function setComplAdresse(?string $complAdresse): static
    {
        $this->complAdresse = $complAdresse;
        return $this;
    }

    public function getCodePostal(): ?string { return $this->codePostal; }

    public function setCodePostal(?string $codePostal): static
    {
        $this->codePostal = $codePostal;
        return $this;
    }

    public function getVille(): ?string { return $this->ville; }

    public function setVille(?string $ville): static
    {
        $this->ville = $ville;
        return $this;
    }

    public function getPays(): ?string { return $this->pays; }

    public function setPays(?string $pays): static
    {
        $this->pays = $pays;
        return $this;
    }

    public function getStatut(): ?string { return $this->statut; }

    public function setStatut(?string $statut): static
    {
        $this->statut = $statut;
        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function getDateMiseAJour(): ?\DateTimeInterface
    {
        return $this->dateMiseAJour;
    }

    public function __toString(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }

    // === Relations familles/donateurs/vendeurs ===

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: Famille::class, cascade: ['persist', 'remove'])]
    private ?Famille $famille = null;

    public function getFamille(): ?Famille
    {
        return $this->famille;
    }

    public function setFamille(?Famille $famille): static
    {
        if ($this->famille === $famille) {
            return $this;
        }

        $this->famille = $famille;

        if ($famille && $famille->getUser() !== $this) {
            $famille->setUser($this);
        }

        return $this;
    }

    public function getDonateur(): ?Donateur
    {
        return $this->donateur;
    }

    public function setDonateur(?Donateur $donateur): static
    {
        if ($this->donateur === $donateur) {
            return $this;
        }

        $this->donateur = $donateur;

        if ($donateur && $donateur->getUser() !== $this) {
            $donateur->setUser($this);
        }

        return $this;
    }

    public function getVendeur(): ?Vendeur
    {
        return $this->vendeur;
    }

    public function setVendeur(?Vendeur $vendeur): static
    {
        if ($this->vendeur === $vendeur) {
            return $this;
        }

        $this->vendeur = $vendeur;

        if ($vendeur && $vendeur->getUser() !== $this) {
            $vendeur->setUser($this);
        }

        return $this;
    }

    // === Notifications ===

    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notification $notification): static
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications[] = $notification;
            $notification->setUser($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): static
    {
        if ($this->notifications->removeElement($notification)) {
            if ($notification->getUser() === $this) {
                $notification->setUser(null);
            }
        }

        return $this;
    }

    // === Problèmes ===

    public function getProblemes(): Collection
    {
        return $this->problemes;
    }

    public function addProbleme(Probleme $probleme): static
    {
        if (!$this->problemes->contains($probleme)) {
            $this->problemes[] = $probleme;
            $probleme->setUser($this);
        }

        return $this;
    }

    public function removeProbleme(Probleme $probleme): static
    {
        if ($this->problemes->removeElement($probleme)) {
            if ($probleme->getUser() === $this) {
                $probleme->setUser(null);
            }
        }

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}
