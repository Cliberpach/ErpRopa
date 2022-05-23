<?php

namespace App\Http\Controllers\Almacenes;

use App\Almacenes\Tela;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class TelaController extends Controller
{
    public function index()
    {
        return view('almacenes.telas.index');
    }
    public function getTela()
    {
        $telas = Tela::where('estado', 'ACTIVO')->orderBy('id', 'DESC')->get();
        $coleccion = collect([]);
        foreach ($telas as $tela) {
            $coleccion->push([
                'id' => $tela->id,
                'nombre' => $tela->nombre,
                'fecha_creacion' =>  Carbon::parse($tela->created_at)->format('d/m/Y'),
                'fecha_actualizacion' =>  Carbon::parse($tela->updated_at)->format('d/m/Y'),
                'estado' => $tela->estado,
            ]);
        }
        return DataTables::of($coleccion)->toJson();
    }
    public function store(Request $request)
    {
        //$this->authorize('haveaccess','color.index');
        $data = $request->all();
        $rules = [
            'tela_guardar' => 'required',
        ];
        $message = [
            'tela_guardar.required' => 'El campo tela es obligatorio.',
        ];
        Validator::make($data, $rules, $message)->validate();
        $tela = new Tela();
        $tela->nombre = $request->get('tela_guardar');
        $tela->save();
        //Registro de actividad
        $descripcion = "SE AGREGÓ LA TELA CON EL NOMBRE: " . $tela->nombre;
        $gestion = "Tela PT";
        crearRegistro($tela, $descripcion, $gestion);
        Session::flash('success', 'tela creada.');
        return redirect()->route('almacenes.tela.index')->with('guardar', 'success');
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
            'nombre.required' => 'El campo tela es obligatorio.',
        ];
        Validator::make($data, $rules, $message)->validate();
        $tela = Tela::findOrFail($request->get('tabla_id'));
        $tela->nombre = $request->get('nombre');
        $tela->update();

        //Registro de actividad
        $descripcion = "SE MODIFICÓ LA tela CON EL NOMBRE: " . $tela->nombre;
        $gestion = "tela PT";
        modificarRegistro($tela, $descripcion, $gestion);

        Session::flash('success', 'tela modificada.');
        return redirect()->route('almacenes.tela.index')->with('modificar', 'success');
    }

    public function destroy($id)
    {
        //$this->authorize('haveaccess','color.index');
        $tela = Tela::findOrFail($id);
        $tela->estado = 'ANULADO';
        $tela->update();

        //Registro de actividad
        $descripcion = "SE ELIMINÓ LA TELA CON EL NOMBRE: " . $tela->nombre;
        $gestion = "LA TELA PT";
        eliminarRegistro($tela, $descripcion, $gestion);

        Session::flash('success', 'tela eliminada.');
        return redirect()->route('almacenes.tela.index')->with('eliminar', 'success');
    }

    public function exist(Request $request)
    {

        $data = $request->all();
        $tela = $data['nombre'];
        $id = $data['id'];
        $tela_existe = null;

        if ($tela && $id) { // edit
            $tela_existe = Tela::where([
                ['nombre', $data['nombre']],
                ['id', '<>', $data['id']]
            ])->where('estado', '!=', 'ANULADO')->first();
        } else if ($tela && !$id) { // create
            $tela_existe = Tela::where('nombre', $data['nombre'])->where('estado', '!=', 'ANULADO')->first();
        }

        $result = ['existe' => ($tela_existe) ? true : false];

        return response()->json($result);
    }
    public function storeApi(Request $request)
    {
        DB::beginTransaction();
        try {
            $tela = new Tela();
            $tela->nombre = $request->nombre;
            $tela->save();
            DB::commit();
            return array("success" => true, "data" => $tela, "response" => "Registro con Exito");
        } catch (Exception $e) {
            DB::rollback();
            Log::info($e);
            return array("success" => false, "data" => null, "response" => $e->getMessage());
        }
    }

    public function getListSelect(Request $request)
    {
        $sBuscar = $request->get('search');
        $results = DB::table('tela');
        if ($sBuscar) {
            $results = $results->where('tela.nombre', 'like', '%' . $sBuscar . '%');
        }
        $results = $results->select('tela.id', 'tela.nombre as text')->where('tela.estado', 'ACTIVO')->paginate(10);
        return response()->json($results);
    }
}
