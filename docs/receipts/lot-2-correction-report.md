# Lot 2 — Rapport de correction de gestion de menu

## Statut

> **Statut : partiel, non déclaré conforme.** Les corrections de fiabilité ont été implémentées dans le thème actif, mais la recette connectée complète doit être rejouée avec une session vendeur portable disponible.

| Correction | État | Contrôle appliqué |
| --- | --- | --- |
| Rechargement aveugle après publication | Corrigé | Rafraîchissement contrôlé de la liste de menu côté cockpit |
| Double clic de publication | Corrigé côté client et serveur | Clé d’idempotence et verrou temporaire métier |
| Mise à jour immédiate du menu | Corrigée | Endpoint authentifié et insertion sécurisée du plat publié |
| Aide WhatsApp | Centralisée | Résolution côté serveur, sans numéro de repli dans le navigateur |
| Contrôles de propriété | Préservés | Vérifications WooCommerce/WCFM existantes conservées |

Le wizard ne dépend plus de `window.location.reload()` pour annoncer une publication. Il sollicite une mise à jour contrôlée du menu, bloque les soumissions concurrentes et conserve les erreurs exploitables. La résolution d’aide WhatsApp est désormais partagée côté serveur ; si aucune configuration applicable n’existe, l’interface affiche un état explicite plutôt qu’une valeur codée en dur.

La validation complète du Lot 2 nécessite encore un parcours connecté vérifiant simultanément la création d’un plat, la limite Sauce à deux choix, le rendu client, l’imposition côté serveur et la protection contre la double soumission. Ce rapport ne déclare pas cette recette réussie en l’absence de session vendeur portable dans l’environnement courant.

## Références internes

[1] [Wizard vendeur](../../wordpress-theme/restocommerce/assets/js/vendor-product-wizard.js)  
[2] [Logique thème et endpoints](../../wordpress-theme/restocommerce/functions.php)

