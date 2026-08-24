# Mise à jour marketplace

- [ ] Achever sans interruption les corrections, mesures et preuves des Lots 1 à 3 autorisés avant toute restitution finale, sans engager les Lots 4 à 12.
- [ ] Lots 4 à 12 — Réaliser chaque lot suivant le CDC maître, dans l’ordre, après documentation de la preuve du lot précédent et sans suppression ni altération de données existantes.
- [ ] Lots 4 à 12 — Déployer chaque correctif sur staging réel, exécuter les recettes multi-moteurs, accessibilité, performance et sécurité applicables, puis documenter tout écart résiduel.
- [ ] Programme final — Réunir les rapports publics assainis et les références d’artefacts privés des Lots 1 à 12 avant la restitution unique demandée.

- [x] Définir le contenu et les catégories de la page d’accueil marketplace.
- [x] Construire la découverte des restaurants avec recherche et filtres.
- [x] Ajouter des fiches restaurants et les liens vers la page de détail.
- [x] Réorganiser la navigation entre marketplace, restaurant et dashboard.
- [x] Vérifier les parcours sur ordinateur et mobile, puis livrer la mise à jour.

# Intégration WordPress Hostinger

- [x] Vérifier la session administrateur WordPress et l’état des extensions requises.
- [x] Installer et activer le thème RestoCommerce, le module WhatsApp et le pont WCFM.
- [x] Configurer l’accueil marketplace, WCFM, WooCommerce et la visibilité publique.
- [x] Contrôler le rendu public et identifier le numéro WhatsApp comme donnée propriétaire manquante.

# Démonstration marketplace complète

- [x] Définir dix concepts de restaurants, leurs cartes, prix et options de sauces.
- [x] Réutiliser les visuels culinaires déjà disponibles pour les restaurants et leurs plats phares.
- [x] Créer les comptes vendeurs WCFM, profils, menus WooCommerce et variations.
- [x] Lier les produits à leurs restaurants et préparer le checkout WhatsApp par défaut.
- [x] Vérifier l’affichage de la marketplace, les fiches et les options produits.

# Réutilisation des visuels existants

- [x] Localiser les visuels culinaires déjà disponibles dans le projet.
- [x] Créer les dix fichiers médias attendus par la démonstration à partir de ces visuels.
- [x] Téléverser les images dans WordPress et resynchroniser les profils et produits.

# Parité visuelle React → WordPress

- [x] Comparer précisément les gabarits React et WordPress actuels.
- [x] Porter les tokens, la typographie et les composants de navigation dans le thème WordPress.
- [x] Refaire la home marketplace et les cartes restaurant dans le style de la prévisualisation React.
- [x] Refaire la fiche restaurant, les cartes menus et le panier latéral avec WooCommerce.
- [x] Déployer le thème mis à jour puis comparer les parcours publics sur ordinateur et mobile.

# Disponibilité Hostinger avant déploiement

- [x] Vérifier la résolution DNS, le certificat TLS et la réponse HTTP du domaine de test.
- [x] Identifier l’état du site dans le tableau de bord Hostinger et réactiver le service si nécessaire.
- [x] Retrouver l’accès WordPress, installer RestoCommerce 0.2.1 et purger LiteSpeed Cache.

# Remédiation sans Cloudflare

- [x] Ne pas modifier les DNS ni ajouter de proxy Cloudflare pendant l’incident.
- [x] Vérifier dans hPanel le statut du CDN et du certificat SSL du domaine de test.
- [ ] Ouvrir un ticket Hostinger avec les preuves d’un point HTTPS intermittent seulement si l’incident réapparaît.

# Parité visuelle exhaustive React → WordPress

- [x] Répertorier les composants et comportements de chaque écran React de référence.
- [x] Installer et configurer les outils de capture, comparaison et contrôle visuel nécessaires dans le sandbox.
- [x] Recomposer la home WordPress avec une profondeur éditoriale, des modules de découverte et des états riches.
- [x] Remplacer la structure publique WCFM par un gabarit restaurant fidèle à la fiche React.
- [x] Refaire les pages produit, panier et checkout WooCommerce dans le même langage visuel.
- [x] Contrôler chaque page en desktop et mobile avant le déploiement final.

# Contrôles de commande

- [x] Vérifier une variation de sauce et son ajout au panier WooCommerce.
- [x] Vérifier que le checkout classique présente « Finaliser sur WhatsApp ».
- [ ] Réaliser une commande de test complète seulement après saisie volontaire d’une adresse de test.

# Quick view configurateur WooCommerce

- [x] Afficher les variations, radios, cases à cocher et conditions utiles directement dans le popup « Voir le plat », puis ajouter la configuration au panier sans ouvrir la fiche produit.
- [x] Renforcer le contraste de l’action secondaire « Voir le panier » dans le panier latéral mobile.
- [x] Conserver l’image produit complète, au format naturel, dans la colonne gauche du quick view desktop.
- [x] Rendre l’état désactivé « Ajouter au panier » concis et lisible avant le choix des options.
- [x] Transposer le configurateur éditorial du quick view directement sur les fiches produit WooCommerce variables.
- [x] Retirer l’aplat sombre résiduel autour de la photo complète dans la colonne gauche du quick view desktop.

# Validation configurateur 0.9.1

- [x] Vérifier sur mobile que l’état initial ne présente plus de plage de prix dans le bouton désactivé.
- [x] Vérifier sur mobile qu’une variation sélectionnée affiche un unique prix et active l’ajout direct au panier.

# Correction quick view mobile et panier latéral

- [x] Réintroduire une photo produit visible et proportionnée dans le quick view mobile.
- [x] Recomposer le panier latéral WordPress selon la hiérarchie, les marges et les actions de la maquette React.
- [x] Rejouer le parcours mobile hors cache avec la photo réintroduite et le nouveau panier éditorial.
- [x] Forcer le chargement immédiat des vignettes et renforcer le sous-titre de quantité dans le panier mobile.
- [x] Déployer RestoCommerce 1.0.2 sur le site de test avant le contrôle final des vignettes mobiles.
- [x] Attendre explicitement le rendu des vignettes dans le scénario de capture mobile avant la dernière preuve visuelle.

# Prévisualisation React

- [x] Vérifier la disponibilité de la prévisualisation React et redémarrer le serveur si nécessaire.
- [x] Confirmer l’affichage de la page marketplace React depuis le lien de prévisualisation.

# Démonstration dashboard vendeur

- [x] Vérifier les écrans dashboard React et le dashboard WCFM Hostinger.
- [x] Créer un accès vendeur de test dédié avec le rôle « Propriétaire du Magasin (Vendeur) ».
- [x] Vérifier la connexion isolée du vendeur de test et l’accès au dashboard WCFM.
- [x] Confirmer la disponibilité du rôle WordPress « Propriétaire du Magasin (Vendeur) » pour le compte de démonstration.
- [x] Valider l’authentification effective du mot de passe de démonstration dans une session indépendante.

# Refonte dashboard restaurateur premium

- [x] Auditer les écrans et actions WCFM réellement utilisés par un restaurateur sur mobile.
- [x] Définir une navigation quotidienne simplifiée : Aujourd’hui, Commandes, Menu et Boutique.
- [x] Créer un habillage RestoCommerce premium avec gros boutons tactiles, libellés explicites et états visuels rassurants.
- [x] Mettre en évidence les trois actions essentielles : accepter une commande, modifier un plat et ouvrir/fermer le restaurant.
- [x] Déployer l’habillage sur Hostinger et vérifier les parcours avec le compte vendeur de démonstration sur mobile.

> Vérification : le compte vendeur accède directement au cockpit RestoCommerce `1.1.2` actif, avec les trois actions quotidiennes visibles. Le statut de disponibilité a été passé en pause puis rouvert avec succès, laissant le restaurant de démonstration en service. Une finition locale `1.1.3` harmonise encore l’accueil desktop et mobile et reste prête pour une prochaine mise à jour d’administration.

# Remédiation urgente dashboard vendeur

- [ ] Reproduire les bugs sur la session vendeur réelle en desktop et mobile.
- [ ] Supprimer les doublons et zones WCFM techniques qui parasitent l’accueil simplifié.
- [ ] Vérifier que les actions « commandes », « ajouter un plat », « modifier le menu » et « pause » restent utilisables sans erreur.
- [ ] Corriger les ruptures de mise en page, les contrastes et les éléments non adaptés au tactile.
- [ ] Déployer une version stable puis rejouer le parcours vendeur complet.

> Correctif préparé : le cockpit est désormais limité à l’accueil, le panier client est retiré de l’espace vendeur, l’accueil masque le dashboard WCFM hérité, et les formulaires WCFM de gestion retrouvent une barre latérale fixe sur desktop.

# Dashboard vendeur dédié — parité React → WordPress

- [x] Analyser le cahier des charges complet et relever les structures exactes de `Dashboard.tsx`.
- [x] Remplacer le rendu natif WCFM de `/store-manager/` par un template PHP RestoCommerce dédié.
- [x] Connecter les cinq sections aux données réelles de la boutique, des commandes et des produits du vendeur.
- [x] Implémenter les actions métier réelles : disponibilité restaurant, avancement de commande et disponibilité produit.
- [x] Reproduire la sidebar desktop, les onglets mobiles, les cartes métriques, les commandes et le menu selon la référence.
- [x] Déployer le dashboard dédié puis vérifier sa parité visuelle et fonctionnelle avec le compte vendeur.

> Déploiement en cours : une session administrateur WordPress est active et le formulaire de téléversement du thème RestoCommerce 2.0.0 est ouvert.

> Le champ de fichier actif du formulaire de déploiement est repéré par l’index navigateur `124`.

> WordPress a reconnu l’archive comme une mise à jour du thème de `1.1.2` vers `2.0.0` et affiche le lien sécurisé de remplacement.

> Déploiement confirmé : Hostinger sert maintenant le thème RestoCommerce `2.0.0`.

> Correctif en cours : l’archive RestoCommerce `2.0.1` corrige la validation HTML du champ de stock WCFM masqué. Son formulaire WordPress de téléversement est prêt.

> L’archive 2.0.1 est téléversée et la procédure d’installation WordPress a été déclenchée ; la confirmation de remplacement est en cours de vérification.

> Contrôle de version : Hostinger sert encore `2.0.0`. Le lien de remplacement de l’archive 2.0.1 doit donc être exécuté explicitement dans la session administrateur.

> Le formulaire d’import WordPress a été rouvert et son champ de fichier est prêt pour une nouvelle soumission contrôlée de l’archive 2.0.1.

> Le lien WordPress signé de remplacement de l’archive 2.0.1 a été exécuté avec succès ; la version servie et l’ajout de plat doivent maintenant être rejoués en session vendeur isolée.

> Le correctif renforcé RestoCommerce `2.0.2` a été déployé par remplacement signé. La validation finale doit confirmer que le formulaire WCFM ne bloque plus la création de plats.

> La version RestoCommerce `2.0.3`, qui neutralise la validation HTML native sur le formulaire produit WCFM, vient d’être activée par remplacement signé.

> La version RestoCommerce `2.0.4` désactive directement le champ stock lorsqu’il est masqué ; son déploiement signé est terminé et la création de plat doit être rejouée une dernière fois.

> Validation finale : le dashboard dédié ne rend aucun conteneur WCFM historique. Les cinq sections sont actives ; le statut Ouvert/Fermé a été basculé puis restauré, et la disponibilité d’un plat réellement créé a été passée à « Indisponible » puis rétablie à « Disponible ». La création WCFM produit finit par enregistrer le plat mais produit encore un message de validation parasite à investiguer séparément dans le plugin.

# CDC Maître Ultra Premium — exécution séquentielle

> Règle de passage : aucun lot ne démarre avant validation explicite par l’utilisateur du rapport de recette complet du lot précédent. Chaque recette doit couvrir environnement réel, navigateurs Chromium/Firefox/WebKit, axe-core, Lighthouse, Pixelmatch, écarts résiduels et contrôle humain.

- [x] Lot 0 — Vérifier WordPress/WooCommerce/WCFM, les comptes de test et les outils de recette multi-moteurs.
- [x] Lot 0 — Créer une commande unique relançant les contrôles navigateur, accessibilité, performance et visuel.
- [x] Lot 0 — Rédiger le rapport de recette et demander validation utilisateur.
- [ ] Lot 0 — Remplacer la preuve WP-CLI distante indisponible par une preuve WordPress administrateur exportable et traçable, validée par l’utilisateur.
- [x] Lot 0 — Corriger le focus du side cart fermé afin qu’aucun élément focalisable ne reste sous `aria-hidden`.
- [x] Lot 0 — Corriger les contrastes signalés par axe-core sur la home WordPress réelle.
- [x] Lot 0 — Redéployer le thème, relancer la matrice complète et actualiser le rapport de recette.

> Déploiement correctif Lot 0 : l’archive locale RestoCommerce 2.0.5 est validée et prête ; l’accès `wp-admin/theme-install.php` a temporairement déclenché une vérification anti-robot. Aucun changement de thème n’a encore été appliqué au staging.

> Mise à jour corrective : WordPress a confirmé les remplacements signés RestoCommerce 2.0.5, 2.0.6 puis 2.0.7. LiteSpeed a de nouveau confirmé la purge de toutes les entrées LSCache après la version 2.0.7 ; les recettes utilisent désormais une URL de contrôle sans cache afin de ne pas confondre un HTML CDN transitoire avec le thème déployé.

> Analyse Pixelmatch finale : les variations visuelles restantes sont concentrées dans les visuels de cartes restaurant à chargement paresseux ou variable. Les changements de typographie/couleurs relevés correspondent aux remédiations WCAG déployées ; l’aspect fonctionnel et la structure de page ne montrent pas de régression dans la capture Chromium 1920 px.

> Vérification de la home : les deux derniers visuels de cartes restaient non chargés dans le viewport courant parce qu’ils portent l’attribut `loading="lazy"`. L’orchestrateur force désormais leur chargement dans les captures de recette uniquement ; le comportement public n’est pas modifié.

> Recette finale `2026-08-23T17-58-35-122Z` : Chromium, Firefox et WebKit ont tous terminé les quatre breakpoints avec 0 violation axe-core, focus visible et aucun blocage de l’orchestrateur. Le Lot 0 attend exclusivement la validation humaine du rapport `docs/receipts/lot-0-report.md`.

> Validation utilisateur enregistrée : le Lot 0 est approuvé. Le Lot 1 est désormais le seul lot ouvert.

- [x] Lot 1 — Relire le CDC maître et transformer ses exigences de fondation en critères vérifiables sur le staging WordPress réel.
- [x] Lot 1 — Auditer les parcours publics et vendeur prioritaires au regard de l’UX mobile, du clavier, des libellés et des états d’erreur.
- [x] Lot 1 — Implémenter uniquement les fondations UX/accessibilité/performance prévues par le CDC, sans entamer le Lot 2.
- [x] Lot 1 — Déployer le thème sur le staging réel, purger le cache puis valider la version servie.
- [x] Lot 1 — Rejouer la recette sandbox complète : Chromium, Firefox, WebKit, 390/768/1440/1920, axe-core, clavier, Lighthouse et Pixelmatch.
- [ ] Lot 1 — Rédiger le rapport de recette avec preuves et demander validation utilisateur avant le Lot 2.

> Déploiement Lot 1 : WordPress a confirmé le remplacement signé de RestoCommerce 2.1.0 ; LiteSpeed a confirmé la purge globale. Le staging sert `Version: 2.1.0` et charge `ux-foundations.css` depuis le thème actif.

> Ajustement de recette Lot 1 : l’archive 2.1.0 finale ajoute l’état vide contrôlable du dashboard ; elle est validée localement et le formulaire WordPress réel est de nouveau prêt pour remplacement.

> Import final Lot 1 : WordPress a reçu l’archive finale RestoCommerce 2.1.0 et affiche le remplacement signé du package `180`. Aucun autre contenu ou réglage WordPress n’a été modifié par cet import.

> Activation finale Lot 1 : WordPress a confirmé la mise à jour du thème après le remplacement du package `180`. La prochaine action est la purge LiteSpeed suivie de la recette de validation intégrale.

> Pré-recette Lot 1 : LiteSpeed a confirmé une nouvelle purge globale. L’archive finale, qui limite les états forcés au seul paramètre de contrôle sandbox, est prête au dernier remplacement WordPress avant exécution de la recette.

> Import final isolé : l’archive finale RestoCommerce 2.1.0 a été téléversée dans WordPress. Le remplacement signé sera exécuté puis immédiatement suivi d’une purge et d’une validation de version avant les tests.

> Déploiement final isolé : WordPress a confirmé la mise à jour du thème avec le package `181`. La purge LiteSpeed et la recette sandbox complète sont désormais les seules étapes techniques restantes avant le rapport Lot 1.

> Remédiation contraste Lot 1 : l’archive RestoCommerce 2.1.1, issue du diagnostic axe-core détaillé, a été téléversée dans WordPress et attend son remplacement signé avant la nouvelle recette.

> Diagnostic et import : axe-core a isolé uniquement des contrastes de micro-libellés, prix, descriptions et CTA de la fiche restaurant. L’archive RestoCommerce 2.1.1 applique leurs corrections ; WordPress affiche le remplacement signé du package `182` (2.1.0 vers 2.1.1).

> Déploiement contraste confirmé : WordPress a confirmé la mise à jour du package `182`, donc RestoCommerce 2.1.1 est actif sur le staging. Une purge LiteSpeed et une recette intégrale sont requises avant toute décision de passage.

> Contrôle visuel réel : la fiche restaurant RestoCommerce est rendue sur le staging après purge ; un contrôle de styles calculés est engagé car axe-core relève encore les anciennes couleurs dans certains éléments de menu malgré l’archive 2.1.1 active.

> Correctif final préparé : l’archive RestoCommerce 2.1.2, avec un sélecteur de contraste rendu strictement conforme au DOM réel, est téléversée dans WordPress et attend le remplacement signé.

> Import final 2.1.2 : WordPress affiche le remplacement signé du package `183`, correspondant au passage 2.1.1 vers 2.1.2.

> Activation 2.1.2 confirmée : WordPress confirme que le package `183` est installé. La purge LiteSpeed et les contrôles axe-core, multi-navigateurs, clavier, Lighthouse et Pixelmatch doivent maintenant être rejoués.

> Analyse Pixelmatch finale : 35 comparaisons sont à zéro différence. Une seule capture WebKit tablette de la fiche restaurant présente 1,62 % de pixels variables, localisés dans l’imagerie/anti-crénelage du hero ; la structure, les contenus, les CTA et les parcours ne présentent pas de régression visuelle.

> Correctif vendeur en cours : l’archive RestoCommerce 2.1.3, validée localement, est téléversée dans WordPress. Elle corrige les contrastes de navigation, aide et en-têtes relevés par axe-core dans les états commandes réels.

> Déploiement vendeur confirmé : WordPress a confirmé le remplacement du package `184`, activant RestoCommerce 2.1.3. La purge LiteSpeed puis la recette vendeur réelle restent à rejouer avant consolidation du Lot 1.

> Correctif vendeur renforcé : l’archive RestoCommerce 2.1.4 est prête localement après le diagnostic des styles calculés. L’importateur WordPress réel est ouvert ; cette version applique les règles de contraste avec priorité explicite sur le dashboard vendeur.

> Déploiement vendeur 2.1.4 confirmé : WordPress a confirmé le remplacement du package `185`. Après purge LiteSpeed, la recette vendeur et la matrice publique seront rejouées sur cette version finale avant le rapport Lot 1.
- [x] Lot 1 — Mettre en place les états UX, l’accessibilité et la performance après validation du Lot 0.

> Recette finale Lot 1 : RestoCommerce 2.1.4 est actif. La matrice publique complète de 36 combinaisons est sans violation axe-core ni différence Pixelmatch ; les états UX marketplace/menu/commandes et les actions réelles du vendeur sont validés et restaurés. Le rapport `docs/receipts/lot-1-report.md` attend exclusivement la validation humaine avant le Lot 2.

> Validation utilisateur enregistrée : le Lot 1 est approuvé. Le Lot 2 est désormais le seul lot ouvert.

- [x] Lot 2 — Relire les exigences exactes du CDC maître pour l’assistant propriétaire de gestion produits.
- [x] Lot 2 — Auditer les données WooCommerce/WCFM et le parcours d’ajout produit existant sur le staging réel, sans utiliser le formulaire WCFM brut comme expérience cible.
- [x] Lot 2 — Concevoir et implémenter l’assistant mobile propriétaire : contenu, prix, photo, disponibilités, options et confirmation.
- [x] Lot 2 — Relier les actions de l’assistant aux données WooCommerce/WCFM réelles et garantir les droits vendeur.
- [x] Lot 2 — Déployer sur le staging réel, purger LiteSpeed et confirmer la version servie.
- [x] Lot 2 — Exécuter la recette sandbox complète, les actions vendeur réelles et le rapport de recette avant validation humaine.
- [x] Lot 2 — Construire l’assistant mobile de gestion produits après validation du Lot 1.
- [x] Lot 2 — Établir le profil détaillé du LCP du cockpit vendeur authentifié et isoler les ressources non critiques.
- [x] Lot 2 — Réduire sans régression les ressources publiques inutiles sur le cockpit vendeur, puis re-mesurer Lighthouse.
- [x] Lot 2 — Redéployer l’optimisation LCP, rejouer la recette complète et compléter le rapport avant validation humaine.

> Validation utilisateur enregistrée : le Lot 2 est approuvé. Le Lot 3 est désormais le seul lot autorisé.

- [ ] Lot 3 — Auditer les capacités WCFM et les métadonnées disponibles pour une création de boutique réellement persistante.
- [ ] Lot 3 — Concevoir le parcours mobile progressif : identité, zone, image de couverture, horaires, premier plat et aperçu.
- [ ] Lot 3 — Implémenter la sauvegarde/reprise automatique de l’onboarding et la publication de boutique avec les droits vendeur réels.
- [ ] Lot 3 — Connecter le premier plat au wizard propriétaire du Lot 2 et préparer l’entrée palette sans entamer le Lot 9.
- [ ] Lot 3 — Déployer, purger le cache, valider la version et exécuter la recette réelle WebKit/multi-navigateurs avant validation humaine.
- [x] Lot 3 P0 — Unifier la route canonique marketplace/storefront, garantir HTTP 200, titre et canonical non-404, puis ajouter sa non-régression à la recette.
- [ ] Lot 3 P0 — Corriger les contrastes et focus du cockpit jusqu’à zéro violation axe-core sérieuse ou critique sur les moteurs et tailles CDC.
- [ ] Lot 3 P0 — Rendre les recettes clonables : variables d’environnement documentées, imports explicites, chemins portables et nettoyage vendeur isolé.
- [ ] Lot 3 P0 — Prouver la persistance, la reprise, les refus nonce/propriété et la publication immédiate du flux onboarding sur les données WordPress/WCFM réelles.
- [ ] Audit commun — Ne supprimer, désactiver, archiver ou modifier aucun compte ni donnée de recette existante sans instruction explicite ultérieure de l’utilisateur.
- [ ] Audit commun — Vérifier les gates de non-régression `/`, `/restaurant/{slug}/`, `/store/{slug}/`, `/product/{slug}/`, `/cart/`, `/checkout/` et `/store-manager/` sur un vendeur réel.
- [ ] Audit commun — Documenter les écarts historiques Lots 1 et 2 sans annuler leur validation utilisateur ni déclarer de capacité non prouvée.
- [ ] Lot 3 — Étendre la recette aux reprises après rechargement à chaque étape, à la session lente/expirée, au double clic et à la validation MIME/taille des médias.
- [ ] Lot 3 — Vérifier que le profil éditorial, la cuisine, la description, l’adresse, les horaires et l’état de service alimentent réellement le storefront, le titre et les métadonnées publiques.
- [ ] Lot 3 — Centraliser la configuration WhatsApp publique côté serveur et prouver le comportement en cas de valeur absente.
- [ ] Lot 3 — Consigner le commit, les versions, les plugins actifs, la configuration non sensible, les preuves brutes et les risques restants dans le rapport de recette.
- [ ] Lots 3 à 12 — Exécuter uniquement après rapport de recette et validation du lot précédent.

## Corrections explicitement autorisées — Lots 1, 2 et 3

- [ ] Lot 1 — Rejouer la régression de routes publiques et du cockpit vendeur avec les URL WordPress françaises canoniques, les redirections legacy et les 404 éditoriales.
- [ ] Lot 1 — Auditer les contrastes, focus et états réels du cockpit complet sur Chromium, Firefox et WebKit aux quatre breakpoints CDC.
- [ ] Lot 1 — Mesurer et corriger les ressources inutiles ainsi que les opportunités Lighthouse bloquant le seuil de performance CDC.
- [ ] Lot 2 — Remplacer définitivement le rechargement aveugle du wizard après publication par une actualisation de menu contrôlée et vérifiable.
- [ ] Lot 2 — Ajouter une protection idempotente client et serveur contre le double clic de publication, sans créer, archiver ou supprimer d’objets de recette existants.
- [ ] Lot 2 — Rejouer les contrôles d’autorisation propriétaire, média, options et publication sans mutation de données existantes hors scénario explicitement autorisé.
- [ ] Lot 3 — Compléter l’onboarding persistant : cuisine, description, contact, fuseau horaire, couverture remplaçable et sémantique horaires explicite.
- [ ] Lot 3 — Étendre les preuves de reprise par étape, validation média, expiration de session, double clic, nonce invalide et refus inter-vendeur en mode non destructif.
- [ ] Lot 3 — Relever les performances cockpit et storefront après chaque correctif ; ne pas déclarer la conformité tant que le seuil CDC n’est pas mesuré.
- [ ] Commun — Ne supprimer, désactiver, archiver ni modifier aucun compte, produit, média, commande ou donnée de recette existant sans nouvelle autorisation explicite.

> Validation visuelle initiale : les captures desktop 1440 px et mobile 390 px montrent le template dédié, sans menu ou conteneur WCFM natif. La sidebar desktop, les onglets mobiles, les métriques, le rythme des ventes et le bloc menu sont rendus ; les données à zéro reflètent le nouveau vendeur de démonstration.

> Diagnostic données : les quatre soumissions de produits réalisées via le formulaire WCFM n’ont créé aucun produit attribué au vendeur de démonstration. Le template gère correctement l’état vide, mais la validation de la bascule « Disponible / Indisponible » requiert une création produit WCFM réussie ou l’affectation d’un produit existant au vendeur.

> Écarts résiduels observés : la structure, les couleurs, les onglets et les cartes suivent la référence. Les valeurs, commandes et plats du WordPress de test restent à zéro car le vendeur de démonstration ne possède encore aucune donnée effectivement créée. La date et le nom de boutique sont volontairement réels et non fictifs.

> Contrôle local : le template PHP et le script JavaScript passent les vérifications de syntaxe. Les sections dédiées et les trois actions métier sont présentes ; aucune trace des conteneurs de rendu WCFM (`#wcfm_menu`, `#wcfm-main-content`, widgets WCFM) ne subsiste dans le template.

> Diagnostic initial : l’accueil vendeur actif affiche correctement le cockpit, mais conserve également le conteneur WCFM historique sur grand écran. Ce doublon crée une très grande zone sombre et dilue les actions prioritaires. Le correctif ciblé est prêt localement ; son déploiement nécessite le retour d’une session administrateur WordPress.

# Livraison du dossier de développement

- [x] Vérifier le contenu distribuable du projet et exclure les dépendances ou fichiers temporaires inutiles.
- [x] Créer une archive ZIP complète du dossier de développement RestoCommerce.
- [x] Vérifier l’intégrité de l’archive et la rendre téléchargeable.

# Transfert développeur GitHub public

- [x] Auditer le dépôt pour exclure identifiants, nonces, cookies, archives de recette et artefacts sensibles.
- [x] Ajouter une documentation d’installation, d’architecture, de recette et de déploiement WordPress.
- [x] Créer le dépôt GitHub public, envoyer le code auditable et vérifier le contenu publié.
- [x] Ajouter une version assainie du CDC Maître dans la documentation publique du dépôt.
- [x] Ajouter une licence open source explicite au dépôt public.
- [x] Créer et vérifier les jalons GitHub correspondant aux Lots 0 à 12.

# Passe de fidélité micro-visuelle React → WordPress

- [ ] Mesurer les tailles de police, interlignages, espacements et largeurs de la référence React par écran.
- [ ] Ajouter la comparaison pixel et géométrique automatisée entre la référence React et les routes WordPress.
- [ ] Aligner le header, le hero, la recherche, les filtres et les cartes de la home au niveau des détails.
- [ ] Reproduire la composition React dans les boutiques WCFM, menus et fiches produits, sans éléments de chrome plugin.
- [ ] Calibrer les états de panier, checkout et les breakpoints mobile avec les mêmes métriques visuelles.
- [ ] Déployer seulement après revue des écarts, avec une liste explicite des divergences résiduelles si elles existent.

# CDC — Lot 4 : aide et prise en main vendeur
- [x] Ajouter le tour de première prise en main en trois repères : service, commandes et ajout de plat.
- [x] Rendre le tour définitivement non automatique après la décision explicite du vendeur, par préférence persistante protégée.
- [x] Ajouter l’aide contextuelle persistante et le lien WhatsApp résolu côté serveur, sans numéro de secours codé en dur.
- [x] Déployer RestoCommerce 2.6.0, purger le cache et vérifier la distribution de l’asset d’aide.
- [ ] Rejouer le tour connecté, la persistance, le clavier et les quatre breakpoints sur Chromium, Firefox et WebKit avec une session vendeur explicitement autorisée.

# CDC — Lot 5 : notifications vendeur
- [x] Ajouter un journal additif des nouvelles commandes et changements de statut, limité aux vendeurs propriétaires des lignes commandées.
- [x] Ajouter le centre de notifications, la cloche, les réglages son/vibration, les alertes navigateur optionnelles et le lien WhatsApp résolu côté serveur.
- [x] Rafraîchir les alertes et compteurs actifs du cockpit sans rechargement, seulement pendant l’ouverture du navigateur.
- [x] Déployer RestoCommerce 2.6.3, purger LiteSpeed et vérifier la version distribuée avec cache-busting.
- [ ] Rejouer l’événement de nouvelle commande, la permission navigateur, les préférences et la visibilité inter-vendeurs avec une session vendeur et un scénario de commande explicitement autorisés.

# CDC — Lot 6 : suivi public de commande
- [x] Ajouter un suivi à la page WooCommerce de commande reçue, sans route ni jeton secondaire.
- [x] Exiger la clé de commande WooCommerce avant toute restitution et utiliser une comparaison constante.
- [x] Afficher la progression Reçue → En préparation → Prête → Récupérée / livrée par restaurant, avec état clôturé distinct.
- [x] Proposer WhatsApp uniquement si le résolveur existant fournit un numéro, sans envoi automatique ni valeur de secours.
- [x] Déployer RestoCommerce 2.7.0, purger LiteSpeed et vérifier les assets publics avec cache-busting.
- [ ] Rejouer sur des reçus de commande explicitement autorisés : clé valide/invalide, isolation client, multi-restaurants, transitions, annulation et WhatsApp.

# CDC — Lot 7 : avis vérifiés et modération
- [x] Restreindre le dépôt d’avis à une commande WooCommerce terminée avec clé native valide, une fois par restaurant et par achat.
- [x] Calculer les scores publics uniquement sur les avis réels approuvés, sans avis, note ou compteur fictif.
- [x] Ajouter une consultation isolée dans le cockpit et un signalement vendeur additif, sans suppression ni masquage automatique.
- [x] Déployer RestoCommerce 2.7.1, purger LiteSpeed et vérifier les assets CSS/JavaScript publics.
- [ ] Rejouer les refus, la création unique, le doublon, le résumé et le signalement avec une commande terminée et une session vendeur explicitement autorisées.

# CDC — Lot 8 : analyses vendeur
- [x] Ajouter les cartes plat de la semaine, plat sans commande, tendances 7 jours et tendances 30 jours.
- [x] Limiter les calculs aux lignes WooCommerce réellement détenues par le vendeur et exclure les statuts non commerciaux.
- [x] Prévoir des états de données insuffisantes sans valeur fictive ni prédiction.
- [x] Déployer RestoCommerce 2.7.2, purger LiteSpeed et vérifier l’asset des analyses avec cache-busting.
- [ ] Rejouer les chiffres sur une session vendeur autorisée et rapprocher les cartes des rapports WooCommerce pour un historique faible et un historique volumineux.

# CDC — Lot 9 : palettes par restaurant
- [x] Ajouter quatre palettes nommées, avec cartes d’aperçu et choix explicite dans le cockpit.
- [x] Persister uniquement le choix volontaire du vendeur et limiter son application au cockpit, à sa fiche et à ses produits.
- [x] Garder Comptoir éditorial par défaut et éviter toute modification de la marketplace générale.
- [x] Vérifier neuf couples de contraste nominaux à au moins 4,5:1, puis déployer RestoCommerce 2.7.3 et purger LiteSpeed.
- [ ] Rejouer l’enregistrement, l’isolation inter-restaurants et les rendus réels sur les trois moteurs et quatre breakpoints avec une session vendeur autorisée.

# CDC — Lot 10 : système de design
- [x] Documenter le système de design public : couleurs, palettes, typographie, espacements et règles de contribution.
- [x] Documenter les composants restaurant, quick view, side cart, suivi, avis et cockpit vendeur.
- [x] Formaliser boutons, cartes, pills, badges, icônes, focus, clavier, contraste, mouvement et états de données manquantes.
- [ ] Rejouer les validations visuelles connectées sur l’ensemble des composants documentés avec une session vendeur autorisée.

# CDC — Lot 11 : décision checkout
- [x] Comparer le checkout WhatsApp actuel, une passerelle carte/portefeuille WooCommerce et le paiement WhatsApp interactif.
- [x] Documenter les sources officielles, l’architecture conditionnelle, les risques opérationnels et les gates de décision.
- [x] Conserver le code paiement hors périmètre, sans secret, configuration de moyen ni transaction réelle.
- [ ] Obtenir une décision métier explicite sur pays, devise, entité encaissante, reversement vendeur et passerelle avant toute intégration de paiement.

# CDC — Lot 12 : réseau et appareil dégradés
- [x] Ajouter une recette Chromium mobile publique avec latence, débit et CPU ralentis.
- [x] Mesurer marketplace, fiche restaurant, fiche produit et ajout panier dans une session isolée détruite après test.
- [x] Documenter les chiffres de la passe réussie et les limites sans déclarer de conformité performance globale.
- [ ] Rejouer sur téléphone réel, en multi-moteurs et sur les parcours vendeur quand une session explicitement autorisée sera disponible.

# Finalisation Lots 1 à 12
- [x] Rejouer la régression publique multi-moteurs ciblée et les audits axe publics.
- [x] Corriger puis redéployer le contraste public détecté par axe en RestoCommerce 2.7.4.
- [x] Produire le rapport global factuel `docs/receipts/final-lots-1-12-report.md`.
- [ ] Compléter les preuves métier connectées, téléphone réel, décision de paiement et objectif Performance ≥90 avant toute déclaration de conformité CDC complète.

# Publication GitHub de l’export public
- [x] Vérifier l’authentification GitHub reconnectée et publier le commit public assaini `6866cde` vers la branche principale.

# Campagne de vérification renforcée
- [x] Inventorier et préparer les outils sandbox de qualité, sécurité, accessibilité, visualisation et performance.
- [x] Exécuter des contrôles statiques et de dépendances non intrusifs sur les sources publiques.
- [x] Rejouer les routes publiques, axe, navigation clavier et rendus multi-moteurs sans session vendeur.
- [x] Refaire les mesures de performance publique et le contrôle des palettes ; documenter chaque limite qui exige un compte vendeur ou un appareil physique.
- [x] Produire un verdict de conformité factuel et ne corriger que les écarts sûrs ne modifiant aucune donnée métier.

# Recette finale connectée Lots 1 et 2
- [x] Vérifier l’avis externe, le SHA public actuel et les écarts réellement encore ouverts.
- [x] Obtenir l’autorisation explicite de créer puis nettoyer uniquement les données de recette isolées.
- [x] Créer un vendeur, des options et des produits identifiables uniquement comme données de recette ; supprimer le second vendeur vide utilisé pour l’isolation.
- [x] Rejouer le cockpit Lot 1 sur Chromium, Firefox et WebKit aux quatre breakpoints, avec axe et clavier.
- [x] Rejouer le wizard Lot 2 : création contrôlée, upload, options max 2, anti-double soumission, propriété/nonce, rendu public et nettoyage autorisé.
- [x] Émettre un rapport final par lot avec les preuves et un verdict sans surdéclaration.

> Recette connectée du 24 août 2026 : RestoCommerce 2.7.13 est vérifié sur staging. Lot 1 : matrice cockpit finale verte sur les trois moteurs et quatre formats, avec restauration service. Lot 2 : création, limitation UI/serveur, duplication, bibliothèque, rendu public, refus sans nonce, refus inter-vendeur, archivage et 404 public confirmés. Les performances reproductibles ≥90, le téléphone réel, le lecteur d’écran natif et la décision de paiement restent ouverts.
