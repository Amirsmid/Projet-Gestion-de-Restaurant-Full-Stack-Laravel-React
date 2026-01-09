import { Link, useNavigate } from "react-router-dom"
import { GetParams } from "../Services/Parameter";
import { useEffect, useState } from "react";
import { useShoppingCart } from 'use-shopping-cart';
import { ImgUrl } from "../api/shared";

function NavBar() {
    const [param, setParam] = useState();
    const [logoError, setLogoError] = useState(false);
    let [customer, setCustomer] = useState({});
    const { cartCount, clearCart } = useShoppingCart();
    const navigate = useNavigate();

    const GetParam = async () => {
        try {
            const res = await GetParams()
            setParam(res.data);
            console.log(res)
            console.log(res.data)
        } catch (error) {
            console.log(error);
        }
    };
    
    const loadFromStorage = async () => {
        const user = localStorage.getItem("User");
        if (user) {
            try {
                const customer = JSON.parse(user);
                setCustomer(customer);
                console.log('Utilisateur chargé:', customer);
            } catch (error) {
                console.error('Erreur lors du parsing des données utilisateur:', error);
                localStorage.removeItem("User");
                setCustomer(undefined);
            }
        } else {
            setCustomer(undefined);
        }
    }

    const handleLogout = () => {
        // Supprimer les données utilisateur du localStorage
        localStorage.removeItem("User");
        // Vider le panier
        clearCart();
        // Rediriger vers l'accueil
        navigate('/');
        // Recharger la page pour mettre à jour l'état
        window.location.reload();
    };

    const handleLogoError = () => {
        setLogoError(true);
    };

    useEffect(() => {
        loadFromStorage()
        GetParam();
    }, []);

    return (
        <div>
            <header className="header_section" style={{ backgroundColor: '#0a0d10' }}>
                <div className="container">
                    <nav className="navbar navbar-expand-lg custom_nav-container ">
                        <a className="navbar-brand" href="/" style={{ display: 'flex', alignItems: 'center' }}>
                            {param?.logo && !logoError ? (
                                <img
                                    src={`${ImgUrl}${param.logo}`}
                                    width={60} 
                                    height={60}
                                    alt="Logo Restaurant"
                                    style={{ 
                                        objectFit: 'contain', 
                                        maxHeight: '60px',
                                        borderRadius: '8px',
                                        boxShadow: '0 2px 8px rgba(0,0,0,0.2)'
                                    }}
                                    onError={handleLogoError}
                                />
                            ) : (
                                <img
                                    src="/src/assets/images/logo-default.svg"
                                    width={60} 
                                    height={60}
                                    alt="Logo Restaurant"
                                    style={{ 
                                        objectFit: 'contain', 
                                        maxHeight: '60px',
                                        borderRadius: '8px',
                                        boxShadow: '0 2px 8px rgba(0,0,0,0.2)'
                                    }}
                                    onError={() => setLogoError(true)}
                                />
                            )}
                            {/* Fallback texte si les images échouent */}
                            {logoError && (
                                <span style={{ 
                                    fontSize: '32px', 
                                    fontWeight: 'bold', 
                                    color: '#ffffff',
                                    fontFamily: 'Dancing Script, cursive',
                                    marginLeft: '10px',
                                    textShadow: '2px 2px 4px rgba(0,0,0,0.5)'
                                }}>
                                    {param?.nom || 'Restaurant'}
                                </span>
                            )}
                        </a>

                        <button className="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span className=""> </span>
                        </button>

                        <div className="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul className="navbar-nav  mx-auto ">
                                <li className="nav-item">
                                    <Link className="nav-link" to="/">Home</Link>
                                </li>
                                <li className="nav-item">
                                    <Link className="nav-link" to="/menu">Menu</Link>
                                </li>
                                <li className="nav-item">
                                    <Link className="nav-link" to="/BookTable">Book Table</Link>
                                </li>
                                {/* <li className="nav-item">
                                    <a className="nav-link" href="about.html">About</a>
                                </li> */}
                            </ul>
                            <div className="user_option">
                                {customer !== undefined ? (
                                    <div className="d-flex align-items-center">
                                        <Link className="user_link me-3" to="/Profil">
                                            <i className="fa fa-user" aria-hidden="true">  {customer.prenom} </i>
                                        </Link>
                                        <button 
                                            className="btn btn-outline-light btn-sm"
                                            onClick={handleLogout}
                                            title="Déconnexion"
                                        >
                                            <i className="fa fa-sign-out"></i>
                                        </button>
                                    </div>
                                ) : (
                                    <Link className="user_link" to="/Profil">
                                        <i className="fa fa-user" aria-hidden="true"></i>
                                    </Link>
                                )}
                                {/* <Link className="user_link" to="/Profil">
                                    <i className="fa fa-user" aria-hidden="true"></i>
                                </Link> */}
                                <Link className="cart_link" to="/cart" style={{ position: 'relative', textDecoration: 'none', color: '#fff' }}>
                                    <i className="fa fa-shopping-cart" aria-hidden="true"></i>
                                    {cartCount > 0 && (
                                        <span 
                                            className="badge badge-danger" 
                                            style={{ 
                                                position: 'absolute', 
                                                top: '-8px', 
                                                right: '-8px', 
                                                fontSize: '12px',
                                                backgroundColor: '#dc3545'
                                            }}
                                        >
                                            {cartCount}
                                        </span>
                                    )}
                                </Link>
                                <form className="form-inline">
                                    <button className="btn  my-2 my-sm-0 nav_search-btn" type="submit">
                                        <i className="fa fa-search" aria-hidden="true"></i>
                                    </button>
                                </form>
                                <Link to="/menu" className="order_online" style={{ textDecoration: 'none' }}>
                                    Order Online
                                </Link>
                            </div>
                        </div>
                    </nav>
                </div>
            </header>
        </div>
    )
}

export default NavBar
