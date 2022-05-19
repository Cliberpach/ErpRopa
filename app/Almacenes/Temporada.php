<?php

namespace App\Almacenes;

use Illuminate\Database\Eloquent\Model;

class Temporada extends Model
{
    protected $table="temporada";
    protected $fillable=[
        'nombre',
        'estado'
    ];
    public $timestamps=true;
    public function productos()
    {
        return $this->hasMany(Producto::class,'temporada_id');
    }
}
