<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalzadoHasNumero extends Model
{
    use HasFactory;
    protected $table = 'calzado_has_numero';
    public $timestamps = false;
    protected $fillable = [
        'id_calzado_chn',
        'id_numero_chn',
        'existencias',
    ];
}
/**id_calzado_chn	id_numero_chn	existencias	 */