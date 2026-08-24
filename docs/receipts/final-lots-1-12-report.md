# Rapport final unique — Lots 1 à 12

**Date :** 24 août 2026  
**Staging :** WordPress / WooCommerce / WCFM  
**Thème actif contrôlé :** RestoCommerce **2.7.13**
**Révision publique :** synchronisation GitHub à effectuer après l’audit sanitaire final ; aucun SHA distant non vérifié n’est déclaré dans ce rapport.

## Règle de lecture

> Un statut **connecté vérifié** signifie qu’une action réelle a été effectuée sur des données de recette isolées, puis restaurée ou nettoyée lorsque le scénario le permet. Il ne vaut pas certification globale lorsque subsistent des limites de performance, d’appareil physique ou de décision métier.

| Lot | Livraison | Preuve disponible | Statut factuel |
|---:|---|---|---|
| 1 | Routes, accessibilité et cockpit vendeur | Matrice connectée Chromium / Firefox / WebKit, 4 formats, axe, focus, tabs et restauration service | **Connecté vérifié pour le périmètre testé** |
| 2 | Wizard produit, options et actualisation de menu | Création, rendu public, limites UI/serveur, duplication, bibliothèque, isolation, archive et 404 | **Connecté vérifié pour le périmètre testé** |
| 3 | Onboarding persistant et publication boutique | Déployé ; recette de persistance complète à rejouer | **Partiel** |
| 4 | Tour et aide vendeur | Déployé | **Déployé, preuve connectée étendue due** |
| 5 | Notifications vendeur | Déployé | **Déployé, événement de commande réel dû** |
| 6 | Suivi public de commande | Déployé | **Déployé, reçu réel dû** |
| 7 | Avis vérifiés et modération | Déployé | **Déployé, commande terminée réelle due** |
| 8 | Analyses vendeur | Déployé | **Déployé, rapprochement chiffré dû** |
| 9 | Palettes par restaurant | Déployé | **Déployé, isolation connectée due** |
| 10 | Système de design | Documenté | **Documenté** |
| 11 | Décision checkout | Documentée, sans paiement | **Décision métier en attente** |
| 12 | Parcours public dégradé | Recette navigateur simulée | **Partiel : téléphone réel et cockpit dus** |

## Actualisation Lots 1 et 2

Le Lot 1 a été rejoué en session vendeur réelle sur les trois moteurs aux quatre formats CDC. Aucune violation axe n’a été observée dans la matrice finale ; le focus est discernable, les onglets cockpit sont présents et la bascule de service est restaurée. Un incident transitoire de redirection WordPress a été isolé par reprise et reste distingué des résultats fonctionnels.[1]

Le Lot 2 a créé puis archivé des plats de recette. La règle Sauce maximum deux est imposée à la fois dans l’interface et côté serveur. La duplication, la bibliothèque et le rendu public ont été observés. Les défenses sans nonce et inter-vendeur ont été contrôlées sans modifier de données préexistantes ; les fixtures archivées ne sont plus accessibles publiquement.[2]

## Écarts et décisions encore ouverts

| Sujet | État | Condition de clôture |
|---|---|---|
| Performance ≥ 90 | Non conforme de façon reproductible sur le staging | Mesures répétées sur environnement représentatif avec budget de performance. |
| Téléphone réel et lecteur d’écran natif | Non vérifiés dans cette passe | Recette humaine sur appareils et technologies d’assistance cibles. |
| Paiement | Volontairement absent | Décision métier sur pays, devise, encaissement, reversement et passerelle. |
| Lots 3 à 9 connectés | Preuves variables selon lot | Recettes métier ciblées sur données réelles autorisées. |

Aucune transaction de paiement réelle n’a été initiée. Les archives de thème, captures brutes, nonces, cookies, identifiants et réponses réseau restent hors du dépôt public.

## Références

[1] [Rapport final Lot 1](lot-1-correction-report.md)
[2] [Rapport final Lot 2](lot-2-correction-report.md)
[3] [Recette publique renforcée](verification-renforcee-report.md)
