<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commendes extends Model
{
    protected $fillable = [
        'prix',
        'id_client',
        'numFact',
        'etat',
        'lieu',
        'description',
        'created_at',
        'updated_at'
    ];

    public function clients()
    { 
        return $this->belongsTo(Clients::class,"id_client"); 
    }
    public function lignieComnd()
    {
        return $this->hasMany(CommendeLignies::class, 'id_commende');
    }
}
