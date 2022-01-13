<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calzado extends Model
{
    use HasFactory;

    protected $table = 'calzado';

    protected $fillable = [
        'marca',
        'modelo',
        'precio_v',
        'precio_c',
        'id_tipo_c',
    ];
}
/*
id_calzado	
marca	
modelo	
precio_v	
id_tipo_c*/