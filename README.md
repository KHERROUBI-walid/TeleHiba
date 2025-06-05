# TeleHiba

# 🌍 Plateforme de Solidarité Directe

## 🧭 Vision

Cette plateforme vise à **réinventer l’aide humanitaire digitale** en mettant en relation directe des **personnes dans le besoin** et des **donateurs**, sans intermédiaire institutionnel ni fonds centralisés.

Elle repose sur une logique simple : **un besoin exprimé = une réponse directe, traçable et vérifiée**.

---

## ✅ Ce que propose la plateforme

- **Les bénéficiaires (familles)** expriment des besoins sous forme de commande
- **Les donateurs** choisissent une commande à financer
- **Les vendeurs locaux** préparent les produits
- **La plateforme perçoit le paiement**, puis **le reverse** au(x) vendeur(s) une fois la commande confirmée
- Chaque commande est **suivie, notée, et vérifiée**

---

## 🧩 Fonctionnalités principales

- 🎁 **Commandes multi-vendeurs**
- 💳 **Paiement sécurisé** via la plateforme (intermédiaire de confiance)
- 👥 **Traçabilité** des interactions : donateur ↔ plateforme ↔ vendeur ↔ bénéficiaire
- 🧾 **Évaluation post-livraison** par la famille
- 🚩 **Signalement des abus ou retards**
- 🔔 **Notifications intelligentes** (commande reçue, paiement validé, problème signalé…)
- 🌍 **Géolocalisation automatique** des bénéficiaires → priorisation par contexte
- 📊 **Historique des transactions et évaluations**

---

## 🔐 Modèle de paiement

> ⚠️ Contrairement aux plateformes où le donateur effectue un don (argent) directement au beneficiare, ici :

- La Famille demande des besoins, pas d'argent (evite des arnaques)(+montant des besoins par mois limité )
- La **plateforme encaisse d’abord** les paiements
- Elle agit comme **tiers de confiance** (type *wallet*)
- Une **transaction interne est déclenchée** vers le vendeur après validation de la livraison
- Cela permet de :
  - Gérer les cas de litiges
  - Regrouper les paiements de plusieurs donateurs

---

## 🧱 État d’avancement

- ✅ MCD complet (avec entités héritées, relations de composition, évaluations, transactions)
- ✅ Diagrammes de séquence bout-à-bout (commande, paiement, validation)
- ✅ Logique de modération, géolocalisation, évaluation implémentée
- 🔜 Maquette frontend

---

## 💡 Ce que cette plateforme change

| Plateformes classiques     | Cette plateforme                |
|---------------------------|----------------------------------|
| Don global à une ONG      | Paiement ciblé d’un besoin réel |
| Opacité                   | Traçabilité complète             |
| Vendeur inconnu           | Évalué, local, choisi            |
| Délai de plusieurs jours  | Traitement immédiat              |
| Aucune vue géographique   | Demandes triées par zone         |

---

## 📌 Cas d’usage

- **Guerre** (ex Ukraine) : familles ayant besoin de médicaments, nourriture, couvertures
- **Catastrophes naturelles** : tremblements de terre, inondations
- **Famine ou crise sociale** : aide alimentaire à grande échelle
- **Besoin ponctuel** : réparation, chauffage, soins

---

## ⚙️ Stack technique

- **Backend** : Symfony (PHP)
- **Frontend** : Twig + JS
- **Paiement** : Stripe / PayPal / API bancaire locale
- **Cartographie & géoloc** : OpenStreetMap + Nominatim

---

## 📁 À venir

- Maquette interactive
- Connexion réelle à une passerelle de paiement
- Tableau d’administration / modération
- API publique pour intégration ONG / application mobile

---

## 🔒 Confidentialité

Ce dépôt contient une **architecture originale** et des éléments techniques stratégiques.  
Veuillez ne pas redistribuer sans autorisation écrite.

---

## 📝 Licence

Projet non open-source pour l’instant – en cours de validation légale.  
Possibilité de partenariat ou de présentation sur demande.
