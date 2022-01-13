<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
    protected $table = 'proveedor';

    protected $fillable = [
        'razon_social',
        'email',
        'id_telefono_p',
        'id_direccion_p',
    ];
}
/***
razon_social
email
id_telefono_p
id_direccion_p */