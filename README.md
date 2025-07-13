# TeleHiba

# 🌍 Plateforme de Solidarité Directe

## 🧭 Vision

Cette plateforme vise à **réinventer l’aide humanitaire digitale** en mettant en relation directe des **personnes dans le besoin** et des **donateurs**, sans intermédiaire institutionnel ni fonds centralisés.

Elle repose sur une logique simple : **un besoin exprimé = une réponse directe, traçable et vérifiée**.

---

## ✅ Ce que propose la plateforme

* **Les bénéficiaires (familles)** expriment des besoins sous forme de commande
* **Les donateurs** choisissent une commande à financer
* **Les vendeurs locaux** préparent les produits
* **La plateforme perçoit le paiement**, puis **le reverse** au(x) vendeur(s) une fois la commande confirmée
* Chaque commande est **suivie, notée, et vérifiée**

---

## 🧩 Fonctionnalités principales

* 🎁 **Commandes multi-vendeurs**
* 💳 **Paiement sécurisé** via la plateforme (intermédiaire de confiance)
* 👥 **Traçabilité** des interactions : donateur ↔ plateforme ↔ vendeur ↔ bénéficiaire
* 🧾 **Évaluation post-livraison** par la famille
* 🚩 **Signalement des abus ou retards**
* 🔔 **Notifications intelligentes** (commande reçue, paiement validé, problème signalé…)
* 🌍 **Géolocalisation automatique** des bénéficiaires → priorisation par contexte
* 📊 **Historique des transactions et évaluations**

---

# 🔐 Modèle de paiement

⚠️ Contrairement aux plateformes classiques où les donateurs versent directement de l'argent aux bénéficiaires, notre approche est différente :

* La famille exprime ses **besoins** (et non une demande d'argent), ce qui :

  * Limite les risques d’arnaques
  * Permet de **limiter les besoins exprimés à un montant mensuel maximum**
* La **plateforme encaisse les paiements** en amont
* Elle agit comme un **tiers de confiance**, à la manière d’un portefeuille sécurisé (*wallet*)
* Une **transaction interne** vers le vendeur est déclenchée **uniquement après validation de la livraison**

### ✅ Ce système permet de :

* Gérer efficacement les **litiges**
* Regrouper les **contributions de plusieurs donateurs**

---

## 🧱 État d’avancement

* ✅ MCD complet
* ✅ Diagrammes de séquence bout-à-bout (commande, paiement, validation)
* ✅ Logique de modération, géolocalisation, évaluation implémentée
* 🔜 Maquette frontend en cours de réalisation

---

## 💡 Ce que cette plateforme change

| Plateformes classiques  | Cette plateforme                |
| ----------------------- | ------------------------------- |
| Don global à une ONG    | Paiement ciblé d’un besoin réel |
| Opacité                 | Traçabilité complète            |
| Vendeur inconnu         | Évalué, local, choisi           |
| Aucune vue géographique | Demandes triées par zone        |

---

## 📌 Cas d’usage

* **Catastrophes naturelles** : tremblements de terre, inondations
* **Famine ou crise sociale** : aide alimentaire à grande échelle
* **Guerre** : familles ayant besoin de médicaments, nourriture, couvertures
* **Besoin ponctuel** : réparation, chauffage, soins

---

## ⚙️ Stack technique

* **Backend** : Symfony (PHP)
* **Frontend** : Twig + Tailwind CSS + JS (Stimulus, Symfony UX React)
* **Paiement** : Stripe / PayPal / API bancaire locale
* **Cartographie & géoloc** : OpenStreetMap + Nominatim

---

## 📁 À venir

* Maquette interactive
* Connexion réelle à une passerelle de paiement
* Tableau d’administration / modération
* API publique pour intégration ONG / application mobile

---

## 🔒 Confidentialité

Ce dépôt contient une **architecture originale** et des éléments techniques stratégiques.
Veuillez ne pas redistribuer sans autorisation écrite.

---

## 📝 Licence

Projet non open-source pour l’instant – en cours de validation légale.
Possibilité de partenariat ou de présentation sur demande.

---

# 🚀 Lancement du projet (pour contributeurs)

Voici la procédure recommandée pour récupérer et lancer le projet localement dans l’environnement Dockerisé fourni.

### 📥 Cloner le dépôt

```bash
git clone https://github.com/KHERROUBI-walid/TeleHiba.git
cd TeleHiba
```

### 🐳 Construire et démarrer les conteneurs Docker

```bash
docker compose build
docker compose up -d
```

Ces commandes démarrent les services nécessaires définis dans `docker-compose.yml`, notamment :

* `hiba_php` : conteneur PHP/Symfony
* `hiba_frontend` : conteneur NodeJS pour le frontend

### 📦 Installer les dépendances PHP

Dans le conteneur PHP :

```bash
docker compose exec php composer install
```

### 📦 Installer les dépendances JavaScript

Dans le conteneur frontend :

```bash
docker compose exec frontend npm install
```

Puis npm run dev / npm run watch

### 🗝️ Variables d’environnement

Pensez à configurer vos variables d’environnement dans un fichier `.env.local` en vous basant sur le `.env`.

---

## 🔄 Bonnes pratiques de collaboration

* Ne pas travailler directement sur la branche `main`
* Créer une branche dédiée pour chaque nouvelle fonctionnalité ou correction :

```bash
git checkout -b nom-fonctionnalité
```

* Une fois le travail terminé sur votre branche :

  * Committez et poussez :

    ```bash
    git add .
    git commit -m "Ajout de la fonctionnalité X"
    git push origin nom-fonctionnalité
    ```
  * Créez une **Pull Request** sur GitHub pour demander la fusion dans `main`

* Relisez et testez les Pull Requests des autres avant d’approuver.

---

## 🔗 Ressources utiles

* [Symfony Docs](https://symfony.com/doc/current/index.html)
* [Docker Docs](https://docs.docker.com/)
* [GitHub Flow](https://docs.github.com/en/get-started/quickstart/github-flow)

---
