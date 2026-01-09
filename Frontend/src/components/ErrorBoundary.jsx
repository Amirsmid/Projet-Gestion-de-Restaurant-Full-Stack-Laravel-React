import React from 'react';

class ErrorBoundary extends React.Component {
    constructor(props) {
        super(props);
        this.state = { hasError: false, error: null, errorInfo: null };
    }

    static getDerivedStateFromError(error) {
        return { hasError: true };
    }

    componentDidCatch(error, errorInfo) {
        this.setState({
            error: error,
            errorInfo: errorInfo
        });
        
        // Log l'erreur pour le débogage
        console.error('Error caught by boundary:', error, errorInfo);
    }

    render() {
        if (this.state.hasError) {
            return (
                <div className="container mt-5">
                    <div className="row justify-content-center">
                        <div className="col-md-8 text-center">
                            <h2>Oups ! Quelque chose s'est mal passé</h2>
                            <p>Une erreur inattendue s'est produite. Veuillez rafraîchir la page ou contacter le support.</p>
                            <button 
                                className="btn btn-primary"
                                onClick={() => window.location.reload()}
                            >
                                Rafraîchir la page
                            </button>
                            {process.env.NODE_ENV === 'development' && this.state.error && (
                                <details className="mt-3 text-left">
                                    <summary>Détails de l'erreur (développement)</summary>
                                    <pre className="mt-2 p-3 bg-light rounded">
                                        {this.state.error && this.state.error.toString()}
                                        <br />
                                        {this.state.errorInfo.componentStack}
                                    </pre>
                                </details>
                            )}
                        </div>
                    </div>
                </div>
            );
        }

        return this.props.children;
    }
}

export default ErrorBoundary;
