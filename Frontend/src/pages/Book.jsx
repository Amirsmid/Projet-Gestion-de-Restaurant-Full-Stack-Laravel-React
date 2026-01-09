import { useState, useEffect } from "react";
import axios from '../api/axios';

function Book() {
    const [user, setUser] = useState(null);
    const [reservationData, setReservationData] = useState({
        date: '',
        time: '',
        persons: '',
        remarque: ''
    });
    const [isSubmitting, setIsSubmitting] = useState(false);
    const [message, setMessage] = useState({ type: '', text: '' });

    useEffect(() => {
        // Charger les données utilisateur depuis le localStorage
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
        
        if (!user) {
            setMessage({ type: 'error', text: 'Veuillez d\'abord créer un compte ou vous connecter.' });
            return;
        }

        if (!user.client_id && !user.id) {
            setMessage({ type: 'error', text: 'Informations client manquantes. Veuillez vous reconnecter.' });
            return;
        }

        if (!reservationData.date || !reservationData.time || !reservationData.persons) {
            setMessage({ type: 'error', text: 'Veuillez remplir tous les champs obligatoires.' });
            return;
        }

        // Validation de la date
        const selectedDate = new Date(reservationData.date + ' ' + reservationData.time);
        const now = new Date();
        
        if (selectedDate <= now) {
            setMessage({ type: 'error', text: 'La date et l\'heure de réservation doivent être dans le futur.' });
            return;
        }

        // Validation du nombre de personnes
        if (reservationData.persons < 1 || reservationData.persons > 20) {
            setMessage({ type: 'error', text: 'Le nombre de personnes doit être entre 1 et 20.' });
            return;
        }

        setIsSubmitting(true);
        setMessage({ type: '', text: '' });

        try {
            const reservationDataToSend = {
                id_client: user.client_id || user.id,
                date: reservationData.date + ' ' + reservationData.time + ':00',
                nb_pers: parseInt(reservationData.persons)
            };

            console.log('Données de réservation envoyées:', reservationDataToSend);

            const response = await axios.post('passer_reservation', reservationDataToSend);
            
            if (response.data.success) {
                setMessage({ 
                    type: 'success', 
                    text: `🎉 Votre réservation a été effectuée avec succès !`,
                    details: {
                        date: response.data.date,
                        time: reservationData.time,
                        nb_pers: response.data.nb_pers,
                        reservation_id: response.data.reservation_id
                    }
                });
                setReservationData({ date: '', time: '', persons: '', remarque: '' });
                
                // Rediriger vers l'accueil après 5 secondes
                setTimeout(() => {
                    window.location.href = '/';
                }, 5000);
            } else {
                throw new Error(response.data.message || 'Erreur lors de la création de la réservation');
            }
        } catch (error) {
            console.error('Erreur lors de la réservation:', error);
            let errorMessage = 'Erreur lors de la réservation. Veuillez réessayer.';
            
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

    // Si l'utilisateur n'est pas connecté, afficher un message
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
                                    Pour réserver une table, vous devez d'abord créer un compte ou vous connecter.
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

    return (
        <div>
            <section className="book_section layout_padding">
                <div className="container">
                    <div className="heading_container">
                        <h2>Réserver une Table</h2>
                        <p className="text-muted">
                            Bonjour <strong>{user.prenom} {user.nom}</strong> ! 
                            Vos informations personnelles sont pré-remplies.
                        </p>
                    </div>
                    
                    <div className="row justify-content-center">
                        <div className="col-md-8">
                            <div className="form_container">
                                {/* Informations du client */}
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

                                {/* Messages */}
                                {message.text && (
                                    <div className={`alert alert-${message.type === 'success' ? 'success' : 'danger'} mb-3`}>
                                        {message.type === 'success' ? (
                                            <div className="text-center">
                                                <div className="mb-3">
                                                    <i className="fa fa-calendar-check fa-3x text-success"></i>
                                                </div>
                                                <h4 className="text-success mb-3">{message.text}</h4>
                                                {message.details && (
                                                    <div className="bg-light p-3 rounded">
                                                        <div className="row">
                                                            <div className="col-md-4">
                                                                <strong>Date:</strong><br/>
                                                                <span className="text-primary">{message.details.date}</span>
                                                            </div>
                                                            <div className="col-md-4">
                                                                <strong>Heure:</strong><br/>
                                                                <span className="text-success">{message.details.time}</span>
                                                            </div>
                                                            <div className="col-md-4">
                                                                <strong>Personnes:</strong><br/>
                                                                <span className="text-info">{message.details.nb_pers}</span>
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

                                {/* Formulaire de réservation */}
                                <form onSubmit={handleSubmit}>
                                    <div className="row">
                                        <div className="col-md-6 mb-3">
                                            <label className="form-label">Date *</label>
                                            <input 
                                                type="date" 
                                                className="form-control"
                                                value={reservationData.date}
                                                onChange={(e) => setReservationData({...reservationData, date: e.target.value})}
                                                min={new Date().toISOString().split('T')[0]}
                                                required
                                            />
                                        </div>
                                        <div className="col-md-6 mb-3">
                                            <label className="form-label">Heure *</label>
                                            <select 
                                                className="form-control"
                                                value={reservationData.time}
                                                onChange={(e) => setReservationData({...reservationData, time: e.target.value})}
                                                required
                                            >
                                                <option value="">Sélectionnez l'heure</option>
                                                <option value="11:00">11:00</option>
                                                <option value="11:30">11:30</option>
                                                <option value="12:00">12:00</option>
                                                <option value="12:30">12:30</option>
                                                <option value="13:00">13:00</option>
                                                <option value="18:00">18:00</option>
                                                <option value="18:30">18:30</option>
                                                <option value="19:00">19:00</option>
                                                <option value="19:30">19:30</option>
                                                <option value="20:00">20:00</option>
                                                <option value="20:30">20:30</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div className="mb-3">
                                        <label className="form-label">Nombre de personnes *</label>
                                        <select 
                                            className="form-control"
                                            value={reservationData.persons}
                                            onChange={(e) => setReservationData({...reservationData, persons: e.target.value})}
                                            required
                                        >
                                            <option value="">Sélectionnez le nombre</option>
                                            {Array.from({ length: 10 }, (_, i) => i + 1).map(num => (
                                                <option key={num} value={num}>
                                                    {num} {num === 1 ? 'personne' : 'personnes'}
                                                </option>
                                            ))}
                                        </select>
                                    </div>

                                    <div className="mb-4">
                                        <label className="form-label">Remarques (facultatif)</label>
                                        <textarea 
                                            className="form-control"
                                            rows="3"
                                            value={reservationData.remarque}
                                            onChange={(e) => setReservationData({...reservationData, remarque: e.target.value})}
                                            placeholder="Demandes spéciales, allergies, anniversaire, etc."
                                        ></textarea>
                                    </div>

                                    <div className="btn_box text-center">
                                        <button 
                                            type="submit" 
                                            className="btn btn-primary btn-lg px-5"
                                            disabled={isSubmitting}
                                        >
                                            {isSubmitting ? (
                                                <>
                                                    <i className="fa fa-spinner fa-spin me-2"></i>
                                                    Traitement...
                                                </>
                                            ) : (
                                                <>
                                                    <i className="fa fa-calendar-check me-2"></i>
                                                    Confirmer la Réservation
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

export default Book;
