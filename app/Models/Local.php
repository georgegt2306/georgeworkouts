<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    use HasFactory;

    protected $table = "local";
    protected $fillable = [
        'ruc',
        'nombre',
        'descripcion',
        'telefono',
        'direccion',
        'latitud',
        'longitud',
        'id_admin',
        'url_image',
        'id_supervisor',
        'user_updated'
    ];

}
