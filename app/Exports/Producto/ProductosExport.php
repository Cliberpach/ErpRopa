<?php

namespace App\Exports\Producto;

use App\Almacenes\Almacen;
use App\Almacenes\Categoria;
use App\Almacenes\Marca;
use App\Almacenes\Producto;
use App\Mantenimiento\Tabla\Detalle;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;


class ProductosExport implements FromCollection, WithHeadings, WithEvents
{

    use Exportable;
    public $categoria_id, $marca_id, $color_id, $modelo_id, $tela_di, $talla_id, $sub_modelo_id, $temporada_id, $genero_id;

    function title(): String
    {
        return "Productos";
    }

    public function __construct($categoria_id, $marca_id, $color_id, $modelo_id, $tela_id, $talla_id, $sub_modelo_id, $temporada_id, $genero_id)
    {
        $this->categoria_id = $categoria_id;
        $this->marca_id = $marca_id;
        $this->color_id = $color_id;
        $this->modelo_id = $modelo_id;
        $this->tela_id = $tela_id;
        $this->talla_id = $talla_id;
        $this->sub_modelo_id = $sub_modelo_id;
        $this->temporada_id = $temporada_id;
        $this->genero_id = $genero_id;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $consulta = DB::table('productos')
        ->join('categorias', 'categorias.id', '=', 'productos.categoria_id')
        ->join('marcas', 'productos.marca_id', '=', 'marcas.id')
        ->join('almacenes', 'almacenes.id', '=', 'productos.almacen_id')
        ->join('color', 'color.id', '=', 'productos.color_id')
        ->join('modelo', 'modelo.id', '=', 'productos.modelo_id')
        ->join('tela', 'tela.id', '=', 'productos.tela_id')
        ->join('talla', 'talla.id', '=', 'productos.talla_id')
        ->join('sub_modelo', 'sub_modelo.id', '=', 'productos.sub_modelo_id')
        ->join('temporada', 'temporada.id', '=', 'productos.temporada_id')
        ->join('genero', 'genero.id', '=', 'productos.genero_id')
        ->select('productos.codigo', 'productos.nombre', 'categorias.descripcion as categoria','marcas.marca', 'color.nombre as color','modelo.nombre as modelo', 'tela.nombre as tela', 'talla.nombre as talla','sub_modelo.nombre as submodelo', 'temporada.nombre as temporada', 'genero.nombre as genero', 'productos.codigo_barra', 'productos.stock')
        ->orderBy('productos.id', 'DESC')
        ->where('productos.estado', 'ACTIVO');

        if ($this->categoria_id) {
            $consulta = $consulta->where('productos.categoria_id', $this->categoria_id);
        }

        if ($this->marca_id) {
            $consulta = $consulta->where('productos.marca_id', $this->marca_id);
        }

        if ($this->color_id) {
            $consulta = $consulta->where('productos.color_id', $this->color_id);
        }

        if ($this->modelo_id) {
            $consulta = $consulta->where('productos.modelo_id', $this->modelo_id);
        }

        if ($this->tela_id) {
            $consulta = $consulta->where('productos.tela_id', $this->tela_id);
        }

        if ($this->talla_id) {
            $consulta = $consulta->where('productos.talla_id', $this->talla_id);
        }

        if ($this->sub_modelo_id) {
            $consulta = $consulta->where('productos.sub_modelo_id', $this->sub_modelo_id);
        }

        if ($this->temporada_id) {
            $consulta = $consulta->where('productos.temporada_id', $this->temporada_id);
        }

        if ($this->genero_id) {
            $consulta = $consulta->where('productos.genero_id', $this->genero_id);
        }

        return $consulta->get();
    }

    public function headings(): array
    {
        return [
            [ 
                'codigo',
                'nombre',
                'categoria',
                'marca',
                'color',
                'modelo',
                'tela',
                'talla',
                'submodelo',
                'temporada',
                'genero',
                'codigo_barra',
                'stock',
            ]
        ]
       ;
    }

    public function registerEvents(): array
    {
        return [

            BeforeWriting::class => [self::class, 'beforeWriting'],
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->getStyle('A1:H1')->applyFromArray([


                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                        'rotation' => 90,
                        'startColor' => [
                            'argb' => '1ab394',
                        ],
                        'endColor' => [
                            'argb' => '1ab394',
                        ],
                    ],


                ]

                );

               // $event->sheet->getColumnDimension('C')->setWidth(20);

            },
        ];
    }
}
