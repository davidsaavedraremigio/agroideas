<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\StaffFormRequest;
use App\Staff;
use Carbon\Carbon;
use DB;
use Auth;

class StaffController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='admin.staff';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }

    #3. 
    public function index()
    {
        return view($this->path.'.index');
    }

    #4.
    public function create()
    {
        return view($this->path.'.create');
    }

    #5. 
    public function store(StaffFormRequest $request)
    {
        try 
        {
            $staff                  =   new Staff;
            $staff->nroDni          =   $request->get('dni');
            $staff->nroRuc          =   $request->get('ruc');
            $staff->nombres         =   $request->get('nombres');
            $staff->paterno         =   $request->get('paterno');
            $staff->materno         =   $request->get('materno');
            $staff->fechaNacimiento =   $request->get('fecha');
            $staff->nroPoliza       =   $request->get('poliza');
            $staff->direccion       =   $request->get('direccion');
            $staff->nroTelefono     =   $request->get('telefono');
            $staff->estado          =   1;
            $staff->save();

            return response()->json([
                'estado'    =>  '1',
                'dato'      =>  '',
                'mensaje'   =>  'La información se procesó de manera exitosa.'
            ]);
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'estado'    =>  '2',
                'dato'      =>  $e->getMessage(),
                'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
            ]);
        }
    }

    #6.
    public function show()
    {
        $data   =   Staff::getData();
        return view($this->path.'.data', compact('data'));
    }

    #7. 
    public function edit($id)
    {
        $staff  =   Staff::findOrFail($id);
        return view($this->path.'.edit', compact('staff'));
    }

    #8.
    public function update(StaffFormRequest $request, $id)
    {
        try 
        {
            $staff                  =   Staff::findOrFail($id);
            $staff->nroDni          =   $request->get('dni');
            $staff->nroRuc          =   $request->get('ruc');
            $staff->nombres         =   $request->get('nombres');
            $staff->paterno         =   $request->get('paterno');
            $staff->materno         =   $request->get('materno');
            $staff->fechaNacimiento =   $request->get('fecha');
            $staff->nroPoliza       =   $request->get('poliza');
            $staff->direccion       =   $request->get('direccion');
            $staff->nroTelefono     =   $request->get('telefono');
            $staff->update();

            return response()->json([
                'estado'    =>  '1',
                'dato'      =>  '',
                'mensaje'   =>  'La información se procesó de manera exitosa.'
            ]);
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'estado'    =>  '2',
                'dato'      =>  $e->getMessage(),
                'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
            ]);
        }
    }

    #9.
    public function destroy($id)
    {
        try 
        {
            $staff          =   Staff::findOrFail($id);
            $staff->estado  =   0;
            $staff->update();

            return response()->json([
                'estado'    =>  '1',
                'dato'      =>  '',
                'mensaje'   =>  'La información se procesó de manera exitosa.'
            ]);
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'estado'    =>  '2',
                'dato'      =>  $e->getMessage(),
                'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
            ]);
        }
    }
}
