<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Impression extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id',
        'user_id',
        'numero_hojas',
        'numero_copias',
        'tamaño',
        'color',
        'impresora',
        'fecha_impresion',
        'total_hojas',
        'coste_impresion'
    ];
    
    public function impresiones()
    {
        return $this->hasMany(Impression::class);
    }
}
