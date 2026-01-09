import React from 'react';

function LoadingSpinner({ size = 'medium', text = 'Chargement...' }) {
    const spinnerSizes = {
        small: '1rem',
        medium: '2rem',
        large: '3rem'
    };

    const spinnerSize = spinnerSizes[size] || spinnerSizes.medium;

    return (
        <div className="loading-spinner text-center">
            <div 
                className="spinner-border text-primary" 
                role="status"
                style={{ width: spinnerSize, height: spinnerSize }}
            >
                <span className="visually-hidden">{text}</span>
            </div>
            {text && <p className="mt-2">{text}</p>}
        </div>
    );
}

export default LoadingSpinner;
