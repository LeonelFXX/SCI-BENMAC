<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalStudents extends Model
{
    use HasFactory;

    protected $connection = 'mysql_external';

    protected $table = 'estudiantes';
}
