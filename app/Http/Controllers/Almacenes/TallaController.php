<?php

namespace App\Http\Controllers\Almacenes;

use App\Almacenes\Talla;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class TallaController extends Controller
{
    public function index()
    {
        return view('almacenes.tallas.index');
    }
    public function getTalla()
    {
        $tallas = Talla::where('estado', 'ACTIVO')->orderBy('id', 'DESC')->get();
        $coleccion = collect([]);
        foreach ($tallas as $talla) {
            $coleccion->push([
                'id' => $talla->id,
                'nombre' => $talla->nombre,
                'fecha_creacion' =>  Carbon::parse($talla->created_at)->format('d/m/Y'),
                'fecha_actualizacion' =>  Carbon::parse($talla->updated_at)->format('d/m/Y'),
                'estado' => $talla->estado,
            ]);
        }
        return DataTables::of($coleccion)->toJson();
    }
    public function store(Request $request)
    {
        //$this->authorize('haveaccess','color.index');
        $data = $request->all();
        $rules = [
            'talla_guardar' => 'required',
        ];
        $message = [
            'talla_guardar.required' => 'El campo talla es obligatorio.',
        ];
        Validator::make($data, $rules, $message)->validate();
        $talla = new Talla();
        $talla->nombre = $request->get('talla_guardar');
        $talla->save();
        //Registro de actividad
        $descripcion = "SE AGREGÓ LA TALLA CON EL NOMBRE: " . $talla->nombre;
        $gestion = "Talla PT";
        crearRegistro($talla, $descripcion, $gestion);
        Session::flash('success', 'talla creada.');
        return redirect()->route('almacenes.talla.index')->with('guardar', 'success');
    }

    public function update(Request $request)
    {
        //$this->authorize('haveaccess','color.index');
        $data = $request->all();
        $rules = [
            'tabla_id' => 'required',
            'nombre' => 'required',
        ];
        $message = [
            'nombre.required' => 'El campo talla es obligatorio.',
        ];
        Validator::make($data, $rules, $message)->validate();
        $talla = Talla::findOrFail($request->get('tabla_id'));
        $talla->nombre = $request->get('nombre');
        $talla->update();

        //Registro de actividad
        $descripcion = "SE MODIFICÓ LA talla CON EL NOMBRE: " . $talla->nombre;
        $gestion = "talla PT";
        modificarRegistro($talla, $descripcion, $gestion);

        Session::flash('success', 'talla modificada.');
        return redirect()->route('almacenes.talla.index')->with('modificar', 'success');
    }

    public function destroy($id)
    {
        //$this->authorize('haveaccess','color.index');
        $talla = Talla::findOrFail($id);
        $talla->estado = 'ANULADO';
        $talla->update();

        //Registro de actividad
        $descripcion = "SE ELIMINÓ LA TALLA CON EL NOMBRE: " . $talla->nombre;
        $gestion = "LA TALLA PT";
        eliminarRegistro($talla, $descripcion, $gestion);

        Session::flash('success', 'talla eliminada.');
        return redirect()->route('almacenes.talla.index')->with('eliminar', 'success');
    }

    public function exist(Request $request)
    {

        $data = $request->all();
        $talla = $data['nombre'];
        $id = $data['id'];
        $color_existe = null;

        if ($talla && $id) { // edit
            $color_existe = Talla::where([
                ['nombre', $data['nombre']],
                ['id', '<>', $data['id']]
            ])->where('estado', '!=', 'ANULADO')->first();
        } else if ($talla && !$id) { // create
            $color_existe = Talla::where('nombre', $data['nombre'])->where('estado', '!=', 'ANULADO')->first();
        }

        $result = ['existe' => ($color_existe) ? true : false];

        return response()->json($result);
    }
}
