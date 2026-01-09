# Documentation API Panier - GestionResto

## Vue d'ensemble
Cette documentation décrit les nouvelles fonctionnalités du panier implémentées dans l'API de gestion de restaurant.

## Fonctionnalités du Panier

### 1. Créer/Récupérer un Panier
**Endpoint:** `POST /api/passer_commende`

**Description:** Crée un nouveau panier ou récupère un panier existant pour un client.

**Paramètres:**
```json
{
    "id_client": 1
}
```

**Réponse:**
```json
{
    "success": true,
    "message": "Nouveau panier créé",
    "commande_id": 123,
    "type": "nouveau"
}
```

**Gestion des doublons:** Si le client a déjà un panier en cours, l'API retourne l'ID du panier existant.

### 2. Ajouter un Article au Panier
**Endpoint:** `POST /api/lignie_commende`

**Description:** Ajoute un article au panier avec gestion automatique des doublons.

**Paramètres:**
```json
{
    "id_article": 5,
    "prixU": 12.50,
    "quantite": 2,
    "id_commende": 123
}
```

**Réponse:**
```json
{
    "success": true,
    "message": "Article ajouté au panier",
    "ligne_id": 456
}
```

**Gestion des doublons:** Si l'article existe déjà, la quantité est automatiquement ajoutée.

### 3. Modifier la Quantité d'un Article
**Endpoint:** `POST /api/modifier_quantite`

**Description:** Modifie la quantité d'un article spécifique dans le panier.

**Paramètres:**
```json
{
    "ligne_id": 456,
    "quantite": 3
}
```

**Réponse:**
```json
{
    "success": true,
    "message": "Quantité modifiée",
    "nouvelle_quantite": 3,
    "nouveau_prix": 37.50
}
```

### 4. Supprimer un Article du Panier
**Endpoint:** `POST /api/supprimer_article`

**Description:** Supprime un article spécifique du panier.

**Paramètres:**
```json
{
    "ligne_id": 456
}
```

**Réponse:**
```json
{
    "success": true,
    "message": "Article supprimé du panier"
}
```

### 5. Vider le Panier
**Endpoint:** `POST /api/vider_panier`

**Description:** Supprime tous les articles du panier.

**Paramètres:**
```json
{
    "id_commende": 123
}
```

**Réponse:**
```json
{
    "success": true,
    "message": "Panier vidé"
}
```

### 6. Récupérer le Contenu du Panier
**Endpoint:** `GET /api/get_panier/{id}`

**Description:** Récupère le contenu complet d'un panier avec tous les articles.

**Paramètres:** `id` dans l'URL (ID de la commande)

**Réponse:**
```json
{
    "success": true,
    "panier": {
        "id": 123,
        "prix": 45.00,
        "etat": "panier",
        "lignie_comnd": [
            {
                "id": 456,
                "prixU": 12.50,
                "quantite": 2,
                "prixT": 25.00,
                "articles": {
                    "id": 5,
                    "nom": "Pizza Margherita",
                    "prix": 12.50
                }
            }
        ]
    }
}
```

### 7. Valider le Panier
**Endpoint:** `POST /api/valider_panier`

**Description:** Valide le panier et le transforme en commande officielle.

**Paramètres:**
```json
{
    "id_commende": 123
}
```

**Réponse:**
```json
{
    "success": true,
    "message": "Panier validé, commande en attente",
    "num_facture": "FACT_20241201_123"
}
```

## Améliorations Implémentées

### ✅ Calcul du Prix Total
- **Avant:** Erreur de calcul due à l'initialisation incorrecte du prix
- **Après:** Calcul automatique et précis du prix total basé sur les lignes de commande

### ✅ Gestion des Doublons
- **Avant:** Articles dupliqués dans le panier
- **Après:** Quantités automatiquement ajoutées pour les articles existants

### ✅ Suppression d'Articles
- **Avant:** Impossible de supprimer des articles
- **Après:** Suppression individuelle ou vidage complet du panier

### ✅ Modification des Quantités
- **Avant:** Pas de modification possible
- **Après:** Modification en temps réel avec recalcul automatique du prix

### ✅ Validation des Données
- **Avant:** Validation minimale
- **Après:** Validation complète avec messages d'erreur détaillés

## États des Commandes

- **`panier`:** Panier en cours de modification
- **`en_attente`:** Commande validée, en attente de traitement
- **`en_preparation`:** Commande en cours de préparation
- **`terminee`:** Commande terminée
- **`annulee`:** Commande annulée

## Gestion des Erreurs

Toutes les méthodes retournent des réponses structurées avec :
- `success`: Boolean indiquant le succès de l'opération
- `message`: Description de l'opération
- `errors`: Détails des erreurs de validation (si applicable)

## Exemple d'Utilisation Complète

```javascript
// 1. Créer un panier
const panier = await fetch('/api/passer_commende', {
    method: 'POST',
    body: JSON.stringify({ id_client: 1 })
});

// 2. Ajouter des articles
await fetch('/api/lignie_commende', {
    method: 'POST',
    body: JSON.stringify({
        id_article: 5,
        prixU: 12.50,
        quantite: 2,
        id_commende: panier.commande_id
    })
});

// 3. Récupérer le contenu
const contenu = await fetch(`/api/get_panier/${panier.commande_id}`);

// 4. Valider le panier
await fetch('/api/valider_panier', {
    method: 'POST',
    body: JSON.stringify({ id_commende: panier.commande_id })
});
```

## Notes Techniques

- Toutes les opérations recalculent automatiquement le prix total
- La gestion des doublons est transparente pour l'utilisateur
- Les validations empêchent les opérations invalides
- Le système maintient la cohérence des données
