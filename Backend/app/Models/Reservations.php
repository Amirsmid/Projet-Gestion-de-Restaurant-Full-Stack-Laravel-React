<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservations extends Model
{
    protected $fillable = [
        'id_client','date','nb_pers','etat'
    ];
    public function clients()
    { 
        return $this->belongsTo(Clients::class,"id_client"); 
    }
}
