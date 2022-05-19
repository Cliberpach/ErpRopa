<?php

namespace App\Almacenes;

use Illuminate\Database\Eloquent\Model;

class Talla extends Model
{
    protected $table="talla";
    protected $fillable=[
        'nombre',
        'estado'
    ];
    public $timestamps=true;
    public function productos()
    {
        return $this->hasMany(Producto::class,'talla_id');
    }
}
