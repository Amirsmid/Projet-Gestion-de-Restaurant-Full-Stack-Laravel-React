# 🧪 Guide de Test - Réservations et Commandes

## 🎯 **Objectif**
Vérifier que les réservations et commandes s'affichent correctement dans la page d'administration après avoir été créées depuis le frontend.

## 📋 **Tests à Effectuer**

### **1. Test des Réservations**

#### **Étape 1 : Créer une Réservation**
1. Aller sur la page de réservation du frontend
2. Remplir tous les champs :
   - Nom du client
   - Date souhaitée
   - Nombre de personnes
3. Soumettre la réservation
4. **Vérifier** : Message de confirmation reçu

#### **Étape 2 : Vérifier dans l'Admin**
1. Aller sur `/reservation` dans l'administration
2. **Vérifier** : La nouvelle réservation apparaît dans la liste
3. **Vérifier** : Les informations sont correctes (client, date, nombre de personnes)
4. **Vérifier** : L'état est "En Attente"

#### **Étape 3 : Tester les Actions**
1. Cliquer sur "Accepter" pour une réservation
2. **Vérifier** : L'état change à "Acceptée"
3. **Vérifier** : Les boutons d'action disparaissent

### **2. Test des Commandes (Paniers)**

#### **Étape 1 : Créer un Panier**
1. Aller sur la page du panier du frontend
2. Cliquer sur "Créer un Panier"
3. **Vérifier** : Panier créé avec succès

#### **Étape 2 : Ajouter des Articles**
1. Ajouter plusieurs articles au panier
2. Modifier les quantités
3. **Vérifier** : Prix total calculé correctement

#### **Étape 3 : Vérifier dans l'Admin - Paniers**
1. Aller sur `/commende/paniers` dans l'administration
2. **Vérifier** : Le panier en cours apparaît dans la liste
3. **Vérifier** : Informations correctes (client, prix, nombre d'articles)

#### **Étape 4 : Valider le Panier**
1. Cliquer sur "Valider" dans la liste des paniers
2. **Vérifier** : Message de confirmation
3. **Vérifier** : Le panier disparaît de la liste des paniers

#### **Étape 5 : Vérifier dans l'Admin - Commandes**
1. Aller sur `/commende` dans l'administration
2. **Vérifier** : La commande validée apparaît dans la liste
3. **Vérifier** : L'état est "En Attente"
4. **Vérifier** : Actions disponibles (Accepter/Refuser)

## 🔍 **Points de Vérification Clés**

### **Réservations**
- ✅ Création depuis le frontend
- ✅ Affichage dans l'admin
- ✅ Gestion des états (En Attente → Acceptée/Refusée)
- ✅ Actions appropriées selon l'état

### **Commandes**
- ✅ Création du panier
- ✅ Ajout d'articles
- ✅ Calcul des prix
- ✅ Affichage dans "Paniers en Cours"
- ✅ Validation du panier
- ✅ Affichage dans "Commandes"
- ✅ Gestion des états

## 🚨 **Problèmes Courants et Solutions**

### **Problème : Réservation ne s'affiche pas**
**Solution :**
1. Vérifier que la base de données est bien mise à jour
2. Vérifier les logs Laravel
3. Vérifier que la route `/reservation` est accessible

### **Problème : Commande ne s'affiche pas**
**Solution :**
1. Vérifier que le panier a bien été validé
2. Vérifier l'état de la commande dans la base
3. Vérifier que la route `/commende` est accessible

### **Problème : Erreur de calcul des prix**
**Solution :**
1. Vérifier que la méthode `recalculerPrixTotal()` fonctionne
2. Vérifier les données dans la table `commende_lignies`

## 📊 **Données de Test Recommandées**

### **Réservation de Test**
```json
{
    "nom": "Test Client",
    "prenom": "Test",
    "email": "test@example.com",
    "telephone": "0123456789",
    "date": "2024-12-25 19:00",
    "nb_pers": 4
}
```

### **Panier de Test**
```json
{
    "articles": [
        {"id": 1, "nom": "Pizza Margherita", "prix": 12.50, "quantite": 2},
        {"id": 2, "nom": "Burger Deluxe", "prix": 15.00, "quantite": 1}
    ],
    "total_attendu": 40.00
}
```

## ✅ **Checklist de Validation**

- [ ] Réservation créée depuis le frontend
- [ ] Réservation visible dans l'admin
- [ ] Panier créé depuis le frontend
- [ ] Articles ajoutés au panier
- [ ] Prix calculé correctement
- [ ] Panier visible dans "Paniers en Cours"
- [ ] Panier validé avec succès
- [ ] Commande visible dans "Commandes"
- [ ] États gérés correctement
- [ ] Actions fonctionnelles

## 🎉 **Résultat Attendu**

Après ces tests, vous devriez voir :
1. **Toutes vos réservations** dans la page d'administration des réservations
2. **Tous vos paniers en cours** dans la page des paniers
3. **Toutes vos commandes validées** dans la page des commandes
4. **Une gestion complète des états** avec actions appropriées

---

**💡 Conseil :** Si un problème persiste, vérifiez les logs Laravel (`storage/logs/laravel.log`) pour identifier les erreurs.
