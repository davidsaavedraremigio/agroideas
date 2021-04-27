<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use DB;


class Usuario extends Authenticatable
{
    use Notifiable;
    
    protected $table            = 'MaestroUsuario';
    protected $primaryKey       = 'id';
    public $timestamps          =   false; 

   	protected $fillable = [
        'email', 'nroDocumento', 'nombres', 'apellidos'
    ];
    protected $guarded = [];
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    #public      $timestamps =   false;

    #1. Obtengo la relación de usuarios
    public static function getData()
    {
        return DB::select("SELECT * FROM vw_data_usuario");
    }

    #2. Obtengo la relación de usuarios de determinada área
    public static function getArea($area)
    {
        return DB::select("SELECT * FROM vw_data_usuario a WHERE a.codArea = $area");
    }

    #3. Obtengo la relación de usuarios de acuerdo a la oficina elegina
    public static function getDataOficina($oficina)
    {
        return DB::select("SELECT * FROM vw_data_usuario a WHERE a.codOficina = $oficina");
    }

}
