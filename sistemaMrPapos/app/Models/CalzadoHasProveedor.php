<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalzadoHasProveedor extends Model
{
    use HasFactory;

    protected $table = 'calzado_has_proveedor';
    public $timestamps = false;
    protected $fillable = [
        'id_calzado_chp',
        'id_proveedor_chp',
    ];
}
/**id_calzado_chp	id_proveedor_chp	 */