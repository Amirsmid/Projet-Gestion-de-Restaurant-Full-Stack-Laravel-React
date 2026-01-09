import Menu from "./Menu"

function Accueil() {
    return (
        <div>
            <div className="hero_area">
                <div className="bg-box">
                    <img src="src/assets/images/hero-bg.jpg" alt="" />
                </div>
                <section className="slider_section ">
                    <div id="customCarousel1" className="carousel slide" data-ride="carousel">
                        <div className="carousel-inner">
                            <div className="carousel-item active">
                                <div className="container ">
                                    <div className="row">
                                        <div className="col-md-7 col-lg-6 ">
                                            <div className="detail-box">
                                                <h1>
                                                    Fast Food Restaurant
                                                </h1>
                                                <p>
                                                    Découvrez nos délicieuses spécialités et profitez d'une expérience culinaire exceptionnelle. 
                                                    Notre équipe passionnée vous accueille dans un cadre chaleureux et convivial.
                                                </p>
                                                <div className="btn-box">
                                                    <a href="/menu" className="btn1">
                                                        Commander Maintenant
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div className="carousel-item ">
                                <div className="container ">
                                    <div className="row">
                                        <div className="col-md-7 col-lg-6 ">
                                            <div className="detail-box">
                                                <h1>
                                                    Cuisine d'Excellence
                                                </h1>
                                                <p>
                                                    Nos chefs talentueux préparent chaque plat avec passion et des ingrédients frais de qualité. 
                                                    Une expérience gastronomique unique vous attend.
                                                </p>
                                                <div className="btn-box">
                                                    <a href="/menu" className="btn1">
                                                        Voir le Menu
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div className="carousel-item">
                                <div className="container ">
                                    <div className="row">
                                        <div className="col-md-7 col-lg-6 ">
                                            <div className="detail-box">
                                                <h1>
                                                    Service Premium
                                                </h1>
                                                <p>
                                                    Profitez d'un service attentionné et d'une ambiance conviviale. 
                                                    Réservez votre table et laissez-nous prendre soin de vous.
                                                </p>
                                                <div className="btn-box">
                                                    <a href="/BookTable" className="btn1">
                                                        Réserver une Table
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="container">
                            <ol className="carousel-indicators">
                                <li data-target="#customCarousel1" data-slide-to="0" className="active"></li>
                                <li data-target="#customCarousel1" data-slide-to="1"></li>
                                <li data-target="#customCarousel1" data-slide-to="2"></li>
                            </ol>
                        </div>
                    </div>

                </section>
            </div>


            <section className="offer_section layout_padding-bottom">
                <div className="offer_container">
                    <div className="container ">
                        <div className="row">
                            <div className="col-md-6  ">
                                <div className="box ">
                                    <div className="img-box">
                                        <img src="src/assets/images/o1.jpg" alt="" />
                                    </div>
                                    <div className="detail-box">
                                        <h5>
                                            Jeudis Gourmands
                                        </h5>
                                        <h6>
                                            <span>20%</span> de Réduction
                                        </h6>
                                        <a href="/menu">
                                            Commander Maintenant
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div className="col-md-6  ">
                                <div className="box ">
                                    <div className="img-box">
                                        <img src="src/assets/images/o2.jpg" alt="" />
                                    </div>
                                    <div className="detail-box">
                                        <h5>
                                            Journées Pizza
                                        </h5>
                                        <h6>
                                            <span>15%</span> de Réduction
                                        </h6>
                                        <a href="/menu">
                                            Commander Maintenant
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <Menu />

            {/* Section d'actions rapides */}
            <section className="quick_actions_section layout_padding">
                <div className="container">
                    <div className="heading_container text-center mb-5">
                        <h2 className="text-primary">Que souhaitez-vous faire ?</h2>
                        <p className="text-muted">Choisissez votre option préférée</p>
                    </div>
                    
                    <div className="row justify-content-center">
                        <div className="col-md-4 mb-4">
                            <div className="action-card text-center p-4">
                                <div className="action-icon mb-3">
                                    <i className="fa fa-calendar fa-4x text-primary"></i>
                                </div>
                                <h4 className="text-primary mb-3">Réserver une Table</h4>
                                <p className="text-muted mb-4">
                                    Réservez votre table pour une expérience en restaurant. 
                                    Choisissez votre date et heure préférées.
                                </p>
                                <a href="/BookTable" className="btn btn-primary btn-lg">
                                    <i className="fa fa-calendar-plus me-2"></i>
                                    Réserver Maintenant
                                </a>
                            </div>
                        </div>
                        
                        <div className="col-md-4 mb-4">
                            <div className="action-card text-center p-4">
                                <div className="action-icon mb-3">
                                    <i className="fa fa-shopping-cart fa-4x text-success"></i>
                                </div>
                                <h4 className="text-success mb-3">Commander en Ligne</h4>
                                <p className="text-muted mb-4">
                                    Commandez vos plats préférés en ligne. 
                                    Livraison rapide ou retrait sur place.
                                </p>
                                <a href="/menu" className="btn btn-success btn-lg">
                                    <i className="fa fa-utensils me-2"></i>
                                    Voir le Menu
                                </a>
                            </div>
                        </div>
                        
                        <div className="col-md-4 mb-4">
                            <div className="action-card text-center p-4">
                                <div className="action-icon mb-3">
                                    <i className="fa fa-user-plus fa-4x text-info"></i>
                                </div>
                                <h4 className="text-info mb-3">Créer un Compte</h4>
                                <p className="text-muted mb-4">
                                    Créez votre compte pour suivre vos commandes 
                                    et bénéficier d'offres exclusives.
                                </p>
                                <a href="/Profil" className="btn btn-info btn-lg">
                                    <i className="fa fa-user-plus me-2"></i>
                                    S'inscrire
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section className="about_section layout_padding">
                <div className="container  ">

                    <div className="row">
                        <div className="col-md-6 ">
                            <div className="img-box">
                                <img src="src/assets/images/about-img.png" alt="" />
                            </div>
                        </div>
                        <div className="col-md-6">
                            <div className="detail-box">
                                <div className="heading_container">
                                    <h2>
                                        Nous Sommes Feane
                                    </h2>
                                </div>
                                <p>
                                    Depuis plus de 20 ans, notre restaurant s'engage à offrir une expérience culinaire exceptionnelle. 
                                    Nous sélectionnons avec soin les meilleurs ingrédients et créons des plats uniques qui éveillent vos sens. 
                                    Notre équipe passionnée s'efforce de vous offrir un service impeccable dans une ambiance chaleureuse et conviviale.
                                </p>
                                <a href="/menu">
                                    En Savoir Plus
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* Section d'informations supplémentaires */}
            <section className="info_section layout_padding">
                <div className="container">
                    <div className="row">
                        <div className="col-md-4 text-center">
                            <div className="info-card">
                                <i className="fa fa-clock-o fa-3x text-primary mb-3"></i>
                                <h5 className="text-primary">Horaires d'ouverture</h5>
                                <p className="text-muted">
                                    Lundi - Dimanche<br />
                                    11:00 - 14:00<br />
                                    18:00 - 22:00
                                </p>
                            </div>
                        </div>
                        
                        <div className="col-md-4 text-center">
                            <div className="info-card">
                                <i className="fa fa-phone fa-3x text-primary mb-3"></i>
                                <h5 className="text-primary">Contact</h5>
                                <p className="text-muted">
                                    Téléphone: +216 XX XXX XXX<br />
                                    Email: contact@restaurant.com
                                </p>
                            </div>
                        </div>
                        
                        <div className="col-md-4 text-center">
                            <div className="info-card">
                                <i className="fa fa-map-marker fa-3x text-primary mb-3"></i>
                                <h5 className="text-primary">Adresse</h5>
                                <p className="text-muted">
                                    123 Rue de la Gastronomie<br />
                                    Tunis, Tunisie
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    )
}

export default Accueil
