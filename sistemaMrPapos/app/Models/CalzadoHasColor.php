<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalzadoHasColor extends Model
{
    use HasFactory;
    protected $table = 'calzado_has_color';

    protected $fillable = [
        'id_calzado_chc',
        'id_color_chc',
    ];
}
/*
id_calzado_chc	
id_color_chc */