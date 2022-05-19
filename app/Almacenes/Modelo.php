<?php

namespace App\Almacenes;

use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    protected $table="modelo";
    protected $fillable=[
        'nombre',
        'estado'
    ];
    public $timestamps=true;
    public function productos()
    {
        return $this->hasMany(Producto::class,'modelo_id');
    }
}
