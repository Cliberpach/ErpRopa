<?php

namespace App\Http\Controllers\Almacenes;

use App\Almacenes\Genero;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class GeneroController extends Controller
{
    public function index()
    {
        return view('almacenes.generos.index');
    }
    public function getGenero()
    {
        $generos = Genero::where('estado', 'ACTIVO')->orderBy('id', 'DESC')->get();
        $coleccion = collect([]);
        foreach ($generos as $genero) {
            $coleccion->push([
                'id' => $genero->id,
                'nombre' => $genero->nombre,
                'fecha_creacion' =>  Carbon::parse($genero->created_at)->format('d/m/Y'),
                'fecha_actualizacion' =>  Carbon::parse($genero->updated_at)->format('d/m/Y'),
                'estado' => $genero->estado,
            ]);
        }
        return DataTables::of($coleccion)->toJson();
    }
    public function store(Request $request)
    {
        //$this->authorize('haveaccess','color.index');
        $data = $request->all();
        $rules = [
            'genero_guardar' => 'required',
        ];
        $message = [
            'genero_guardar.required' => 'El campo genero es obligatorio.',
        ];
        Validator::make($data, $rules, $message)->validate();
        $genero = new Genero();
        $genero->nombre = $request->get('genero_guardar');
        $genero->save();
        //Registro de actividad
        $descripcion = "SE AGREGÓ EL GENERO CON EL NOMBRE: " . $genero->nombre;
        $gestion = "Genero PT";
        crearRegistro($genero, $descripcion, $gestion);
        Session::flash('success', 'genero creado.');
        return redirect()->route('almacenes.genero.index')->with('guardar', 'success');
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
            'nombre.required' => 'El campo genero es obligatorio.',
        ];
        Validator::make($data, $rules, $message)->validate();
        $genero = Genero::findOrFail($request->get('tabla_id'));
        $genero->nombre = $request->get('nombre');
        $genero->update();

        //Registro de actividad
        $descripcion = "SE MODIFICÓ EL GENERO CON EL NOMBRE: " . $genero->nombre;
        $gestion = "genero PT";
        modificarRegistro($genero, $descripcion, $gestion);

        Session::flash('success', 'genero modificada.');
        return redirect()->route('almacenes.genero.index')->with('modificar', 'success');
    }

    public function destroy($id)
    {
        //$this->authorize('haveaccess','color.index');
        $genero = Genero::findOrFail($id);
        $genero->estado = 'ANULADO';
        $genero->update();

        //Registro de actividad
        $descripcion = "SE ELIMINÓ EL GENERO CON EL NOMBRE: " . $genero->nombre;
        $gestion = "GENERO PT";
        eliminarRegistro($genero, $descripcion, $gestion);

        Session::flash('success', 'genero eliminado.');
        return redirect()->route('almacenes.genero.index')->with('eliminar', 'success');
    }

    public function exist(Request $request)
    {

        $data = $request->all();
        $genero = $data['nombre'];
        $id = $data['id'];
        $genero_existe = null;

        if ($genero && $id) { // edit
            $genero_existe = Genero::where([
                ['nombre', $data['nombre']],
                ['id', '<>', $data['id']]
            ])->where('estado', '!=', 'ANULADO')->first();
        } else if ($genero && !$id) { // create
            $genero_existe = Genero::where('nombre', $data['nombre'])->where('estado', '!=', 'ANULADO')->first();
        }

        $result = ['existe' => ($genero_existe) ? true : false];

        return response()->json($result);
    }
    public function storeApi(Request $request)
    {
        DB::beginTransaction();
        try {
            $genero = new Genero();
            $genero->nombre = $request->nombre;
            $genero->save();
            DB::commit();
            return array("success" => true, "data" => $genero, "response" => "Registro con Exito");
        } catch (Exception $e) {
            DB::rollback();
            Log::info($e);
            return array("success" => false, "data" => null, "response" => $e->getMessage());
        }
    }
}
