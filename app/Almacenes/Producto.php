<?php

namespace App\Almacenes;

use App\Color;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'almacen_id',
        'marca_id',
        'categoria_id',
        'medida',
        'stock',
        'stock_minimo',
        'precio_venta_minimo',
        'precio_venta_maximo',
        'igv',
        'estado',
        'codigo_barra',
        'peso_producto',
        'porcentaje_normal',
        'porcentaje_distribuidor',
        'color_id',
        'modelo_id',
        'tela_id',
        'talla_id',
        'sub_modelo_id',
        'temporada_id',
        'genero_id'
    ];
    protected $casts = [
        'igv' => 'boolean'
    ];
    public function almacen()
    {
        return $this->belongsTo('App\Almacenes\Almacen');
    }
    public function marca()
    {
        return $this->belongsTo('App\Almacenes\Marca');
    }
    public function categoria()
    {
        return $this->belongsTo('App\Almacenes\Categoria');
    }
    public function detalles()
    {
        return $this->hasMany('App\Almacenes\ProductoDetalle');
    }
    public function tipoCliente()
    {
        return $this->hasMany('App\Almacenes\TipoCliente', 'producto_id', 'id');
    }
    public function getDescripcionCompleta()
    {
        return $this->codigo . ' - ' . $this->nombre;
    }
    public function tabladetalle()
    {
        return $this->belongsTo('App\Mantenimiento\Tabla\Detalle', 'medida');
    }
    public function getMedida(): string
    {
        $medida = unidad_medida()->where('id', $this->medida)->first();
        if (is_null($medida))
            return "-";
        else
            return $medida->simbolo;
    }
    public function medidaCompleta(): string
    {
        $medida = unidad_medida()->where('id', $this->medida)->first();
        if (is_null($medida))
            return "-";
        else
            return $medida->simbolo . ' - ' . $medida->descripcion;
    }
    public function color()
    {
        return $this->hasOne(Color::class, 'color_id');
    }
    public function modelo()
    {
        return $this->hasOne(Modelo::class, 'modelo_id');
    }
    public function tela()
    {
        return $this->hasOne(Tela::class, 'tela_id');
    }
    public function talla()
    {
        return $this->hasOne(Talla::class, 'talla_id');
    }
    public function submodelo()
    {
        return $this->hasOne(SubModelo::class, 'submodelo_id');
    }
    public function temporada()
    {
        return $this->hasOne(Temporada::class, 'temporada_id');
    }
    public function genero()
    {
        return $this->hasOne(Genero::class, 'genero_id');
    }
}
