<?php

namespace App\Almacenes;

use Illuminate\Database\Eloquent\Model;

class Genero extends Model
{
    protected $table="genero";
    protected $fillable=[
        'nombre',
        'estado'
    ];
    public $timestamps=true;
    public function productos()
    {
        return $this->hasMany(Producto::class,'genero_id');
    }
}
