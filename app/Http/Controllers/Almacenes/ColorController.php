<?php
namespace App\Http\Controllers\Almacenes;
use App\Color;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
class ColorController extends Controller
{
    public function index()
    {
        return view('almacenes.colores.index');
    }
    public function getColor()
    {
        $colores = Color::where('estado', 'ACTIVO')->orderBy('id', 'DESC')->get();
        $coleccion = collect([]);
        foreach ($colores as $color) {
            $coleccion->push([
                'id' => $color->id,
                'nombre' => $color->nombre,
                'fecha_creacion' =>  Carbon::parse($color->created_at)->format('d/m/Y'),
                'fecha_actualizacion' =>  Carbon::parse($color->updated_at)->format('d/m/Y'),
                'estado' => $color->estado,
            ]);
        }
        return DataTables::of($coleccion)->toJson();
    }
    public function store(Request $request)
    {
        //$this->authorize('haveaccess','color.index');
        $data = $request->all();
        $rules = [
            'color_guardar' => 'required',
        ];
        $message = [
            'color_guardar.required' => 'El campo color es obligatorio.',
        ];
        Validator::make($data, $rules, $message)->validate();
        $color = new Color();
        $color->nombre = $request->get('color_guardar');
        $color->save();
        //Registro de actividad
        $descripcion = "SE AGREGÓ EL COLOR CON EL NOMBRE: " . $color->nombre;
        $gestion = "color PT";
        crearRegistro($color, $descripcion, $gestion);
        Session::flash('success', 'color creado.');
        return redirect()->route('almacenes.color.index')->with('guardar', 'success');
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
            'nombre.required' => 'El campo color es obligatorio.',
        ];
        Validator::make($data, $rules, $message)->validate();
        $color = Color::findOrFail($request->get('tabla_id'));
        $color->nombre = $request->get('nombre');
        $color->update();
        //Registro de actividad
        $descripcion = "SE MODIFICÓ LA color CON EL NOMBRE: " . $color->nombre;
        $gestion = "color PT";
        modificarRegistro($color, $descripcion, $gestion);
        Session::flash('success', 'color modificada.');
        return redirect()->route('almacenes.color.index')->with('modificar', 'success');
    }
    public function destroy($id)
    {
        //$this->authorize('haveaccess','color.index');
        $color = Color::findOrFail($id);
        $color->estado = 'ANULADO';
        $color->update();
        //Registro de actividad
        $descripcion = "SE ELIMINÓ EL COLOR CON EL NOMBRE: " . $color->nombre;
        $gestion = "COLOR PT";
        eliminarRegistro($color, $descripcion, $gestion);
        Session::flash('success', 'color eliminada.');
        return redirect()->route('almacenes.color.index')->with('eliminar', 'success');
    }
    public function exist(Request $request)
    {
        $data = $request->all();
        $color = $data['nombre'];
        $id = $data['id'];
        $color_existe = null;
        if ($color && $id) { // edit
            $color_existe = Color::where([
                ['nombre', $data['nombre']],
                ['id', '<>', $data['id']]
            ])->where('estado', '!=', 'ANULADO')->first();
        } else if ($color && !$id) { // create
            $color_existe = Color::where('nombre', $data['nombre'])->where('estado', '!=', 'ANULADO')->first();
        }
        $result = ['existe' => ($color_existe) ? true : false];
        return response()->json($result);
    }
    public function storeApi(Request $request)
    {
        DB::beginTransaction();
        try {
            $color = new Color();
            $color->nombre = $request->nombre;
            $color->save();
            DB::commit();
            return array("success" => true, "data" => $color, "response" => "Registro con Exito");
        } catch (Exception $e) {
            DB::rollback();
            Log::info($e);
            return array("success" => false, "data" => null, "response" => $e->getMessage());
        }
    }

    public function getListSelect(Request $request)
    {
        $sBuscar = $request->get('search');
        $results = DB::table('color');
        if ($sBuscar) {
            $results = $results->where('color.nombre', 'like', '%' . $sBuscar . '%');
        }
        $results = $results->select('color.id', 'color.nombre as text')->where('color.estado', 'ACTIVO')->paginate(10);
        return response()->json($results);
    }
}
