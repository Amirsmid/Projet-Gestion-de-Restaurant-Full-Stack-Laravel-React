# Gestion Restaurant - Application React

Une application web moderne pour la gestion d'un restaurant, développée avec React et Vite.

## 🚀 Fonctionnalités

### ✅ Fonctionnalités implémentées
- **Menu interactif** : Affichage des catégories et articles avec filtrage
- **Système de panier** : Ajout, suppression et modification des quantités
- **Gestion des commandes** : Processus de checkout complet
- **Navigation responsive** : Barre de navigation avec compteur de panier
- **Gestion des erreurs** : ErrorBoundary et gestion des états de chargement
- **Interface utilisateur moderne** : Design responsive et animations

### 🔧 Fonctionnalités techniques
- Gestion d'état avec `use-shopping-cart`
- Routing avec `react-router-dom`
- Gestion des erreurs et états de chargement
- Styles CSS modulaires et responsifs
- Intégration avec API backend

## 🛠️ Technologies utilisées

- **Frontend** : React 18, Vite
- **Gestion d'état** : use-shopping-cart
- **Routing** : React Router DOM
- **HTTP Client** : Axios
- **Styles** : CSS personnalisé avec Bootstrap
- **Build Tool** : Vite

## 📦 Installation

1. **Cloner le projet**
   ```bash
   git clone [URL_DU_REPO]
   cd GestionRestaurant
   ```

2. **Installer les dépendances**
   ```bash
   npm install
   ```

3. **Lancer en mode développement**
   ```bash
   npm run dev
   ```

4. **Construire pour la production**
   ```bash
   npm run build
   ```

## 🌐 Configuration

### Variables d'environnement
Le projet utilise des URLs d'API configurées dans `src/api/shared.js` :
- **Server** : `http://127.0.0.1:8000/`
- **BaseUrl** : `http://127.0.0.1:8000/api/`
- **ImgUrl** : `http://127.0.0.1:8000/img/`

### Backend requis
L'application nécessite un backend Laravel avec les endpoints suivants :
- `GET /api/tout_categorie` - Récupération des catégories
- `GET /api/tout_article/{id}` - Récupération de tous les articles
- `GET /api/article_par_categorie/{id}` - Récupération des articles par catégorie

## 📱 Structure de l'application

```
src/
├── components/          # Composants réutilisables
│   ├── ErrorBoundary.jsx
│   └── LoadingSpinner.jsx
├── pages/              # Pages principales
│   ├── Accueil.jsx     # Page d'accueil
│   ├── Menu.jsx        # Page du menu
│   ├── Cart.jsx        # Page du panier
│   ├── Checkout.jsx    # Page de commande
│   ├── NavBar.jsx      # Barre de navigation
│   ├── Footer.jsx      # Pied de page
│   ├── ProfilUser.jsx  # Profil utilisateur
│   └── Book.jsx        # Réservation de table
├── Services/           # Services API
│   ├── Articleservice.js
│   ├── CategoriesServices.js
│   ├── ClientService.js
│   └── Parameter.js
├── api/                # Configuration API
│   ├── axios.js        # Configuration Axios
│   └── shared.js       # URLs partagées
└── assets/             # Ressources statiques
    └── css/
        └── style.css   # Styles personnalisés
```

## 🎯 Utilisation

### Navigation
- **Accueil** (`/`) : Page principale du restaurant
- **Menu** (`/menu`) : Affichage des articles avec filtrage par catégorie
- **Panier** (`/cart`) : Gestion du panier d'achat
- **Commande** (`/checkout`) : Finalisation de la commande
- **Profil** (`/Profil`) : Gestion du profil utilisateur
- **Réservation** (`/BookTable`) : Réservation de table

### Fonctionnalités du panier
- Ajout d'articles depuis le menu
- Modification des quantités
- Suppression d'articles
- Calcul automatique des totaux avec TVA
- Processus de checkout complet

## 🔍 Dépannage

### Erreurs courantes
1. **Erreur de connexion API** : Vérifier que le backend Laravel est en cours d'exécution
2. **Images non chargées** : Vérifier les chemins dans `src/api/shared.js`
3. **Erreurs de build** : Vérifier que toutes les dépendances sont installées

### Logs de débogage
- Ouvrir la console du navigateur pour voir les erreurs détaillées
- Vérifier les appels API dans l'onglet Network
- Utiliser l'ErrorBoundary pour capturer les erreurs React

## 🚀 Déploiement

1. **Construire l'application**
   ```bash
   npm run build
   ```

2. **Déployer le dossier `dist/`** sur votre serveur web

3. **Configurer les URLs d'API** pour la production dans `src/api/shared.js`

## 🤝 Contribution

1. Fork le projet
2. Créer une branche pour votre fonctionnalité
3. Commiter vos changements
4. Pousser vers la branche
5. Ouvrir une Pull Request

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.

## 📞 Support

Pour toute question ou problème :
- Ouvrir une issue sur GitHub
- Contacter l'équipe de développement

---

**Développé avec ❤️ pour la gestion de restaurant**
