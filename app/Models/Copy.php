<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Copy extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'numero_copias',
        'color',
        'blanco_y_negro',
        'coste_copias',
        'fecha_copias',
        'estado',
        'encargado'
    ];
}
