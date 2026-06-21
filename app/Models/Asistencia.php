<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $fillable = [
        'beneficiario_id',
        'fecha',
        'evento',
        'presente',
        'observaciones',
    ];

    protected $casts = [
        'fecha'    => 'date',
        'presente' => 'boolean',
    ];

    public function beneficiario()
    {
        return $this->belongsTo(Beneficiario::class);
    }
}
