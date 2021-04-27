<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class Menu extends Model
{
    protected 	$table 			=	'MaestroMenu';
    public $timestamps          =   false; 
    
    public function getChildren($data, $line)
    {
        $children = [];
        foreach ($data as $line1) 
        {
            if ($line['id'] == $line1['parent']) {
                $children = array_merge($children, [ array_merge($line1, ['submenu' => $this->getChildren($data, $line1) ]) ]);
            }
        }
        return $children;
    }

    public function optionsMenu()
    {
        return $this->where('estado', 1)
            ->orderby('parent')
            ->orderby('orden')
            ->orderby('nombre')
            ->get()
            ->toArray();
    }

    public static function menus()
    {
        $menus = new Menu();
        $data = $menus->optionsMenu();
        $menuAll = [];
        foreach ($data as $line) {
            $item = [ array_merge($line, ['submenu' => $menus->getChildren($data, $line) ]) ];
            $menuAll = array_merge($menuAll, $item);
        }
        return $menus->menuAll = $menuAll;
    }

    #4. Obtengo la relación de módulos registrados
    public static function getModulos()
    {
        $modulos    =   Menu::where('parent', 0)
                        ->orderBy('orden', 'asc')
                        ->get();
        return $modulos;
    }

    #5. Obtengo la relación de procesos registrados
    public static function getProcesos()
    {
        return DB::select('SELECT
            a.id,
            a.orden,
            a.nombre,
            a.descripcion,
            a.ruta,
            a.icono,
            b.nombre modulo,
            a.estado
        FROM MaestroMenu a
        LEFT JOIN (
            SELECT * FROM MaestroMenu a WHERE a.parent = 0 
        ) b ON b.id = a.parent
        WHERE a.parent <> 0
        ORDER BY b.orden ASC, a.orden ASC');
    }

    #6. Obtengo la relación de datos del Menu por area
    public function optionsMenuArea($area)
    {
        return DB::table('vw_data_menu_area')
            ->where('vw_data_menu_area.codArea',$area)
            ->orderBy('vw_data_menu_area.parent','ASC')
            ->orderBy('vw_data_menu_area.orden','ASC')
            ->orderBy('vw_data_menu_area.nombre','ASC')
            ->get()
            ->toArray();
    }

    #7. Obtengo el menu de acuerdo al codigo de área seleccionado
    public static function menuArea($area)
    {
        $menus      = new Menu();
        $data       = $menus->optionsMenuArea($area);
        $menuAll    = [];
        foreach ($data as $line) 
        {
            $item       = [ array_merge($line, ['submenu' => $menus->getChildren($data, $line) ]) ];
            $menuAll    = array_merge($menuAll, $item);
        }
        return $menus->menuAll = $menuAll;
    }

}
