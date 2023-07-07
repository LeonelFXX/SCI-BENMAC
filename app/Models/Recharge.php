<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recharge extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'monto',
        'fecha_recarga',
        'encargado'
    ];

    public function recargas()
    {
        return $this->hasMany(Recharge::class);
    }
}
