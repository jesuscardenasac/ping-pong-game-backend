<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    public $timestamps = false;
    protected $table = 'solicitudes';
    protected $fillable = [
        'id_user_emisor', 'id_user_receptor', 'estado',
    ];
    
    public function id_user_emisor()
    {
        return $this->belongsTo('App\User','id_user_emisor','id');
    }
    
    public function id_user_receptor()
    {
        return $this->belongsTo('App\User','id_user_receptor','id');
    }
    
    public function id_juego()
    {
        return $this->hasOne('App\Models\Juego','id_juego','id');
    }
}
