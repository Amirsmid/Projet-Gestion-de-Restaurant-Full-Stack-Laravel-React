import React from 'react';

function SuccessMessage({ title, details, icon, redirectTime = 5 }) {
    return (
        <div className="alert alert-success text-center">
            <div className="mb-3">
                <i className={`fa ${icon} fa-3x text-success`}></i>
            </div>
            <h4 className="text-success mb-3">{title}</h4>
            
            {details && (
                <div className="bg-light p-3 rounded">
                    <div className="row">
                        {Object.entries(details).map(([key, value]) => (
                            <div key={key} className="col-md-4 mb-2">
                                <strong className="text-capitalize">
                                    {key.replace(/([A-Z])/g, ' $1').trim()}:
                                </strong>
                                <br/>
                                <span className={`text-${getColorForKey(key)}`}>
                                    {key.includes('prix') ? `${value} DT` : 
                                     key.includes('id') ? `#${value}` : value}
                                </span>
                            </div>
                        ))}
                    </div>
                    <hr/>
                    <p className="text-muted mb-0">
                        <i className="fa fa-info-circle me-2"></i>
                        Vous recevrez un email de confirmation. Redirection dans {redirectTime} secondes...
                    </p>
                </div>
            )}
        </div>
    );
}

function getColorForKey(key) {
    if (key.includes('prix') || key.includes('total')) return 'success';
    if (key.includes('id') || key.includes('facture')) return 'primary';
    if (key.includes('date') || key.includes('heure')) return 'info';
    if (key.includes('personnes') || key.includes('nb_pers')) return 'warning';
    return 'secondary';
}

export default SuccessMessage;
