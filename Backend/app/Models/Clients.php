<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Clients extends Model
{
    protected $fillable = [
        'nom',
        'prenom', 
        'adresse',
        'telephone',
        'etat',
        'id_user'
    ];
    
    protected $table = 'clients';

    /**
     * Relation avec le modèle User
     */
    public function user(): BelongsTo
    { 
        return $this->belongsTo(User::class, 'id_user'); 
    }

    /**
     * Relation avec les commandes
     */
    public function commandes()
    {
        return $this->hasMany(Commendes::class, 'id_client');
    }

    /**
     * Relation avec les réservations
     */
    public function reservations()
    {
        return $this->hasMany(Reservations::class, 'id_client');
    }

    /**
     * Accesseur pour le nom complet
     */
    public function getNomCompletAttribute()
    {
        return $this->nom . ' ' . $this->prenom;
    }

    /**
     * Vérifier si le client est actif
     */
    public function isActive()
    {
        return $this->etat === 0;
    }
}
