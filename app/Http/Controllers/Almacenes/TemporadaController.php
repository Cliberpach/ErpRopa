<?php

namespace App\Http\Controllers\Almacenes;

use App\Almacenes\Temporada;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;


class TemporadaController extends Controller
{
    public function index()
    {
        return view('almacenes.temporadas.index');
    }
    public function getTemporada()
    {
        $temporadas = Temporada::where('estado', 'ACTIVO')->orderBy('id', 'DESC')->get();
        $coleccion = collect([]);
        foreach ($temporadas as $temporada) {
            $coleccion->push([
                'id' => $temporada->id,
                'nombre' => $temporada->nombre,
                'fecha_creacion' =>  Carbon::parse($temporada->created_at)->format('d/m/Y'),
                'fecha_actualizacion' =>  Carbon::parse($temporada->updated_at)->format('d/m/Y'),
                'estado' => $temporada->estado,
            ]);
        }
        return DataTables::of($coleccion)->toJson();
    }
    public function store(Request $request)
    {
        //$this->authorize('haveaccess','color.index');
        $data = $request->all();
        $rules = [
            'temporada_guardar' => 'required',
        ];
        $message = [
            'temporada_guardar.required' => 'El campo temporada es obligatorio.',
        ];
        Validator::make($data, $rules, $message)->validate();
        $temporada = new Temporada();
        $temporada->nombre = $request->get('temporada_guardar');
        $temporada->save();
        //Registro de actividad
        $descripcion = "SE AGREGÓ TEMPORADA CON EL NOMBRE: " . $temporada->nombre;
        $gestion = "Temporada PT";
        crearRegistro($temporada, $descripcion, $gestion);
        Session::flash('success', 'temporada creado.');
        return redirect()->route('almacenes.temporada.index')->with('guardar', 'success');
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
            'nombre.required' => 'El campo temporada es obligatorio.',
        ];
        Validator::make($data, $rules, $message)->validate();
        $temporada = Temporada::findOrFail($request->get('tabla_id'));
        $temporada->nombre = $request->get('nombre');
        $temporada->update();

        //Registro de actividad
        $descripcion = "SE MODIFICÓ LA TEMPORADA CON EL NOMBRE: " . $temporada->nombre;
        $gestion = "temporada PT";
        modificarRegistro($temporada, $descripcion, $gestion);

        Session::flash('success', 'temporada modificada.');
        return redirect()->route('almacenes.temporada.index')->with('modificar', 'success');
    }

    public function destroy($id)
    {
        //$this->authorize('haveaccess','color.index');
        $temporada = Temporada::findOrFail($id);
        $temporada->estado = 'ANULADO';
        $temporada->update();

        //Registro de actividad
        $descripcion = "SE ELIMINÓ TEMPORADA CON EL NOMBRE: " . $temporada->nombre;
        $gestion = "TEMPORADA PT";
        eliminarRegistro($temporada, $descripcion, $gestion);

        Session::flash('success', 'temporada eliminada.');
        return redirect()->route('almacenes.temporada.index')->with('eliminar', 'success');
    }

    public function exist(Request $request)
    {

        $data = $request->all();
        $temporada = $data['nombre'];
        $id = $data['id'];
        $temporada_existe = null;

        if ($temporada && $id) { // edit
            $temporada_existe = Temporada::where([
                ['nombre', $data['nombre']],
                ['id', '<>', $data['id']]
            ])->where('estado', '!=', 'ANULADO')->first();
        } else if ($temporada && !$id) { // create
            $temporada_existe = Temporada::where('nombre', $data['nombre'])->where('estado', '!=', 'ANULADO')->first();
        }

        $result = ['existe' => ($temporada_existe) ? true : false];

        return response()->json($result);
    }
    public function storeApi(Request $request)
    {
        DB::beginTransaction();
        try {
            $temporada = new Temporada();
            $temporada->nombre = $request->nombre;
            $temporada->save();
            DB::commit();
            return array("success" => true, "data" => $temporada, "response" => "Registro con Exito");
        } catch (Exception $e) {
            DB::rollback();
            Log::info($e);
            return array("success" => false, "data" => null, "response" => $e->getMessage());
        }
    }

    public function getListSelect(Request $request)
    {
        $sBuscar = $request->get('search');
        $results = DB::table('temporada');
        if ($sBuscar) {
            $results = $results->where('temporada.nombre', 'like', '%' . $sBuscar . '%');
        }
        $results = $results->select('temporada.id', 'temporada.nombre as text')->where('temporada.estado', 'ACTIVO')->paginate(10);
        return response()->json($results);
    }
}
