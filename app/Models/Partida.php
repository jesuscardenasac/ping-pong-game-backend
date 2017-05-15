<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partida extends Model
{
    protected $fillable = [
        'id_juego', 'puntos_emisor', 'puntos_receptor', 'estado'
    ];
    
    public function id_juego()
    {
        return $this->belongsTo('App\Models\Juego','id_juego','id');
    }
}
