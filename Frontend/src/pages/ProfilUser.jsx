import { useEffect, useState } from "react";
import { AddUser } from "../Services/ClientService";
import { useNavigate } from "react-router-dom";

function ProfilUser() {
  const [user, setUser] = useState({});
  const [isRegister, setIsRegister] = useState(true);
  const [message, setMessage] = useState({ type: "", text: "" });
  const navigate = useNavigate();

  const handleSubmit = async (event) => {
    event.preventDefault();
    
    // Validation côté client
    if (!user.nom || !user.prenom || !user.adresse || !user.telephone || !user.email || !user.password) {
      setMessage({
        type: "error",
        text: "Veuillez remplir tous les champs obligatoires.",
      });
      return;
    }

    if (user.password.length < 6) {
      setMessage({
        type: "error",
        text: "Le mot de passe doit contenir au moins 6 caractères.",
      });
      return;
    }

    if (!user.email.includes('@')) {
      setMessage({
        type: "error",
        text: "Veuillez entrer une adresse email valide.",
      });
      return;
    }

    try {
      const response = await AddUser(user);
      
      if (response.data.success) {
        // Stocker les données utilisateur complètes retournées par l'API
        const userData = response.data.user;
        localStorage.setItem("User", JSON.stringify(userData));
        
        setMessage({
          type: "success",
          text: "🎉 Votre compte a été créé avec succès !",
        });
        
        setTimeout(() => {
          navigate("/");
        }, 2000);
      } else {
        throw new Error(response.data.message || 'Erreur lors de l\'inscription');
      }
    } catch (error) {
      console.error('Erreur détaillée:', error);
      let errorMessage = "Erreur lors de l'inscription. Veuillez réessayer.";
      
      if (error.response && error.response.data) {
        if (error.response.data.errors) {
          // Afficher les erreurs de validation
          const errorKeys = Object.keys(error.response.data.errors);
          errorMessage = errorKeys.map(key => error.response.data.errors[key].join(', ')).join('; ');
        } else if (error.response.data.message) {
          errorMessage = error.response.data.message;
        }
      } else if (error.message) {
        errorMessage = error.message;
      }
      
      setMessage({
        type: "error",
        text: errorMessage,
      });
    }
  };

  const handleLogout = () => {
    localStorage.removeItem("User");
    navigate("/");
    window.location.reload();
  };

  const loadFromStorage = () => {
    const storedUser = localStorage.getItem("User");
    if (storedUser) {
      setUser(JSON.parse(storedUser));
      setIsRegister(false);
    }
  };

  useEffect(() => {
    loadFromStorage();
  }, []);

  // Formulaire d'inscription
  if (isRegister) {
    return (
      <section className="about_section py-5">
        <div className="container">
          <div className="row align-items-center">
            <div className="col-md-6 text-center mb-4 mb-md-0">
              <img
                src="/src/assets/images/about-img.png"
                alt="Bienvenue"
                className="img-fluid rounded shadow"
                style={{ maxWidth: "350px" }}
              />
              <h3 className="mt-4 text-primary fw-bold">Bienvenue !</h3>
              <p className="text-muted fs-5">
                Créez votre compte pour accéder à nos services
              </p>
            </div>
            <div className="col-md-6">
              <div className="card shadow-sm p-4">
                <h2 className="text-center mb-4 text-primary">Créer un Compte</h2>

                {message.text && (
                  <div
                    className={`alert alert-${
                      message.type === "success" ? "success" : "danger"
                    }`}
                  >
                    {message.type === "success" ? (
                      <div className="text-center">
                        <div className="mb-3">
                          <i className="fa fa-user-check fa-3x text-success"></i>
                        </div>
                        <h4 className="text-success mb-3">{message.text}</h4>
                        <p className="text-muted mb-0">
                          <i className="fa fa-spinner fa-spin me-2"></i>
                          <strong>Notification :</strong> Redirection automatique vers l'accueil...
                        </p>
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
                  <div className="row">
                    <div className="col-md-6 mb-3">
                      <label className="form-label fw-bold text-primary">
                        Nom de famille *
                      </label>
                      <input
                        type="text"
                        className="form-control"
                        value={user.nom || ""}
                        onChange={(e) =>
                          setUser({ ...user, nom: e.target.value })
                        }
                        placeholder="Votre nom de famille"
                        required
                      />
                    </div>
                    <div className="col-md-6 mb-3">
                      <label className="form-label fw-bold text-primary">
                        Prénom *
                      </label>
                      <input
                        type="text"
                        className="form-control"
                        value={user.prenom || ""}
                        onChange={(e) =>
                          setUser({ ...user, prenom: e.target.value })
                        }
                        placeholder="Votre prénom"
                        required
                      />
                    </div>
                  </div>

                  <div className="mb-3">
                    <label className="form-label fw-bold text-primary">
                      Adresse complète *
                    </label>
                    <input
                      type="text"
                      className="form-control"
                      value={user.adresse || ""}
                      onChange={(e) =>
                        setUser({ ...user, adresse: e.target.value })
                      }
                      placeholder="Votre adresse complète"
                      required
                    />
                  </div>

                  <div className="row">
                    <div className="col-md-6 mb-3">
                      <label className="form-label fw-bold text-primary">
                        Téléphone *
                      </label>
                      <input
                        type="tel"
                        className="form-control"
                        value={user.telephone || ""}
                        onChange={(e) =>
                          setUser({ ...user, telephone: e.target.value })
                        }
                        placeholder="Votre numéro de téléphone"
                        required
                      />
                    </div>
                    <div className="col-md-6 mb-3">
                      <label className="form-label fw-bold text-primary">
                        Email *
                      </label>
                      <input
                        type="email"
                        className="form-control"
                        value={user.email || ""}
                        onChange={(e) =>
                          setUser({ ...user, email: e.target.value })
                        }
                        placeholder="Votre adresse email"
                        required
                      />
                    </div>
                  </div>

                  <div className="mb-4">
                    <label className="form-label fw-bold text-primary">
                      Mot de passe *
                    </label>
                    <input
                      type="password"
                      className="form-control"
                      value={user.password || ""}
                      onChange={(e) =>
                        setUser({ ...user, password: e.target.value })
                      }
                      placeholder="Votre mot de passe"
                      required
                    />
                  </div>

                  <div className="d-grid">
                    <button type="submit" className="btn btn-primary btn-lg">
                      Créer le Compte
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>
    );
  }

  // Profil utilisateur connecté
  return (
    <section className="about_section py-5">
      <div className="container">
        <div className="row align-items-center">
          <div className="col-md-6 text-center mb-4 mb-md-0">
            <img
              src="/src/assets/images/about-img.png"
              alt="Profil"
              className="img-fluid rounded shadow"
              style={{ maxWidth: "350px" }}
            />
          </div>
          <div className="col-md-6">
            <div className="card shadow-sm p-4">
              <div className="d-flex justify-content-between align-items-center mb-3">
                <h2 className="text-primary">Profil Client</h2>
                <button
                  className="btn btn-danger"
                  onClick={handleLogout}
                >
                  Déconnexion
                </button>
              </div>

              {message.text && (
                <div
                  className={`alert alert-${
                    message.type === "success" ? "success" : "danger"
                  }`}
                >
                  {message.text}
                </div>
              )}

              <div className="profile-info">
                <h4>Informations Personnelles</h4>
                <div className="row mb-4">
                  <div className="col-md-6">
                    <p>
                      <strong>Nom :</strong> {user.nom}
                    </p>
                    <p>
                      <strong>Prénom :</strong> {user.prenom}
                    </p>
                    <p>
                      <strong>Email :</strong> {user.email}
                    </p>
                  </div>
                  <div className="col-md-6">
                    <p>
                      <strong>Téléphone :</strong> {user.telephone}
                    </p>
                    <p>
                      <strong>Adresse :</strong> {user.adresse}
                    </p>
                  </div>
                </div>

                <h5 className="text-primary mb-3 text-center">Actions Rapides</h5>
                <div className="row">
                  <div className="col-md-6 mb-3">
                    <a href="/BookTable" className="btn btn-primary w-100">
                      Réserver une Table
                    </a>
                  </div>
                  <div className="col-md-6 mb-3">
                    <a href="/menu" className="btn btn-success w-100">
                      Commander en Ligne
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}

export default ProfilUser;
