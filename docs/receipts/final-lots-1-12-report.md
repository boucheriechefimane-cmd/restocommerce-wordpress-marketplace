# Rapport final unique — Lots 1 à 12

**Date :** 24 août 2026  
**Staging :** WordPress / WooCommerce / WCFM  
**Thème actif vérifié :** RestoCommerce 2.7.4  
**Extensions métier actives de référence :** RestoCommerce Core 0.1.2, WhatsApp Checkout 0.1.2 et WCFM Bridge 0.1.2.

## Cadre de livraison

Les Lots 4 à 12 ont été traités dans l’ordre demandé après les corrections documentées des Lots 1 à 3. La règle de conservation a été respectée : cette passe n’a supprimé, désactivé, archivé, réinitialisé ou altéré aucun compte, produit, média, commande, avis, contenu de test ou extension du staging. Les remplacements de thème ont été effectués via le mécanisme WordPress, puis suivis d’une purge LiteSpeed.

Le tableau ci-dessous distingue explicitement une fonction **déployée**, une preuve **partielle** et un élément **en attente**. Un statut déployé ne signifie pas qu’une recette métier connectée a été réussie lorsque les accès nécessaires n’étaient pas disponibles.

| Lot | Livraison | Contrôles disponibles | Statut final |
|---:|---|---|---|
| 1 | Routes `/restaurant/{slug}/`, redirection legacy et 404 éditoriale | Matrice antérieure ; régression finale publique sans bloqueur | **Partiel** : cockpit connecté à rejouer |
| 2 | Assistant produit sans reload, idempotence et actualisation du menu | Syntaxe et contrôles antérieurs | **Partiel** : publication connectée à rejouer |
| 3 | Onboarding persistant, validation média/téléphone et profils | Contrôles antérieurs de source et de distribution | **Partiel** : reprise, téléphone réel et session expirée à rejouer |
| 4 | Tour trois étapes, aide contextuelle et support WhatsApp résolu | Syntaxe, invariants et distribution 2.6.0 | **Déployé, preuve connectée due** |
| 5 | Centre d’alertes vendeur, préférences son/vibration, rafraîchissement sans reload | Syntaxe, invariants et distribution 2.6.3 | **Déployé, événement de commande réel dû** |
| 6 | Suivi au reçu WooCommerce, clé native, états cuisine et lien WhatsApp conditionnel | Syntaxe, garde de clé et distribution 2.7.0 | **Déployé, reçu réel dû** |
| 7 | Avis vérifiés après commande terminée, résumé réel et signalement additif | Syntaxe, propriété et distribution 2.7.1 | **Déployé, commande terminée réelle due** |
| 8 | Cartes d’analyse fondées sur lignes WooCommerce réelles | Syntaxe, invariants de propriété et distribution 2.7.2 | **Déployé, rapprochement chiffré dû** |
| 9 | Quatre palettes par restaurant, persistance opt-in et contraste nominal | Script de contraste, syntaxe et distribution 2.7.3 | **Déployé, rendu connecté dû** |
| 10 | Système de design public complet | Inventaire et contrôle d’assainissement documentaire | **Documenté** |
| 11 | Recommandation checkout, sans code paiement | Sources officielles et contrôle d’absence de secrets | **Décision métier en attente** |
| 12 | Recette mobile dégradée publique et ajout panier isolé | Exécution Chromium réussie | **Partiel** : téléphone réel et cockpit vendeur dus |

## Éléments livrés par lot

### Lots 1 à 3 : fondations conservées, non surdéclarées

Le socle canonique, l’assistant produit et l’onboarding persistent restent déployés. Les rapports spécifiques conservent leurs limites : l’absence de variables vendeur portables interdit de déclarer la recette connectée achevée. La dernière optimisation de performance antérieure à cette passe mesurait environ **85** en Performance et un LCP d’environ **2,9 s** sur le storefront ; l’objectif CDC de Performance ≥90 ne peut donc pas être déclaré atteint.

### Lots 4 à 9 : cockpit, service et données réelles

Le cockpit comprend maintenant le tour de première prise en main, une aide toujours disponible, des notifications rattachées aux événements WooCommerce, le suivi public à partir de la clé de commande native, les avis uniquement après commande terminée, les analyses fondées sur les lignes réellement vendues et les palettes opt-in par restaurant. Les métadonnées de préférence, de notification, de signalement et de palette sont additives et limitées au restaurateur concerné. Aucune donnée de démonstration n’est introduite dans les avis, les notes, les ventes ou les tendances.

La version finale 2.7.4 ajoute un correctif de contraste public pour deux CTA de la fiche restaurant. Il charge une feuille ciblée seulement sur storefront ou produit et impose une encre claire sur les surfaces terre cuite concernées, y compris sous palette active.

### Lots 10 et 11 : règles et décision de paiement

Le système de design est disponible dans `docs/DESIGN-SYSTEM.md`. Il couvre les tokens, les palettes, la typographie, la cadence, les composants publics, le cockpit, les boutons, les cartes, les pills, les badges, les icônes, le focus, le clavier, le contraste, le mouvement et les états sans donnée.

La recommandation checkout est disponible dans `docs/CHECKOUT-DECISION.md`. Elle conserve le parcours WhatsApp et le suivi Lot 6, et recommande de ne pas intégrer de paiement tant que le responsable métier n’a pas validé le pays, la devise, l’entité encaissante, les reversements vendeurs, les moyens acceptés et la passerelle. Aucun secret, aucune passerelle, aucune carte et aucune transaction réelle n’ont été configurés.

### Lot 12 : parcours public sous contrainte

Une recette Chromium a simulé un viewport 390 × 844, une latence de 150 ms, 1,6 Mbps en descendant et un CPU ralenti ×4. Les trois routes publiques ont répondu en HTTP 200 et l’ajout panier a reçu un retour visuel dans une session navigateur jetable.

| Parcours simulé | TTFB | DOM prêt | Résultat |
|---|---:|---:|---|
| Marketplace | 3 831 ms | 6 227 ms | HTTP 200 |
| Fiche restaurant | 1 791 ms | 4 675 ms | HTTP 200 |
| Fiche produit | 780 ms | 2 809 ms | HTTP 200 |
| Ajout panier isolé | — | — | Retour visible en 1 570 ms |

Ces valeurs reflètent un seul profil simulé et la variabilité du staging. Elles ne sont ni une mesure téléphone réel, ni une validation de performance globale.

## Recette finale exécutée

| Contrôle | Résultat | Détail |
|---|---:|---|
| Syntaxe PHP du thème | Réussi | Tous les fichiers PHP du thème inspectés |
| Syntaxe JavaScript des scripts de recette | Réussi | Route, palette et Lot 12 |
| Contraste palettes | Réussi | Neuf couples nominaux validés par script |
| Régression Chromium | Réussi | 24 contrôles : 6 routes × 4 breakpoints |
| Régression Firefox | Réussi | 12 contrôles : canonique, legacy et 404 × 4 breakpoints |
| Régression WebKit | Réussi | 12 contrôles : canonique, legacy et 404 × 4 breakpoints |
| axe marketplace | Réussi | Aucune violation détectée |
| axe fiche restaurant | Réussi après correctif 2.7.4 | Aucune violation détectée |
| Archive 2.7.4 et distribution CSS | Réussi | Version et asset correctif vérifiés après purge |

## Limites restantes et décisions attendues

Le seul blocage récurrent est l’absence de variables ou de session vendeur explicitement autorisées. Cette contrainte a été respectée plutôt que contournée avec le compte de recette conservé. Les validations suivantes doivent être rejouées avec une session autorisée : tour et persistance, notifications réelles de commande, suivi de reçu, avis, signalement, chiffres d’analyse, palettes, ajout/modification produit, changement de statut et parcours clavier cockpit.

La validation humaine du téléphone réel reste due. La décision de paiement reste due : aucun code de carte ou portefeuille ne doit être écrit avant validation métier et choix de passerelle. Enfin, l’objectif Performance ≥90 reste **non conforme à ce stade** ; le TTFB variable du staging est le principal signal observé et une série de mesures sur environnement représentatif reste nécessaire.

| Décision / preuve attendue | Responsable attendu | Précondition |
|---|---|---|
| Recette vendeur complète | Exploitant habilité | Session vendeur explicitement autorisée |
| Test téléphone réel | Responsable opérationnel | Appareil physique et réseau cible |
| Décision paiement | Responsable métier | Pays, devise, encaissement, reversement et passerelle validés |
| Rebudget performance | Équipe technique | Environnement représentatif et mesures répétées |

## Documents associés

Les preuves par lot sont regroupées dans `docs/receipts/lot-1-correction-report.md` à `docs/receipts/lot-12-report.md`. Le présent fichier est le rapport de synthèse unique ; les artefacts bruts restent exclus du dépôt public.

