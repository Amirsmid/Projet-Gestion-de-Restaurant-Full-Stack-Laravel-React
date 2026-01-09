import React from 'react';
import { useShoppingCart } from 'use-shopping-cart';
import { useNavigate } from 'react-router-dom';
import { ImgUrl } from "../api/shared";

function Cart() {
    const { 
        cartDetails, 
        removeItem, 
        updateItemQuantity, 
        clearCart,
        totalPrice,
        cartCount,
        addItem
    } = useShoppingCart();
    
    const navigate = useNavigate();

    const handleCheckout = () => {
        navigate('/checkout');
    };

    if (cartCount === 0) {
        return (
            <div className="container mt-5">
                <div className="row justify-content-center">
                    <div className="col-md-8 text-center">
                        <div className="empty-cart">
                            <i className="fa fa-shopping-cart fa-4x text-muted mb-4"></i>
                            <h2 className="text-primary">Votre panier est vide</h2>
                            <p className="text-muted mb-4">Ajoutez de délicieux articles depuis notre menu !</p>
                            <button 
                                className="btn btn-primary btn-lg"
                                onClick={() => navigate('/menu')}
                            >
                                <i className="fa fa-utensils me-2"></i>
                                Aller au menu
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        );
    }

    return (
        <div className="container mt-5">
            <div className="row">
                <div className="col-md-8">
                    <div className="cart-header mb-4">
                        <h2 className="text-primary">
                            <i className="fa fa-shopping-cart me-3"></i>
                            Panier d'achat ({cartCount} article{cartCount > 1 ? 's' : ''})
                        </h2>
                        <p className="text-muted">Vérifiez vos articles avant de finaliser votre commande</p>
                    </div>
                    
                    <div className="cart-items">
                        {Object.values(cartDetails).map((item) => (
                            <div key={item.id} className="cart-item-card mb-3">
                                <div className="row g-0">
                                    <div className="col-md-3">
                                        <div className="cart-item-image">
                                            <img 
                                                src={item.image} 
                                                className="img-fluid rounded-start" 
                                                alt={item.name}
                                                onError={(e) => {
                                                    e.target.src = "src/assets/images/favicon.png";
                                                    e.target.alt = "Image par défaut";
                                                }}
                                            />
                                        </div>
                                    </div>
                                    <div className="col-md-9">
                                        <div className="cart-item-details">
                                            <h5 className="cart-item-name">{item.name}</h5>
                                            <p className="cart-item-description">{item.description}</p>
                                            <div className="cart-item-controls">
                                                <div className="quantity-controls">
                                                    <button 
                                                        className="btn btn-outline-secondary btn-sm"
                                                        onClick={() => {
                                                            if (item.quantity > 1) {
                                                                removeItem(item.id);
                                                                addItem({
                                                                    id: item.id,
                                                                    name: item.name,
                                                                    price: item.price,
                                                                    image: item.image,
                                                                    description: item.description,
                                                                    currency: item.currency
                                                                }, { count: item.quantity - 1 });
                                                            }
                                                        }}
                                                        disabled={item.quantity <= 1}
                                                    >
                                                        <i className="fa fa-minus"></i>
                                                    </button>
                                                    <span className="quantity-display">{item.quantity}</span>
                                                    <button 
                                                        className="btn btn-outline-secondary btn-sm"
                                                        onClick={() => {
                                                            removeItem(item.id);
                                                            addItem({
                                                                id: item.id,
                                                                name: item.name,
                                                                price: item.price,
                                                                image: item.image,
                                                                description: item.description,
                                                                currency: item.currency
                                                            }, { count: item.quantity + 1 });
                                                        }}
                                                    >
                                                        <i className="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                                <div className="price-info">
                                                    <span className="item-price">{item.price * item.quantity} DT</span>
                                                    <button 
                                                        className="btn btn-danger btn-sm ms-3"
                                                        onClick={() => removeItem(item.id)}
                                                    >
                                                        <i className="fa fa-trash me-1"></i>
                                                        Supprimer
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
                
                <div className="col-md-4">
                    <div className="order-summary-card">
                        <div className="card-header">
                            <h5 className="text-primary mb-0">
                                <i className="fa fa-calculator me-2"></i>
                                Récapitulatif de la commande
                            </h5>
                        </div>
                        <div className="card-body">
                            <div className="summary-item">
                                <span>Sous-total:</span>
                                <span className="summary-value">{totalPrice} DT</span>
                            </div>
                            <div className="summary-item">
                                <span>TVA (7%):</span>
                                <span className="summary-value">{(totalPrice * 0.07).toFixed(2)} DT</span>
                            </div>
                            <hr className="summary-divider" />
                            <div className="summary-total">
                                <strong>Total:</strong>
                                <strong className="total-amount">{(totalPrice * 1.07).toFixed(2)} DT</strong>
                            </div>
                            
                            <div className="summary-actions mt-4">
                                <button 
                                    className="btn btn-success w-100 mb-3"
                                    onClick={handleCheckout}
                                >
                                    <i className="fa fa-credit-card me-2"></i>
                                    Procéder au paiement
                                </button>
                                <button 
                                    className="btn btn-outline-danger w-100"
                                    onClick={clearCart}
                                >
                                    <i className="fa fa-trash me-2"></i>
                                    Vider le panier
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Cart;
