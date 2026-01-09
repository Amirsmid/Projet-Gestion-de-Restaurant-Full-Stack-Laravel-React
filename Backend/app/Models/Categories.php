<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $fillable = [
        'nom','logo','etat'
    ]; 
    public function catgsArticles()
    {
        return $this->hasMany(Articles::class, 'id_categorie');
    }
}
