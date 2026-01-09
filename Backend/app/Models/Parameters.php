<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parameters extends Model
{
    protected $fillable = [
        'nom','logo','email','tel','adresse','caisse'
    ]; 
}

