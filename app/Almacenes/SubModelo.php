<?php

namespace App\Almacenes;

use Illuminate\Database\Eloquent\Model;

class SubModelo extends Model
{
    protected $table="sub_modelo";
    protected $fillable=[
        'nombre',
        'estado'
    ];
    public $timestamps=true;
    public function productos()
    {
        return $this->hasMany(Producto::class,'sub_modelo_id');
    }
}
