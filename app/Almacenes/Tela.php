<?php

namespace App\Almacenes;

use Illuminate\Database\Eloquent\Model;

class Tela extends Model
{
    protected $table="tela";
    protected $fillable=[
        'nombre',
        'estado'
    ];
    public $timestamps=true;
    public function productos()
    {
        return $this->hasMany(Producto::class,'tela_id');
    }
}
