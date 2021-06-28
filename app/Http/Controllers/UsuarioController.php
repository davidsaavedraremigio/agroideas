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
use App\UsuarioRol;
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
        #1. Obtengo las variables solicitadas
        $staff      =   Staff::getData();
        $cargos     =   Cargo::getData();
        $sedes      =   Oficina::getData();
        $roles      =   TablaValor::getDetalleTabla('Rol');
        #2. Retorno al menu principal
        return view($this->path.'.create', compact('staff', 'cargos', 'sedes', 'roles'));
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

                        #6. Guardo la información del rol de usuario
                        try 
                        {
                            $rol                    =   new UsuarioRol;
                            $rol->codMaestroUsuario =   $usuario->id;
                            $rol->codMaestroRol     =   $request->get('rol');
                            $rol->estado            =   1;
                            $rol->created_at        =   Carbon::now();
                            $rol->save();

                            #7. Retorno al menu principal
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
        #1. Obtengo las variables requeridas
        $usuario        =   Usuario::findOrFail($id);
        $staff          =   Staff::getData();
        $cargos         =   Cargo::getData();
        $sedes          =   Oficina::getData();
        $usuarioCargo   =   UsuarioCargo::getCargoUsuario($usuario->id);
        $usuarioStaff   =   UsuarioStaff::getStaffUsuario($usuario->id);
        $usuarioSede    =   UsuarioSede::getSedeUsuario($usuario->id);
        $rol            =   UsuarioRol::getRolUsuario($usuario->id);   

        #3. Retorno a la vista 
        return view($this->path.'.edit', compact('staff', 'cargos', 'sedes', 'usuario', 'usuarioCargo', 'usuarioStaff', 'usuarioSede', 'rol'));
    }

    #8. Actualizamos la información
    public function update(UsuarioFormRequest $request, $id)
    {
        #1. Guardamos la información del usuario
        try 
        {
            $personal               =   Staff::findOrFail($request->get('personal'));
            $usuario                =   Usuario::findOrFail($id);
            $usuario->email         =   $request->get('email');
            $usuario->nroDocumento  =   $personal->nroDni;
            $usuario->nombres       =   $personal->nombres;
            $usuario->apellidos     =   $personal->paterno;
            $usuario->updated_at    =   now();
            $usuario->update();

            #2. Actualizo los datos del cargo directivo
            try 
            {
                $cargo                      =   UsuarioCargo::getCargoUsuario($usuario->id);
                $cargo->codMaestroCargo     =   $request->get('cargo');
                $cargo->updated_at          =   now();
                $cargo->update();

                #3. Actualizo la oficina asignada
                try 
                {
                    $oficina                        =   UsuarioSede::getSedeUsuario($usuario->id);
                    $oficina->codMaestroOficina     =   $request->get('sede');
                    $oficina->updated_at            =   now();
                    $oficina->update();

                    #4. Actualizo el rol asignado
                    try 
                    {
                        $rol                    =   UsuariolRol::getRolUsuario($usuario->id);
                        $rol->codMaestroRol     =   $request->get('rol');
                        $rol->updated_at        =   now();
                        $rol->update();

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
