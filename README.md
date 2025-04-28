# 📚 Lightshelf

**Lightshelf** est une application minimaliste de gestion de bibliothèque personnelle développée en **Laravel** (backend) et **Vue.js** (frontend).  
Ce projet a été conçu comme un **exercice d'apprentissage** pour mieux comprendre la création d'applications web modernes, notamment en construisant **un système d'authentification personnalisé** sans utiliser de packages comme Laravel Breeze ou Fortify.


## ✨ Objectif du projet

- Créer un outil simple pour **organiser, suivre et gérer sa collection de livres**.
- Explorer et **implémenter manuellement** les mécanismes fondamentaux du web moderne : authentification, autorisation, gestion d'API RESTful.
- Pratiquer la structuration d'une **Single Page Application (SPA)** avec **Vue.js** et **Laravel** comme API.


## 🛠️ Architecture générale

### Backend — Laravel

- **Authentification personnalisée** :
  - Inscription, connexion et déconnexion gérées via `AuthController`.
  - Middleware Laravel (`guest` et `auth`) pour protéger les routes.
  - Validation sécurisée des données utilisateurs via des **form requests personnalisés** (`AuthCreateUserValidation`, `AuthLoginValidation`).

- **API REST pour les livres** :
  - **CRUD partiel** pour les livres via `ApiController`.
  - Seul l'utilisateur propriétaire peut supprimer ses propres livres (`deleteBookById` avec contrôle d'autorisation).
  - Récupération de l'ensemble de la bibliothèque ou des livres spécifiques à un utilisateur.

- **Base de données** :
  - Deux tables principales : `users` et `books` (relation `User hasMany Books`).
  - Les **seeders** (`UsersTableSeeder` et `BooksTableSeeder`) génèrent des données fictives pour tester l'application.
  - Chaque livre est lié à un utilisateur (`user_id`) pour assurer la personnalisation.

- **Routes Laravel** :
  - `/register` et `/login` pour l'authentification.
  - `/api/v1/*` pour toutes les API publiques et privées (nécessitant l'authentification).
  - Catch-all route (`/{any?}`) pour charger la SPA Vue.js (protégée par middleware `auth`).

### Frontend — Vue.js

- **Single Page Application (SPA)** chargée à partir d'une unique vue Laravel (`index.blade.php`).
- Vue communique avec Laravel via **API REST** pour :
  - Afficher les livres.
  - Ajouter un nouveau livre.
  - Supprimer un livre.
  - Voir les détails d'un livre.
- Gestion du **state utilisateur** pour limiter l'accès aux fonctionnalités selon la connexion.


## 🔐 Logique de sécurité

- **Protection des actions sensibles** (création/suppression de livre) par vérification côté serveur (`Auth::check()` et contrôle du `user_id`).
- **Validation stricte** des entrées utilisateur avec Laravel Form Request.
- **Sécurisation des sessions** avec régénération de session après login (`$request->session()->regenerate()`).


## 📚 Modèle de données (simplifié)

### Utilisateur (`users`)

| Champ        | Type        |
|--------------|-------------|
| id           | integer     |
| firstname    | string      |
| lastname     | string      |
| email        | string      |
| password     | string (hashé) |
| admin        | boolean     |
| timestamps   | timestamps  |

### Livre (`books`)

| Champ           | Type         |
|-----------------|--------------|
| id              | integer      |
| title           | string       |
| sub_title       | string       |
| author          | string       |
| reading_status  | enum (read, to-read, pending) |
| resume          | text         |
| format          | string       |
| number_of_pages | integer      |
| release_date    | date         |
| editor          | string       |
| isbn            | string       |
| cover_image     | string (URL) |
| user_id         | foreign key (users.id) |
| timestamps      | timestamps   |


## 🌟 Pourquoi Lightshelf est intéressant ?

- **Le moins de dépendances possibles** : tout a été conçu "à la main", forçant à comprendre les détails.
- **Apprentissage des bases de la gestion de la sécurité** sans surcharger l'application.
- **Application complète** avec authentification, autorisation, CRUD API, SPA — ce qui en fait un **vrai projet de portfolio**.

developpé avec 💙 par K-sel
