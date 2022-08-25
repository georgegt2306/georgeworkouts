<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = "producto";
    protected $fillable = [
        'nombre',
        'descripcion',
        'url_imagen',
        'costo',
        'precio',
        'unidad',
        'existencia',
        'descuento',
        'id_local',
        'id_categoria',
        'tasa_iva',
        'user_updated',
    ];

    public $timestamps = false;
}
