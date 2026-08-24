# Lot 12 — Comportement sur appareil et réseau dégradés

**Date de mesure :** 24 août 2026  
**Thème public au moment de la mesure :** RestoCommerce 2.7.3 ; correctif visuel transversal 2.7.4 déployé après cette mesure  
**Recette :** `scripts/run-lot-12-degraded.mjs`  
**Mode :** session publique isolée, fermée à la fin de la mesure.

## Profil simulé

La recette utilise Chromium avec un viewport de 390 × 844 px, une latence ajoutée de 150 ms, un débit descendant de 1,6 Mbps, un débit montant de 750 Kbps et un ralentissement CPU ×4. Ce profil est une simulation de stress utile pour comparer les parcours publics ; il ne représente pas une validation sur téléphone réel ni une promesse de temps de chargement universel.

| Parcours | HTTP / état | TTFB | DOM prêt | Ajout panier / retour |
|---|---:|---:|---:|---:|
| Marketplace | 200 | 3 831 ms | 6 227 ms | — |
| Fiche restaurant canonique | 200 | 1 791 ms | 4 675 ms | — |
| Fiche produit | 200 | 780 ms | 2 809 ms | — |
| Ajout panier isolé | Effectué | — | — | 1 570 ms, retour visible |

Le run réussi est enregistré sous `docs/receipts/lot-12-artifacts/2026-08-24T03-47-05-925Z/`. Ce dossier reste ignoré du dépôt public. Il ne contient ni mot de passe, ni cookie exporté, ni commande, ni contenu HTML de session.

## Résultat et interprétation

Les trois routes publiques ont répondu en HTTP 200 et l’ajout au panier a reçu un retour visuel dans une session neuve et éphémère. Aucun compte vendeur n’a été ouvert. L’ajout panier n’a créé aucune commande, n’a touché aucun produit et n’a persisté qu’au niveau de la session navigateur détruite en fin de recette.

Les temps mesurés sont significativement pénalisés par le TTFB du staging, notamment sur la marketplace. Ils ne permettent pas de déclarer une conformité de performance globale, et confirment que le seuil public Performance ≥90 / LCP de référence reste non atteint dans les mesures précédentes. Les résultats sont cohérents avec une infrastructure de staging variable et doivent être rejoués sur un environnement représentatif avant toute promesse de performance.

| Exigence de parcours | État de preuve | Limite |
|---|---|---|
| Marketplace, fiche restaurant et fiche produit publics | Mesuré en profil dégradé | Un seul moteur et une seule exécution réussie |
| Ajouter au panier | Mesuré, session isolée | Ne vérifie pas le checkout complet ni une commande réelle |
| Ajouter ou modifier un produit | Non mesuré | Requiert une session vendeur autorisée |
| Changer le statut de service ou de commande | Non mesuré | Requiert une session vendeur autorisée et modifierait des données métier |
| Téléphone réel | Non mesuré | Simulation navigateur uniquement |

> **Statut : parcours public et ajout panier mesurés sans mutation métier ; performance globale et recette vendeur dégradée non déclarées conformes.**
