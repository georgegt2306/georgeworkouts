<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vend_local extends Model
{
    use HasFactory;

    protected $table = "vend_local";
    protected $fillable = [
        'id_local',
        'id_vendedor',
        'user_updated',
    ];
}
