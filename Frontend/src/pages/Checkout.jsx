import { useState, useEffect } from "react";
import { useShoppingCart } from 'use-shopping-cart';
import axios from '../api/axios';

function Checkout() {
    const [user, setUser] = useState(null);
    const [commandeData, setCommandeData] = useState({
        lieu: '',
        description: ''
    });
    const [isSubmitting, setIsSubmitting] = useState(false);
    const [message, setMessage] = useState({ type: '', text: '' });
    const { cartDetails, totalPrice, clearCart } = useShoppingCart();

    useEffect(() => {
        const userData = localStorage.getItem("User");
        if (userData) {
            try {
                const customer = JSON.parse(userData);
                setUser(customer);
                console.log('Utilisateur chargé:', customer);
            } catch (error) {
                console.error('Erreur lors du parsing des données utilisateur:', error);
            }
        }
    }, []);

    const handleSubmit = async (e) => {
        e.preventDefault();

        if (!user || (!user.client_id && !user.id)) {
            setMessage({ type: 'error', text: 'Veuillez d\'abord créer un compte ou vous connecter.' });
            return;
        }

        if (Object.keys(cartDetails).length === 0) {
            setMessage({ type: 'error', text: 'Votre panier est vide. Veuillez ajouter des articles.' });
            return;
        }

        if (!commandeData.lieu.trim()) {
            setMessage({ type: 'error', text: 'Veuillez spécifier le lieu de livraison/retrait.' });
            return;
        }

        setIsSubmitting(true);
        setMessage({ type: '', text: '' });

        try {
            // Étape 1: Créer ou récupérer le panier
            const panierResponse = await axios.post('passer_commende', {
                id_client: user.client_id || user.id
            });

            if (!panierResponse.data.success) {
                throw new Error(panierResponse.data.message || 'Erreur lors de la création du panier');
            }

            const commandeId = panierResponse.data.commande_id;
            console.log('Panier créé/récupéré avec ID:', commandeId);

            // Étape 2: Ajouter tous les articles au panier
            for (const item of Object.values(cartDetails)) {
                const ligneData = {
                    id_article: item.id,
                    prixU: item.price,
                    quantite: item.quantity,
                    id_commende: commandeId
                };
                
                console.log('Ajout de l\'article:', ligneData);
                const ligneResponse = await axios.post('lignie_commende', ligneData);
                
                if (!ligneResponse.data.success) {
                    throw new Error(`Erreur lors de l'ajout de l'article ${item.name}: ${ligneResponse.data.message}`);
                }
            }

            // Étape 3: Valider le panier (créer la commande finale)
            console.log('Validation du panier...');
            const validationResponse = await axios.post('valider_panier', {
                id_commende: commandeId
            });

            if (validationResponse.data.success) {
                setMessage({ 
                    type: 'success', 
                    text: `🎉 Votre commande a été effectuée avec succès !`,
                    details: {
                        num_facture: validationResponse.data.num_facture,
                        prix_total: validationResponse.data.prix_total,
                        commande_id: validationResponse.data.commande_id
                    }
                });
                clearCart();
                setCommandeData({ lieu: '', description: '' });

                setTimeout(() => {
                    window.location.href = '/';
                }, 5000); // Augmenté à 5 secondes pour lire le message
            } else {
                throw new Error(validationResponse.data.message || 'Erreur lors de la validation de la commande');
            }

        } catch (error) {
            console.error('Erreur lors de la commande:', error);
            let errorMessage = 'Erreur lors de la commande. Veuillez réessayer.';
            
            if (error.response && error.response.data) {
                if (error.response.data.errors) {
                    const errorKeys = Object.keys(error.response.data.errors);
                    errorMessage = errorKeys.map(key => error.response.data.errors[key].join(', ')).join('; ');
                } else if (error.response.data.message) {
                    errorMessage = error.response.data.message;
                }
            } else if (error.message) {
                errorMessage = error.message;
            }
            
            setMessage({ type: 'error', text: errorMessage });
        } finally {
            setIsSubmitting(false);
        }
    };

    if (!user) {
        return (
            <div className="container mt-5">
                <div className="row justify-content-center">
                    <div className="col-md-8">
                        <div className="card">
                            <div className="card-body text-center">
                                <h3 className="text-primary mb-4">
                                    <i className="fa fa-user-lock fa-2x mb-3"></i>
                                    <br />
                                    Connexion Requise
                                </h3>
                                <p className="text-muted mb-4">
                                    Pour passer une commande, vous devez d'abord créer un compte ou vous connecter.
                                </p>
                                <a href="/Profil" className="btn btn-primary btn-lg">
                                    <i className="fa fa-user-plus me-2"></i>
                                    Créer un Compte
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }

    if (Object.keys(cartDetails).length === 0) {
        return (
            <div className="container mt-5">
                <div className="row justify-content-center">
                    <div className="col-md-8">
                        <div className="card">
                            <div className="card-body text-center">
                                <h3 className="text-warning mb-4">
                                    <i className="fa fa-shopping-cart fa-2x mb-3"></i>
                                    <br />
                                    Panier Vide
                                </h3>
                                <p className="text-muted mb-4">
                                    Votre panier est vide. Veuillez ajouter des articles avant de passer la commande.
                                </p>
                                <a href="/menu" className="btn btn-primary btn-lg">
                                    <i className="fa fa-utensils me-2"></i>
                                    Voir le Menu
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }

    return (
        <div>
            <section className="book_section layout_padding">
                <div className="container">
                    <div className="heading_container">
                        <h2>Finaliser la Commande</h2>
                        <p className="text-muted">
                            Bonjour <strong>{user.prenom} {user.nom}</strong> ! 
                            Vos informations personnelles sont pré-remplies.
                        </p>
                    </div>
                    
                    <div className="row justify-content-center">
                        <div className="col-md-8">
                            <div className="form_container">
                                <div className="client-info mb-4 p-3 bg-light rounded">
                                    <h5 className="text-primary mb-3">
                                        <i className="fa fa-user me-2"></i>
                                        Vos Informations
                                    </h5>
                                    <div className="row">
                                        <div className="col-md-6">
                                            <p><strong>Nom :</strong> {user.nom}</p>
                                            <p><strong>Prénom :</strong> {user.prenom}</p>
                                            <p><strong>Email :</strong> {user.email}</p>
                                        </div>
                                        <div className="col-md-6">
                                            <p><strong>Téléphone :</strong> {user.telephone}</p>
                                            <p><strong>Adresse :</strong> {user.adresse}</p>
                                        </div>
                                    </div>
                                </div>

                                <div className="cart-summary mb-4 p-3 bg-light rounded">
                                    <h5 className="text-success mb-3">
                                        <i className="fa fa-shopping-cart me-2"></i>
                                        Récapitulatif du Panier
                                    </h5>
                                    {Object.values(cartDetails).map((item) => (
                                        <div key={item.id} className="d-flex justify-content-between mb-2">
                                            <span>{item.name} x{item.quantity}</span>
                                            <span>{item.price * item.quantity} DT</span>
                                        </div>
                                    ))}
                                    <hr />
                                    <div className="d-flex justify-content-between">
                                        <strong>Total:</strong>
                                        <strong className="text-success">{totalPrice} DT</strong>
                                    </div>
                                </div>

                                {message.text && (
                                    <div className={`alert alert-${message.type === 'success' ? 'success' : 'danger'} mb-3`}>
                                        {message.type === 'success' ? (
                                            <div className="text-center">
                                                <div className="mb-3">
                                                    <i className="fa fa-check-circle fa-3x text-success"></i>
                                                </div>
                                                <h4 className="text-success mb-3">{message.text}</h4>
                                                {message.details && (
                                                    <div className="bg-light p-3 rounded">
                                                        <div className="row">
                                                            <div className="col-md-4">
                                                                <strong>Numéro de facture:</strong><br/>
                                                                <span className="text-primary">{message.details.num_facture}</span>
                                                            </div>
                                                            <div className="col-md-4">
                                                                <strong>Prix total:</strong><br/>
                                                                <span className="text-success">{message.details.prix_total} DT</span>
                                                            </div>
                                                            <div className="col-md-4">
                                                                <strong>ID Commande:</strong><br/>
                                                                <span className="text-info">#{message.details.commande_id}</span>
                                                            </div>
                                                        </div>
                                                        <hr/>
                                                        <p className="text-muted mb-0">
                                                            <i className="fa fa-info-circle me-2"></i>
                                                            <strong>Notification :</strong> Vous recevrez un email de confirmation. Redirection automatique dans 5 secondes...
                                                        </p>
                                                    </div>
                                                )}
                                            </div>
                                        ) : (
                                            <div>
                                                <i className="fa fa-exclamation-triangle me-2"></i>
                                                {message.text}
                                            </div>
                                        )}
                                    </div>
                                )}

                                <form onSubmit={handleSubmit}>
                                    <div className="mb-3">
                                        <label className="form-label">Lieu de livraison/retrait *</label>
                                        <input 
                                            type="text" 
                                            className="form-control"
                                            value={commandeData.lieu}
                                            onChange={(e) => setCommandeData({...commandeData, lieu: e.target.value})}
                                            placeholder="Adresse de livraison ou lieu de retrait"
                                            required
                                        />
                                    </div>
                                    
                                    <div className="mb-4">
                                        <label className="form-label">Description (facultatif)</label>
                                        <textarea 
                                            className="form-control"
                                            rows="3"
                                            value={commandeData.description}
                                            onChange={(e) => setCommandeData({...commandeData, description: e.target.value})}
                                            placeholder="Instructions spéciales, allergies, préférences, etc."
                                        ></textarea>
                                    </div>

                                    <div className="btn_box text-center">
                                        <button 
                                            type="submit" 
                                            className="btn btn-success btn-lg px-5"
                                            disabled={isSubmitting}
                                        >
                                            {isSubmitting ? (
                                                <>
                                                    <i className="fa fa-spinner fa-spin me-2"></i>
                                                    Traitement...
                                                </>
                                            ) : (
                                                <>
                                                    <i className="fa fa-check me-2"></i>
                                                    Confirmer la Commande
                                                </>
                                            )}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    );
}

export default Checkout;
