import { useState } from 'react';
import axios from '../api/axios';

function ApiTester() {
    const [testResults, setTestResults] = useState([]);
    const [isTesting, setIsTesting] = useState(false);

    const runTests = async () => {
        setIsTesting(true);
        setTestResults([]);
        
        const tests = [
            {
                name: 'Test récupération des paramètres',
                endpoint: 'parameter',
                method: 'GET'
            },
            {
                name: 'Test récupération des catégories',
                endpoint: 'tout_categorie',
                method: 'GET'
            },
            {
                name: 'Test récupération des articles',
                endpoint: 'tout_article',
                method: 'GET'
            }
        ];

        for (const test of tests) {
            try {
                let response;
                if (test.method === 'GET') {
                    response = await axios.get(test.endpoint);
                } else {
                    response = await axios.post(test.endpoint, {});
                }

                setTestResults(prev => [...prev, {
                    name: test.name,
                    success: true,
                    status: response.status,
                    data: response.data
                }]);
            } catch (error) {
                setTestResults(prev => [...prev, {
                    name: test.name,
                    success: false,
                    error: error.message,
                    response: error.response?.data
                }]);
            }
        }
        
        setIsTesting(false);
    };

    const testUserCreation = async () => {
        setIsTesting(true);
        
        try {
            const testUser = {
                nom: 'Test',
                prenom: 'User',
                adresse: '123 Test Street',
                telephone: '123456789',
                email: `test${Date.now()}@example.com`,
                password: 'password123'
            };

            const response = await axios.post('inscrit_client', testUser);
            
            setTestResults(prev => [...prev, {
                name: 'Test création d\'utilisateur',
                success: response.data.success,
                status: response.status,
                data: response.data
            }]);
        } catch (error) {
            setTestResults(prev => [...prev, {
                name: 'Test création d\'utilisateur',
                success: false,
                error: error.message,
                response: error.response?.data
            }]);
        }
        
        setIsTesting(false);
    };

    return (
        <div className="container mt-5">
            <div className="card">
                <div className="card-header">
                    <h3>Testeur d'API</h3>
                    <p className="text-muted">Testez les endpoints de l'API pour vérifier leur fonctionnement</p>
                </div>
                <div className="card-body">
                    <div className="mb-3">
                        <button 
                            className="btn btn-primary me-2" 
                            onClick={runTests}
                            disabled={isTesting}
                        >
                            {isTesting ? 'Test en cours...' : 'Tester les endpoints de base'}
                        </button>
                        <button 
                            className="btn btn-success" 
                            onClick={testUserCreation}
                            disabled={isTesting}
                        >
                            {isTesting ? 'Test en cours...' : 'Tester la création d\'utilisateur'}
                        </button>
                    </div>

                    {testResults.length > 0 && (
                        <div className="test-results">
                            <h5>Résultats des tests :</h5>
                            {testResults.map((result, index) => (
                                <div key={index} className={`alert alert-${result.success ? 'success' : 'danger'} mb-2`}>
                                    <strong>{result.name}</strong>
                                    {result.success ? (
                                        <div>
                                            <p className="mb-1">✅ Succès (HTTP {result.status})</p>
                                            <small className="text-muted">
                                                Réponse: {JSON.stringify(result.data, null, 2)}
                                            </small>
                                        </div>
                                    ) : (
                                        <div>
                                            <p className="mb-1">❌ Échec</p>
                                            <p className="mb-1">Erreur: {result.error}</p>
                                            {result.response && (
                                                <small className="text-muted">
                                                    Réponse API: {JSON.stringify(result.response, null, 2)}
                                                </small>
                                            )}
                                        </div>
                                    )}
                                </div>
                            ))}
                        </div>
                    )}
                </div>
            </div>
        </div>
    );
}

export default ApiTester;
