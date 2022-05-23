<?php

namespace App\Http\Controllers\Almacenes;

use App\Almacenes\SubModelo;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class SubModeloController extends Controller
{
    public function index()
    {
        return view('almacenes.submodelos.index');
    }
    public function getSubModelo()
    {
        $submodelos = SubModelo::where('estado', 'ACTIVO')->orderBy('id', 'DESC')->get();
        $coleccion = collect([]);
        foreach ($submodelos as $submodelo) {
            $coleccion->push([
                'id' => $submodelo->id,
                'nombre' => $submodelo->nombre,
                'fecha_creacion' =>  Carbon::parse($submodelo->created_at)->format('d/m/Y'),
                'fecha_actualizacion' =>  Carbon::parse($submodelo->updated_at)->format('d/m/Y'),
                'estado' => $submodelo->estado,
            ]);
        }
        return DataTables::of($coleccion)->toJson();
    }
    public function store(Request $request)
    {
        //$this->authorize('haveaccess','color.index');
        $data = $request->all();
        $rules = [
            'submodelo_guardar' => 'required',
        ];
        $message = [
            'submodelo_guardar.required' => 'El campo submodelo es obligatorio.',
        ];
        Validator::make($data, $rules, $message)->validate();
        $submodelo = new SubModelo();
        $submodelo->nombre = $request->get('submodelo_guardar');
        $submodelo->save();
        //Registro de actividad
        $descripcion = "SE AGREGÓ EL SUBMODELO CON EL NOMBRE: " . $submodelo->nombre;
        $gestion = "SubModelo PT";
        crearRegistro($submodelo, $descripcion, $gestion);
        Session::flash('success', 'submodelo creado.');
        return redirect()->route('almacenes.submodelo.index')->with('guardar', 'success');
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
            'nombre.required' => 'El campo submodelo es obligatorio.',
        ];
        Validator::make($data, $rules, $message)->validate();
        $submodelo = SubModelo::findOrFail($request->get('tabla_id'));
        $submodelo->nombre = $request->get('nombre');
        $submodelo->update();

        //Registro de actividad
        $descripcion = "SE MODIFICÓ EL SUBMODELO CON EL NOMBRE: " . $submodelo->nombre;
        $gestion = "submodelo PT";
        modificarRegistro($submodelo, $descripcion, $gestion);

        Session::flash('success', 'submodelo modificada.');
        return redirect()->route('almacenes.submodelo.index')->with('modificar', 'success');
    }

    public function destroy($id)
    {
        //$this->authorize('haveaccess','color.index');
        $submodelo = SubModelo::findOrFail($id);
        $submodelo->estado = 'ANULADO';
        $submodelo->update();

        //Registro de actividad
        $descripcion = "SE ELIMINÓ EL SUBMODELO CON EL NOMBRE: " . $submodelo->nombre;
        $gestion = "SUBMODELO PT";
        eliminarRegistro($submodelo, $descripcion, $gestion);

        Session::flash('success', 'submodelo eliminada.');
        return redirect()->route('almacenes.submodelo.index')->with('eliminar', 'success');
    }

    public function exist(Request $request)
    {

        $data = $request->all();
        $submodelo = $data['nombre'];
        $id = $data['id'];
        $modelo_existe = null;

        if ($submodelo && $id) { // edit
            $modelo_existe = SubModelo::where([
                ['nombre', $data['nombre']],
                ['id', '<>', $data['id']]
            ])->where('estado', '!=', 'ANULADO')->first();
        } else if ($submodelo && !$id) { // create
            $modelo_existe = SubModelo::where('nombre', $data['nombre'])->where('estado', '!=', 'ANULADO')->first();
        }

        $result = ['existe' => ($modelo_existe) ? true : false];

        return response()->json($result);
    }
    public function storeApi(Request $request)
    {
        DB::beginTransaction();
        try {
            $submodelo = new SubModelo();
            $submodelo->nombre = $request->nombre;
            $submodelo->save();
            DB::commit();
            return array("success" => true, "data" => $submodelo, "response" => "Registro con Exito");
        } catch (Exception $e) {
            DB::rollback();
            Log::info($e);
            return array("success" => false, "data" => null, "response" => $e->getMessage());
        }
    }

    public function getListSelect(Request $request)
    {
        $sBuscar = $request->get('search');
        $results = DB::table('sub_modelo');
        if ($sBuscar) {
            $results = $results->where('sub_modelo.nombre', 'like', '%' . $sBuscar . '%');
        }
        $results = $results->select('sub_modelo.id', 'sub_modelo.nombre as text')->where('sub_modelo.estado', 'ACTIVO')->paginate(10);
        return response()->json($results);
    }
}
