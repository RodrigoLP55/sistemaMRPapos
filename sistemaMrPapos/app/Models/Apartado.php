<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartado extends Model
{
    use HasFactory;
    
    protected $table = 'apartado';

    protected $fillable = [
        'campo',
    ];
}
