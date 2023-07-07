<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Binding extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'impresion_id',
        'coste_engargolado',
        'fecha_engargolado',
        'estado',
        'encargado'
    ];

    public function bindings()
    {
        return $this->hasMany(Binding::class);
    }
}
