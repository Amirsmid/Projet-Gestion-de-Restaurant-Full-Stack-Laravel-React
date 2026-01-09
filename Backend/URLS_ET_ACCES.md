# URLs et Accès - Projet GestionResto

## 🚀 Serveurs en cours d'exécution

### Backend Laravel (Port 8000)
- **URL** : `http://127.0.0.1:8000`
- **Status** : ✅ En cours d'exécution
- **Commande** : `php artisan serve --port=8000`

### Frontend React (Port 3000)
- **URL** : `http://localhost:3000`
- **Status** : À démarrer
- **Commande** : `cd GestionRestaurant && npm run dev`

## 🔐 Accès Dashboard Admin (Backend Laravel)

### Login Admin
- **URL** : `http://127.0.0.1:8000/login`
- **Email** : `admin@restaurant.com`
- **Mot de passe** : `admin123`

### Register Admin
- **URL** : `http://127.0.0.1:8000/register`

### Dashboard Admin
- **URL** : `http://127.0.0.1:8000/dashboard`
- **Accès** : Après connexion

## 🍽️ Site Restaurant (Frontend React)

### Page d'accueil
- **URL** : `http://localhost:3000`

### Menu
- **URL** : `http://localhost:3000/menu`

### Panier
- **URL** : `http://localhost:3000/cart`

## 📋 Fonctionnalités Disponibles

### Backend Laravel (Dashboard Admin)
- ✅ Gestion des paramètres du restaurant
- ✅ Gestion des catégories
- ✅ Gestion des articles
- ✅ Gestion des clients
- ✅ Gestion des commandes
- ✅ Gestion des réservations
- ✅ Gestion des contacts

### Frontend React (Site Restaurant)
- ✅ Affichage du menu avec catégories
- ✅ Ajout d'articles au panier
- ✅ Gestion des quantités (+ et -)
- ✅ Calcul automatique du total
- ✅ Notifications de succès

## 🔧 API Endpoints (Backend)

### Routes Publiques
- `GET /api/parameter` - Paramètres du restaurant
- `GET /api/tout_categorie` - Liste des catégories
- `GET /api/tout_article` - Liste des articles
- `GET /api/article_par_categorie/{id}` - Articles par catégorie
- `POST /api/auth/login` - Connexion utilisateur

### Routes Protégées
- `POST /api/inscrit_client` - Inscription client
- `POST /api/passer_commende` - Créer un panier
- `POST /api/lignie_commende` - Ajouter au panier
- `POST /api/modifier_quantite` - Modifier quantité
- `POST /api/supprimer_article` - Supprimer article
- `POST /api/vider_panier` - Vider le panier
- `GET /api/get_panier/{id}` - Récupérer le panier
- `POST /api/valider_panier` - Valider le panier
- `POST /api/passer_reservation` - Créer réservation
- `POST /api/contacter_nous` - Envoyer message

## 🎯 Instructions de Test

### 1. Tester le Backend (Dashboard Admin)
1. Ouvrir `http://127.0.0.1:8000/login`
2. Se connecter avec :
   - Email : `admin@restaurant.com`
   - Mot de passe : `admin123`
3. Accéder au dashboard : `http://127.0.0.1:8000/dashboard`

### 2. Tester le Frontend (Site Restaurant)
1. Démarrer le frontend : `cd GestionRestaurant && npm run dev`
2. Ouvrir `http://localhost:3000`
3. Naviguer vers le menu
4. Ajouter des articles au panier
5. Tester les boutons + et - dans le panier

### 3. Tester l'API
1. Ouvrir `http://127.0.0.1:8000/api/tout_categorie`
2. Ouvrir `http://127.0.0.1:8000/api/tout_article`
3. Vérifier que les données JSON s'affichent

## 🚨 Résolution de Problèmes

### Si le backend ne démarre pas
```bash
cd GestionResto
php artisan config:clear
php artisan cache:clear
php artisan serve --port=8000
```

### Si le frontend ne démarre pas
```bash
cd GestionRestaurant
npm install
npm run dev
```

### Si les articles ne s'affichent pas
1. Vérifier que le backend fonctionne sur le port 8000
2. Vérifier que l'API retourne des données
3. Vérifier la console du navigateur pour les erreurs

## ✅ Statut Actuel

- **Backend Laravel** : ✅ Fonctionnel
- **Base de données** : ✅ Configurée avec données de test
- **API REST** : ✅ Opérationnelle
- **Authentification Admin** : ✅ Configurée
- **Frontend React** : ⏳ À démarrer
- **Système de panier** : ✅ Fonctionnel

**Le projet est prêt à être utilisé !** 🎉
