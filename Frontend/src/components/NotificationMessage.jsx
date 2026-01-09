import React from 'react';

function NotificationMessage({ type, title, details, icon, redirectTime = 5 }) {
    const getIcon = () => {
        switch (type) {
            case 'success':
                return icon || 'fa-check-circle';
            case 'error':
                return 'fa-exclamation-triangle';
            case 'warning':
                return 'fa-exclamation-circle';
            case 'info':
                return 'fa-info-circle';
            default:
                return 'fa-bell';
        }
    };

    const getColor = () => {
        switch (type) {
            case 'success':
                return 'success';
            case 'error':
                return 'danger';
            case 'warning':
                return 'warning';
            case 'info':
                return 'info';
            default:
                return 'primary';
        }
    };

    return (
        <div className={`alert alert-${getColor()} text-center`}>
            <div className="mb-3">
                <i className={`fa ${getIcon()} fa-3x text-${getColor()}`}></i>
            </div>
            <h4 className={`text-${getColor()} mb-3`}>{title}</h4>
            
            {details && (
                <div className="bg-light p-3 rounded">
                    <div className="row">
                        {Object.entries(details).map(([key, value]) => (
                            <div key={key} className="col-md-4 mb-2">
                                <strong className="text-capitalize">
                                    {key.replace(/([A-Z])/g, ' $1').trim()}:
                                </strong>
                                <br/>
                                <span className={`text-${getDetailColor(key)}`}>
                                    {key.includes('prix') || key.includes('total') ? `${value} DT` : 
                                     key.includes('id') || key.includes('facture') ? `#${value}` : value}
                                </span>
                            </div>
                        ))}
                    </div>
                    <hr/>
                    <p className="text-muted mb-0">
                        <i className="fa fa-bell me-2"></i>
                        <strong>Notification :</strong> Vous recevrez un email de confirmation. Redirection automatique dans {redirectTime} secondes...
                    </p>
                </div>
            )}
        </div>
    );
}

function getDetailColor(key) {
    if (key.includes('prix') || key.includes('total')) return 'success';
    if (key.includes('id') || key.includes('facture')) return 'primary';
    if (key.includes('date') || key.includes('heure')) return 'info';
    if (key.includes('personnes') || key.includes('nb_pers')) return 'warning';
    return 'secondary';
}

export default NotificationMessage;
