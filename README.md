Projet de Site Web d'Articles avec Symfony 6.1
Bienvenue dans le dépôt de mon site web de gestion d'articles, développé avec Symfony 6.1. Ce projet a pour but de démontrer ma maîtrise du framework Symfony à travers une application complète et fonctionnelle, intégrant un back-end et un front-end interactifs.

Fonctionnalités
Gestion des articles :
Création d'articles (formulaire avec upload de photos).
Édition d'articles (modification du contenu et des photos).
Liste des articles (listing dynamique avec JavaScript).
Upload de photos : Gestion des images pour chaque article, avec validation et traitement des fichiers.
Interface utilisateur moderne : Utilisation de JavaScript et CSS pour une interface interactive et un design fluide.
Formulaires dynamiques : Plusieurs formulaires pour la gestion des articles, démontrant une bonne maîtrise des fonctionnalités avancées de Symfony.
Sécurité et gestion des rôles :
Implémentation d'un système de gestion des utilisateurs avec rôles (ex: user, admin).
Sécurisation des routes et des actions en fonction des rôles. Les utilisateurs peuvent se connecter et n'accéder qu'aux sections qui leur sont autorisées.
Admin : Possède des droits supplémentaires pour la gestion complète des articles.
Utilisateur : Peut consulter les articles et soumettre des propositions, mais avec des accès limités par rapport à un administrateur.
Technologies utilisées
Symfony 6.1 : Le framework back-end principal pour gérer la logique métier.
Twig : Moteur de templates pour la génération des pages HTML.
Doctrine ORM : Pour la gestion de la base de données et des entités.
JavaScript : Pour améliorer l'interactivité du site (e.g., gestion dynamique des formulaires).
CSS : Pour le style et l'ergonomie des pages.
Bootstrap (optionnel) : Utilisé pour un design responsive et accessible.
Symfony Security : Gestion des utilisateurs, des rôles et des permissions.
Prérequis
Avant de lancer le projet localement, assurez-vous d'avoir les prérequis suivants :

PHP 8.1 ou plus récent
Composer
Symfony CLI (facultatif mais recommandé)
Une base de données MySQL ou PostgreSQL
Node.js et NPM (pour la gestion des dépendances front-end, si nécessaire)
