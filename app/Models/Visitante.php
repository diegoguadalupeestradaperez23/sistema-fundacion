<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitante extends Model
{
    protected $fillable = ['nombre', 'fecha', 'evento'];

    protected $casts = ['fecha' => 'date'];
}
