<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use App\EjecucionPresupuesto;
use App\ImportEjecPresupuesto;
use App\Imports\DesembolsoSdaImport;
use Illuminate\Http\Request;
use App\Http\Requests\DeleteDesembolsoSdaFormRequest;
use Carbon\Carbon;
use DB;
use Auth;

class ImportDesembolsoSdaController extends Controller
{
    #1. Defino la ruta de la raiz
    private $path ='proceso-pdn.import-desembolso';

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
    public function importForm()
    {
        return view($this->path.'.create');
    }

    #5. 
    public function import(Request $request)
    {
        #1. Realizamos la importación de los datos
        $this->validate($request, [
            'file' => 'required|file|max:1024|mimes:xls,xlsx'
        ]);
        $import = new DesembolsoSdaImport();
        Excel::import($import, request()->file('file'));

        #2. Proceso la data importada
        DB::statement('EXEC procProcesaImportacionDesembolso');


        #3. Retorno a la pagina principal
        return response()->json([
            'estado'    =>  '1',
            'dato'      =>  $import->getRowCount(),
            'mensaje'   =>  'La información se procesó de manera exitosa.'
        ]);
    }

    #6.
    public function show()
    {
        $data   =   EjecucionPresupuesto::getAll();
        return view($this->path.'.data', compact('data'));
    }

    #7. 
    public function destroy($id)
    {
        try 
        {
            $desembolso     =   EjecucionPresupuesto::find($id);
            $desembolso->delete();

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
    
    #8. Muestro un formulario para la eliminación en bloque
    public function formDelete()
    {
        return view($this->path.'.delete');
    }

    #9. Proceso el formulario para el borrado en bloque
    public function procesaDelete(DeleteDesembolsoSdaFormRequest $request)
    {
        try 
        {
            $mes        =   $request->get('mes');
            $periodo    =   $request->get('periodo');
            DB::statement("EXECUTE dbo.uspDeleteImportacionDesembolso @mes = $mes, @periodo = $periodo");

            #3. Retorno al menu principal
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
