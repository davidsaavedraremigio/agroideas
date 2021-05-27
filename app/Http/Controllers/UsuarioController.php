<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\UsuarioFormRequest;
use App\Http\Requests\PasswordFormRequest;
use Illuminate\Support\Str;
use App\Usuario;
use App\UsuarioCargo;
use App\UsuarioStaff;
use App\UsuarioSede;
use App\Tabla;
use App\TablaValor;
use App\Staff;
use App\Cargo;
use App\Oficina;
use Carbon\Carbon;
use DB;
use Auth;

class UsuarioController extends Controller
{
    
    #1. Defino la ruta de la raiz
    private $path ='admin.usuario';

    #2. Verificamos que el usuario inicie sesión para poder acceder al módulo 
    public function __construct()
    {
        $this->middleware('auth');
    }

    #3. Muestro la pagina principal
    public function index()
    {
        return view($this->path.'.index');
    }

    #4. Muestro el formulario para registrar usuarios
    public function create()
    {
        #1. Obtengo la relación de personal
        $staff      =   Staff::getData();
        #2. Obtengo los cargos
        $cargos     =   Cargo::getData();
        #3. Obtengo la lista de Oficinas
        $sedes      =   Oficina::getData();
        #4. Retorno al menu principal
        return view($this->path.'.create', compact('staff', 'cargos', 'sedes'));
    }

    #5. Guardamos la información
    public function store(UsuarioFormRequest $request)
    {
        #1. obtengo los datos del personal
        $staff      =   Staff::findOrFail($request->get('personal'));
        
        #2. Guardo la información del usuario
        try 
        {
            $usuario                    =   new Usuario;
            $usuario->email             =   $request->get('email');
            $usuario->password          =   bcrypt($request->get('password'));
            $usuario->nroDocumento      =   $staff->nroDni;
            $usuario->nombres           =   $staff->nombres;
            $usuario->apellidos         =   $staff->paterno;
            $usuario->estado            =   1;
            $usuario->save();

            #3. Guardo la información del Cargo asignado
            try 
            {
                $cargo                      =   new UsuarioCargo;
                $cargo->codMaestroUsuario   =   $usuario->id;
                $cargo->codMaestroCargo     =   $request->get('cargo');
                $cargo->estado              =   1;
                $cargo->save();

                #4. Guardo la información del personal
                try 
                {
                    $personal                       =   new UsuarioStaff;
                    $personal->codMaestroUsuario    =   $usuario->id;
                    $personal->codStaff             =   $request->get('personal');
                    $personal->estado               =   1;
                    $personal->save();

                    #5. Guardo la información de sede asignada
                    try 
                    {
                        $sede                       =   new UsuarioSede;
                        $sede->codMaestroUsuario    =   $usuario->id;
                        $sede->codMaestroOficina    =   $request->get('sede');
                        $sede->estado               =   1;
                        $sede->save();

                        #6. Retorno al menu principal
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
                catch (Exception $e) 
                {
                    return response()->json([
                        'estado'    =>  '2',
                        'dato'      =>  $e->getMessage(),
                        'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
                    ]);
                }
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
        catch (Exception $e) 
        {
            return response()->json([
                'estado'    =>  '2',
                'dato'      =>  $e->getMessage(),
                'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
            ]);
        }
    }

    #6. Mostramos la información registrada
    public function show()
    {
        #1. obtengo los datos
        $data   =   Usuario::getData();
        return view($this->path.'.data', compact('data'));
    }

    #7. Mostramos el formulario para la edición de registros
    public function edit($id)
    {
        #1. 
        $staff      =   Staff::getData();
        $cargos     =   Cargo::getData();
        $sedes      =   Oficina::getData();

        #2. Obtengo la info del usuario
        $usuario        =   Usuario::findOrFail($id);
        $usuarioCargo   =   UsuarioCargo::getCargoUsuario($usuario->id);
        $usuarioStaff   =   UsuarioStaff::getStaffUsuario($usuario->id);
        $usuarioSede    =   UsuarioSede::getSedeUsuario($usuario->id);

        #3. Retorno a la vista 
        return view($this->path.'.edit', compact('staff', 'cargos', 'sedes', 'usuario', 'usuarioCargo', 'usuarioStaff', 'usuarioSede'));
    }

    #8. Actualizamos la información
    public function update(UsuarioFormRequest $request, $id)
    {
        #1. Proceso la información del Cargo
        try 
        {
            $cargoUsuario                   =   UsuarioCargo::getCargoUsuario($id);
            $cargoUsuario->codMaestroCargo  =   $request->get('cargo');
            $cargoUsuario->update();

            #2. Proceso la información del Personal
            try 
            {
                $personal           =   UsuarioStaff::getStaffUsuario($id);
                $personal->codStaff =   $request->get('personal');
                $personal->update();

                #3. Actualizo la información de sedes de usuario
                try 
                {
                    $sede                       =   UsuarioSede::getSedeUsuario($id);
                    $sede->codMaestroOficina    =   $request->get('sede');
                    $sede->update();

                    #4. Actualizo la información del usuario
                    try 
                    {
                        #4.1. Obtengo los datos del personal
                        $staff                      =   Staff::findOrFail($request->get('personal'));
                        #4.2. Actualizo la información del usuario
                        $usuario                    =   Usuario::findOrFail($id);
                        $usuario->email             =   $request->get('email');
                        $usuario->nroDocumento      =   $staff->nroDni;
                        $usuario->nombres           =   $staff->nombres;
                        $usuario->apellidos         =   $staff->paterno;
                        $usuario->update();

                        #5. Retorno al menu principal
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
                catch (Exception $e) 
                {
                    return response()->json([
                        'estado'    =>  '2',
                        'dato'      =>  $e->getMessage(),
                        'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
                    ]);
                }
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
        catch (Exception $e) 
        {
            return response()->json([
                'estado'    =>  '2',
                'dato'      =>  $e->getMessage(),
                'mensaje'   =>  'Error de Servidor. Contacte a Soporte TI.'
            ]);
        }
        
    }

    #9. Doy de baja a un usuario
    public function destroy($id)
    {
        try 
        {
            $usuario            =   Usuario::findOrFail($id);
            $usuario->estado    =   0;
            $usuario->update();

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

    #10. Realizo el cambio de contraseña
    public function editPassword($id)
    {
        #1. Obtengo los datos del Usuario
        $usuario    =   Usuario::findOrFail($id);
        #2. Genero una contraseña aleatoria
        $clave      =   Str::random(8);
        #3. Retorno al formulario de registro
        return view($this->path.'.reset', compact('usuario', 'clave'));
    }

    #11. Proceso el cambio de contraseña
    public function updatePassword(PasswordFormRequest $request, $id)
    {
        try 
        {
            $usuario            =   Usuario::findOrFail($id);
            $usuario->password  =   bcrypt($request->get('password'));
            $usuario->update();

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

    #12. Obtengo la relación de usuarios de acuerdo a la oficina elegida
    public function showUsuarioOficina($id)
    {
        $data  =   Usuario::getDataOficina($id);
        return response()->json($data);
    }
}
