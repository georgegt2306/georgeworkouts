<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalle_venta extends Model
{
    use HasFactory;
    protected $table = "detalle_venta";
    protected $fillable = [
        'id_venta',
        'id_producto',
        'id_local',
        'nombre',
        'descripcion',
        'costo',
        'precio',
        'url_image',
        'cantidad',
        'subtotal',
        'descuento',
        'porcentaje_descuento',
        'subtotal_neto',
        'iva',
        'porcentaje_iva',
        'total',
    ];

}
