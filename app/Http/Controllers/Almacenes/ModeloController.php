<?php

namespace App\Http\Controllers\Almacenes;

use App\Almacenes\Modelo;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class ModeloController extends Controller
{
    public function index()
    {
        return view('almacenes.modelos.index');
    }

    public function getModelo()
    {
        $modelos = Modelo::where('estado', 'ACTIVO')->orderBy('id', 'DESC')->get();
        $coleccion = collect([]);
        foreach ($modelos as $modelo) {
            $coleccion->push([
                'id' => $modelo->id,
                'nombre' => $modelo->nombre,
                'fecha_creacion' =>  Carbon::parse($modelo->created_at)->format('d/m/Y'),
                'fecha_actualizacion' =>  Carbon::parse($modelo->updated_at)->format('d/m/Y'),
                'estado' => $modelo->estado,
            ]);
        }
        return DataTables::of($coleccion)->toJson();
    }

    public function store(Request $request)
    {
        //$this->authorize('haveaccess','color.index');
        $data = $request->all();
        $rules = [
            'modelo_guardar' => 'required',
        ];
        $message = [
            'modelo_guardar.required' => 'El campo modelo es obligatorio.',
        ];
        Validator::make($data, $rules, $message)->validate();
        $modelo = new Modelo();
        $modelo->nombre = $request->get('modelo_guardar');
        $modelo->save();
        //Registro de actividad
        $descripcion = "SE AGREGÓ EL MODELO CON EL NOMBRE: " . $modelo->nombre;
        $gestion = "Modelo PT";
        crearRegistro($modelo, $descripcion, $gestion);
        Session::flash('success', 'modelo creado.');
        return redirect()->route('almacenes.modelo.index')->with('guardar', 'success');
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
            'nombre.required' => 'El campo modelo es obligatorio.',
        ];
        Validator::make($data, $rules, $message)->validate();
        $modelo = Modelo::findOrFail($request->get('tabla_id'));
        $modelo->nombre = $request->get('nombre');
        $modelo->update();

        //Registro de actividad
        $descripcion = "SE MODIFICÓ EL MODELO CON EL NOMBRE: " . $modelo->nombre;
        $gestion = "modelo PT";
        modificarRegistro($modelo, $descripcion, $gestion);

        Session::flash('success', 'modelo modificada.');
        return redirect()->route('almacenes.modelo.index')->with('modificar', 'success');
    }

    public function destroy($id)
    {
        //$this->authorize('haveaccess','color.index');
        $modelo = Modelo::findOrFail($id);
        $modelo->estado = 'ANULADO';
        $modelo->update();

        //Registro de actividad
        $descripcion = "SE ELIMINÓ EL MODELO CON EL NOMBRE: " . $modelo->nombre;
        $gestion = "MODELO PT";
        eliminarRegistro($modelo, $descripcion, $gestion);

        Session::flash('success', 'modelo eliminada.');
        return redirect()->route('almacenes.modelo.index')->with('eliminar', 'success');
    }

    public function exist(Request $request)
    {

        $data = $request->all();
        $modelo = $data['nombre'];
        $id = $data['id'];
        $modelo_existe = null;

        if ($modelo && $id) { // edit
            $modelo_existe = Modelo::where([
                ['nombre', $data['nombre']],
                ['id', '<>', $data['id']]
            ])->where('estado', '!=', 'ANULADO')->first();
        } else if ($modelo && !$id) { // create
            $modelo_existe = Modelo::where('nombre', $data['nombre'])->where('estado', '!=', 'ANULADO')->first();
        }

        $result = ['existe' => ($modelo_existe) ? true : false];

        return response()->json($result);
    }
    
    public function storeApi(Request $request)
    {
        DB::beginTransaction();
        try {
            $modelo = new Modelo();
            $modelo->nombre = $request->nombre;
            $modelo->save();
            DB::commit();
            return array("success" => true, "data" => $modelo, "response" => "Registro con Exito");
        } catch (Exception $e) {
            DB::rollback();
            Log::info($e);
            return array("success" => false, "data" => null, "response" => $e->getMessage());
        }
    }

    public function getListSelect(Request $request)
    {
        $sBuscar = $request->get('search');
        $results = DB::table('modelo');
        if($sBuscar) {
            $results = $results->where('modelo.nombre', 'like','%'.$sBuscar.'%');
        }
        $results = $results->select('modelo.id', 'modelo.nombre as text')->where('modelo.estado', 'ACTIVO')->paginate(10);
        return response()->json($results);
    }
}
