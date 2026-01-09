# Configuration du Projet GestionResto

## Prérequis
- PHP 8.2+
- Composer
- Laravel 11
- Base de données (MySQL ou SQLite)

## Installation

### 1. Copier le fichier .env
```bash
cp .env.example .env
```

### 2. Configurer la base de données
Dans le fichier `.env`, configurez votre base de données :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestion_resto
DB_USERNAME=root
DB_PASSWORD=
```

Ou pour SQLite (développement) :
```env
DB_CONNECTION=sqlite
```

### 3. Installer les dépendances
```bash
composer install
```

### 4. Générer la clé d'application
```bash
php artisan key:generate
```

### 5. Générer la clé JWT
```bash
php artisan jwt:secret
```

### 6. Exécuter les migrations
```bash
php artisan migrate
```

### 7. Lancer le serveur
```bash
php artisan serve
```

## Configuration JWT

Le projet utilise JWT pour l'authentification. La configuration est automatique grâce au service provider.

## Routes API

### Routes publiques
- `POST /api/auth/login` - Connexion utilisateur

### Routes protégées (nécessitent un token JWT)
- `GET /api/parameter` - Paramètres de l'application
- `GET /api/tout_categorie` - Liste des catégories
- `GET /api/tout_article` - Liste des articles
- `GET /api/article_par_categorie/{id}` - Articles par catégorie
- `POST /api/inscrit_client` - Inscription d'un client
- `POST /api/passer_commende` - Créer un panier
- `POST /api/lignie_commende` - Ajouter un article au panier
- `POST /api/modifier_quantite` - Modifier la quantité
- `POST /api/supprimer_article` - Supprimer un article
- `POST /api/vider_panier` - Vider le panier
- `GET /api/get_panier/{id}` - Récupérer le panier
- `POST /api/valider_panier` - Valider le panier
- `POST /api/passer_reservation` - Créer une réservation
- `POST /api/contacter_nous` - Envoyer un message de contact

## Utilisation

### Connexion
```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"user@example.com","password":"password"}'
```

### Utilisation du token
```bash
curl -X GET http://localhost:8000/api/tout_categorie \
  -H "Authorization: Bearer YOUR_JWT_TOKEN"
```

## Structure de la base de données

- `users` - Utilisateurs de l'application
- `clients` - Clients du restaurant
- `categories` - Catégories d'articles
- `articles` - Articles du menu
- `commendes` - Commandes/paniers
- `commende_lignies` - Lignes de commande
- `reservations` - Réservations de table
- `contacts` - Messages de contact
- `parameters` - Paramètres de l'application

## Correction des erreurs

Les erreurs suivantes ont été corrigées :
1. Configuration JWT manquante
2. Validation des données dans l'ApiController
3. Gestion des erreurs et exceptions
4. Middleware JWT personnalisé
5. Relations entre modèles
6. Configuration de la base de données
