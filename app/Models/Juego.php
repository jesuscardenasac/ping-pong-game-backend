<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Juego extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'id_solicitud', 'estado',
    ];
    
    public function id_solicitud()
    {
        return $this->belongsTo('App\Models\Solicitud','id_solicitud','id');
    }
    
    public function id_partida()
    {
        return $this->hasMany('App\Models\Partida','id_partida','id');
    }
}
