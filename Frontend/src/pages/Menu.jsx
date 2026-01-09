import { useState } from "react";
import { getCategories } from "../Services/CategoriesServices";
import { useEffect } from "react";
import { AllArticle, ArticleByCategory } from "../Services/Articleservice";
import { ImgUrl } from "../api/shared";
import { useShoppingCart } from 'use-shopping-cart';
import LoadingSpinner from "../components/LoadingSpinner";

function Menu() {

    const [categories, setCategories] = useState([]);
    const [articles, setArticles] = useState([]);
    const [category, setCategory] = useState('');
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const { addItem, cartCount } = useShoppingCart();

    const GetCategories = async () => {
        try {
            setLoading(true);
            const res = await getCategories()
            setCategories(res.data);
            console.log(res)
            console.log(res.data)
        } catch (error) {
            console.log(error);
            setError('Erreur lors du chargement des catégories');
        } finally {
            setLoading(false);
        }
    };
    
    const GetArticleByCategory = async (catId) => {
        try {
            setLoading(true);
            const res = await ArticleByCategory(catId)
            setArticles(res.data);
            console.log(res)
            console.log(res.data)
        } catch (error) {
            console.log(error);
            setError('Erreur lors du chargement des articles');
        } finally {
            setLoading(false);
        }
    };

    const GetAllArticle = async () => {
        try {
            setLoading(true);
            const res = await AllArticle()
            setArticles(res.data);
            console.log(res)
            console.log(res.data)
        } catch (error) {
            console.log(error);
            setError('Erreur lors du chargement des articles');
        } finally {
            setLoading(false);
        }
    };

    const handleAllArticle = () => {
        GetAllArticle()
    }

    useEffect(() => {
        GetCategories();
        if (category == '') {
            handleAllArticle();
        } else {
            GetArticleByCategory(category);
        }
    }, [category]);

    const handleArtCat = (idCat) => {
        setCategory(idCat)
    }

    const handleAddToCart = (article) => {
        try {
            addItem({
                id: article.id.toString(),
                name: article.nom,
                price: parseFloat(article.prix),
                image: article.logo ? `${ImgUrl}${article.logo}` : "src/assets/images/favicon.png",
                description: article.description,
                currency: 'TND'
            });
            
            // Notification de succès
            const notification = document.createElement('div');
            notification.className = 'alert alert-success position-fixed';
            notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            notification.innerHTML = `
                <i class="fa fa-check-circle me-2"></i>
                <strong>${article.nom}</strong> ajouté au panier !
            `;
            document.body.appendChild(notification);
            
            // Supprimer la notification après 3 secondes
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 3000);
            
        } catch (error) {
            console.error('Erreur lors de l\'ajout au panier:', error);
            alert('Erreur lors de l\'ajout au panier');
        }
    }

    if (loading) {
        return (
            <div className="container mt-5">
                <LoadingSpinner text="Chargement du menu..." />
            </div>
        );
    }

    if (error) {
        return (
            <div className="container mt-5">
                <div className="row justify-content-center">
                    <div className="col-md-8 text-center">
                        <h2 className="text-danger">Erreur</h2>
                        <p className="text-muted">{error}</p>
                        <button 
                            className="btn btn-primary"
                            onClick={() => window.location.reload()}
                        >
                            Réessayer
                        </button>
                    </div>
                </div>
            </div>
        );
    }

    return (
        <div>
            <section className="food_section layout_padding">
                <div className="container">
                    <div className="heading_container heading_center">
                        <h2 className="text-primary fw-bold">
                            Notre Menu
                        </h2>
                        <p className="text-muted mb-4">Découvrez nos délicieuses spécialités</p>
                        <div className="cart-info">
                            <span className="badge badge-primary fs-6 px-3 py-2">
                                <i className="fa fa-shopping-cart me-2"></i>
                                Panier: {cartCount} article{cartCount > 1 ? 's' : ''}
                            </span>
                        </div>
                    </div>

                    <ul className="filters_menu">
                        <li 
                            data-filter="*" 
                            onClick={() => handleAllArticle()}
                            className={category === '' ? 'active' : ''}
                        >
                            Toutes les catégories
                        </li>
                        {categories != undefined && categories.map((categorie) =>
                            <li 
                                key={categorie?.id} 
                                data-filter={`.${categorie?.nom}`} 
                                onClick={() => handleArtCat(categorie?.id)}
                                className={category === categorie?.id ? 'active' : ''}
                            >
                                {categorie?.nom}
                            </li>
                        )}
                    </ul>

                    <div className="filters-content">
                        <div className="row grid">
                            {articles != undefined && articles.length > 0 ? (
                                articles.map((article) =>
                                    <div key={article?.id} className="col-sm-6 col-lg-4 all pizza mb-4">
                                        <div className="box menu-card">
                                            <div className="img-box">
                                                {article?.logo ? (
                                                    <img
                                                        src={`${ImgUrl}${article.logo}`} 
                                                        alt={article?.nom}
                                                        className="menu-image"
                                                        onError={(e) => {
                                                            e.target.src = "src/assets/images/favicon.png";
                                                            e.target.alt = "Image par défaut";
                                                        }}
                                                    />
                                                ) : (
                                                    <img 
                                                        src="src/assets/images/favicon.png" 
                                                        alt="Image par défaut"
                                                        className="menu-image"
                                                    />
                                                )}
                                                <div className="price-badge">
                                                    <span className="price-text">{article?.prix} DT</span>
                                                </div>
                                            </div>
                                            <div className="detail-box">
                                                <h5 className="dish-name">
                                                    {article?.nom}
                                                </h5>
                                                <p className="dish-description">
                                                    {article?.description}
                                                </p>
                                                <div className="options">
                                                    <button 
                                                        className="btn btn-add-to-cart"
                                                        onClick={() => handleAddToCart(article)}
                                                    >
                                                        <i className="fa fa-plus me-2"></i>
                                                        Ajouter au panier
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                )
                            ) : (
                                <div className="col-12 text-center">
                                    <div className="no-items-found">
                                        <i className="fa fa-utensils fa-3x text-muted mb-3"></i>
                                        <h4 className="text-muted">Aucun article trouvé</h4>
                                        <p className="text-muted">Aucun article n'est disponible pour cette catégorie pour le moment.</p>
                                    </div>
                                </div>
                            )}
                        </div>
                    </div>
                   
                </div>
            </section>
        </div>
    )
}

export default Menu
