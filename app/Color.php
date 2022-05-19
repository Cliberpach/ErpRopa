<?php

namespace App;

use App\Almacenes\Producto;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    //
    protected $table="color";
    protected $fillable=[
        'nombre',
        'estado'
    ];
    public $timestamps=true;
    public function productos()
    {
        return $this->hasMany(Producto::class,'color_id');
    }
}
