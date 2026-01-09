import React, { useState, useEffect } from 'react';

const Panier = ({ clientId }) => {
    const [panier, setPanier] = useState(null);
    const [articles, setArticles] = useState([]);
    const [loading, setLoading] = useState(false);
    const [message, setMessage] = useState('');

    // Créer ou récupérer un panier
    const creerPanier = async () => {
        setLoading(true);
        try {
            const response = await fetch('/api/passer_commende', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ id_client: clientId })
            });
            
            const data = await response.json();
            if (data.success) {
                setPanier({ id: data.commande_id, etat: 'panier' });
                setMessage(data.message);
                chargerPanier(data.commande_id);
            }
        } catch (error) {
            setMessage('Erreur lors de la création du panier');
        }
        setLoading(false);
    };

    // Charger le contenu du panier
    const chargerPanier = async (panierId) => {
        try {
            const response = await fetch(`/api/get_panier/${panierId}`);
            const data = await response.json();
            if (data.success) {
                setPanier(data.panier);
                setArticles(data.panier.lignie_comnd || []);
            }
        } catch (error) {
            setMessage('Erreur lors du chargement du panier');
        }
    };

    // Ajouter un article au panier
    const ajouterArticle = async (article) => {
        if (!panier) {
            setMessage('Veuillez d\'abord créer un panier');
            return;
        }

        try {
            const response = await fetch('/api/lignie_commende', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    id_article: article.id,
                    prixU: article.prix,
                    quantite: 1,
                    id_commende: panier.id
                })
            });
            
            const data = await response.json();
            if (data.success) {
                setMessage(data.message);
                chargerPanier(panier.id);
            }
        } catch (error) {
            setMessage('Erreur lors de l\'ajout de l\'article');
        }
    };

    // Modifier la quantité d'un article
    const modifierQuantite = async (ligneId, nouvelleQuantite) => {
        if (nouvelleQuantite < 1) return;

        try {
            const response = await fetch('/api/modifier_quantite', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    ligne_id: ligneId,
                    quantite: nouvelleQuantite
                })
            });
            
            const data = await response.json();
            if (data.success) {
                setMessage(data.message);
                chargerPanier(panier.id);
            }
        } catch (error) {
            setMessage('Erreur lors de la modification de la quantité');
        }
    };

    // Supprimer un article du panier
    const supprimerArticle = async (ligneId) => {
        try {
            const response = await fetch('/api/supprimer_article', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ ligne_id: ligneId })
            });
            
            const data = await response.json();
            if (data.success) {
                setMessage(data.message);
                chargerPanier(panier.id);
            }
        } catch (error) {
            setMessage('Erreur lors de la suppression de l\'article');
        }
    };

    // Vider le panier
    const viderPanier = async () => {
        if (!panier) return;

        try {
            const response = await fetch('/api/vider_panier', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ id_commende: panier.id })
            });
            
            const data = await response.json();
            if (data.success) {
                setMessage(data.message);
                setPanier(null);
                setArticles([]);
            }
        } catch (error) {
            setMessage('Erreur lors du vidage du panier');
        }
    };

    // Valider le panier
    const validerPanier = async () => {
        if (!panier || articles.length === 0) {
            setMessage('Le panier est vide');
            return;
        }

        try {
            const response = await fetch('/api/valider_panier', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ id_commende: panier.id })
            });
            
            const data = await response.json();
            if (data.success) {
                setMessage(data.message);
                setPanier({ ...panier, etat: 'en_attente' });
            }
        } catch (error) {
            setMessage('Erreur lors de la validation du panier');
        }
    };

    // Exemple d'articles disponibles
    const articlesDisponibles = [
        { id: 1, nom: 'Pizza Margherita', prix: 12.50, description: 'Pizza classique' },
        { id: 2, nom: 'Burger Deluxe', prix: 15.00, description: 'Burger gourmet' },
        { id: 3, nom: 'Salade César', prix: 8.50, description: 'Salade fraîche' },
        { id: 4, nom: 'Pasta Carbonara', prix: 14.00, description: 'Pâtes crémeuses' }
    ];

    return (
        <div className="max-w-4xl mx-auto p-6">
            <h1 className="text-3xl font-bold text-center mb-8">Gestion du Panier</h1>
            
            {/* Message de statut */}
            {message && (
                <div className="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">
                    {message}
                </div>
            )}

            {/* Création du panier */}
            {!panier && (
                <div className="text-center mb-8">
                    <button
                        onClick={creerPanier}
                        disabled={loading}
                        className="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded disabled:opacity-50"
                    >
                        {loading ? 'Création...' : 'Créer un Panier'}
                    </button>
                </div>
            )}

            {/* Contenu du panier */}
            {panier && (
                <div className="bg-white shadow-lg rounded-lg p-6 mb-8">
                    <div className="flex justify-between items-center mb-4">
                        <h2 className="text-xl font-semibold">
                            Panier #{panier.id} - {panier.etat}
                        </h2>
                        <div className="space-x-2">
                            <button
                                onClick={viderPanier}
                                className="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                            >
                                Vider le Panier
                            </button>
                            {panier.etat === 'panier' && (
                                <button
                                    onClick={validerPanier}
                                    className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                >
                                    Valider le Panier
                                </button>
                            )}
                        </div>
                    </div>

                    {/* Articles dans le panier */}
                    {articles.length === 0 ? (
                        <p className="text-gray-500 text-center py-8">Le panier est vide</p>
                    ) : (
                        <div className="space-y-4">
                            {articles.map((ligne) => (
                                <div key={ligne.id} className="flex items-center justify-between p-4 border rounded">
                                    <div className="flex-1">
                                        <h3 className="font-semibold">{ligne.articles?.nom || 'Article'}</h3>
                                        <p className="text-sm text-gray-600">
                                            Prix unitaire: {ligne.prixU}€
                                        </p>
                                    </div>
                                    <div className="flex items-center space-x-4">
                                        <div className="flex items-center space-x-2">
                                            <button
                                                onClick={() => modifierQuantite(ligne.id, ligne.quantite - 1)}
                                                className="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-1 px-3 rounded"
                                            >
                                                -
                                            </button>
                                            <span className="w-12 text-center">{ligne.quantite}</span>
                                            <button
                                                onClick={() => modifierQuantite(ligne.id, ligne.quantite + 1)}
                                                className="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-1 px-3 rounded"
                                            >
                                                +
                                            </button>
                                        </div>
                                        <span className="font-semibold w-20 text-right">
                                            {ligne.prixT}€
                                        </span>
                                        <button
                                            onClick={() => supprimerArticle(ligne.id)}
                                            className="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded"
                                        >
                                            ×
                                        </button>
                                    </div>
                                </div>
                            ))}
                            
                            {/* Total */}
                            <div className="border-t pt-4">
                                <div className="flex justify-between items-center text-xl font-bold">
                                    <span>Total:</span>
                                    <span>{panier.prix}€</span>
                                </div>
                            </div>
                        </div>
                    )}
                </div>
            )}

            {/* Articles disponibles */}
            <div className="bg-white shadow-lg rounded-lg p-6">
                <h2 className="text-xl font-semibold mb-4">Articles Disponibles</h2>
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    {articlesDisponibles.map((article) => (
                        <div key={article.id} className="border rounded-lg p-4">
                            <h3 className="font-semibold mb-2">{article.nom}</h3>
                            <p className="text-sm text-gray-600 mb-2">{article.description}</p>
                            <p className="text-lg font-bold text-green-600 mb-3">{article.prix}€</p>
                            <button
                                onClick={() => ajouterArticle(article)}
                                disabled={!panier || panier.etat !== 'panier'}
                                className="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded disabled:opacity-50"
                            >
                                Ajouter au Panier
                            </button>
                        </div>
                    ))}
                </div>
            </div>
        </div>
    );
};

export default Panier;
