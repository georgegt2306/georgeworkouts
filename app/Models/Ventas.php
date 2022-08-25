<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ventas extends Model
{
    use HasFactory;

    protected $table = "ventas";
    protected $fillable = [
        'id_local',
        'ruc_local',
        'nombre_local',
        'direccion_local',
        'id_vendedor',
        'nombre_vendedor',
        'apellido_vendedor',
        'ci_ruc_vendedor',
        'direccion_vendedor',
        'email_vendedor',
        'id_cliente',
        'nombre_cliente',
        'apellido_cliente',
        'direccion_cliente',
        'ci_ruc_cliente',
        'email_cliente',
        'fecha',
        'subtotal',
        'descuento',
        'porcentaje_descuento',
        'subtotal_neto',
        'iva',
        'porcentaje_iva',
        'total',
        'descripcion_venta',
        'id_estado',
    ];
}
