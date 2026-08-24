# Lot 1 — Rapport de correction et de régression

## Statut

> **Statut : partiel, non déclaré conforme.** Les fondations de routage et d’accessibilité ont été corrigées et des contrôles de lecture seule ont été rejoués. Le seuil de performance CDC et la matrice cockpit connectée complète restent des bloquants documentés.

| Élément | État observé | Preuve privée |
| --- | --- | --- |
| Route canonique restaurant | Réussie sur Chromium, Firefox et WebKit aux quatre breakpoints CDC | `route-regression-artifacts/` |
| Redirection historique `/store/` | Réussie sur Chromium aux quatre breakpoints CDC | `route-regression-artifacts/` |
| Route restaurant inconnue | Réponse 404 éditoriale restaurée, sans page WCFM générique | Journal d’audit Lots 1–3 |
| Route panier, checkout et produit | Contrôle de recette borné ajouté ; matrice complète restant à rejouer | `scripts/run-route-regression.mjs` |
| Accessibilité | Les recettes précédentes ont relevé zéro violation axe-core sur les écrans couverts | Artéfacts privés des Lots 1–3 |
| Performance mobile | Non conforme au seuil CDC de 90 | Rapports Lighthouse 2.5.7–2.5.9 |

Les correctifs appliqués préservent la route publique canonique `/restaurant/{user_nicename}/`, redirigent les URLs WCFM historiques connues, et servent une 404 éditoriale aux slugs inconnus. La recette est strictement en lecture seule : elle ne crée, ne supprime, ne désactive, n’archive et ne modifie aucune donnée métier.

Le cockpit connecté n’a pas été rejoué dans cette phase, car les variables de session vendeur nécessaires à la recette portable ne sont pas présentes dans l’environnement. Aucun identifiant n’a été recherché ni reconstruit.

## Écart de performance

La fiche restaurant publique a été optimisée en retirant les styles WCFM/WooCommerce inutiles, en chargeant l’image héro native de manière responsive et en évitant un préchargement de la source PNG pleine taille. Les mesures les plus récentes conservent **Accessibilité 100**, **Bonnes pratiques 96** et **SEO 100**, mais le score Performance reste inférieur à 90 sous la latence observée du staging. Les valeurs sont volontairement maintenues comme écart ouvert.

## Références internes

[1] [Journal d’audit Lots 1–3](audit-lots-1-3-progress.md)  
[2] [Recette de régression de routes](../../scripts/run-route-regression.mjs)

