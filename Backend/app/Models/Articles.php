<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    protected $fillable = [
        'nom','logo','description','prix','id_categorie','etat'
    ]; 
    public function categories()
    { 
        return $this->belongsTo(Categories::class,"id_categorie"); 
    }
}


