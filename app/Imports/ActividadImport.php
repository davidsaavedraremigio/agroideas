<?php

namespace App\Imports;
use App\Actividad;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon\Carbon;

class ActividadImport implements ToModel, WithHeadingRow, WithValidation
{
    private $numRows = 0;

    public function model(array $row)
    {
        ++$this->numRows;
        return new Actividad([
            'codPostulante'         =>  $row['codigo'],
            'codigo'                =>  $row['orden'],
            'descripcion'           =>  $row['descripcion'],
            'unidad'                =>  $row['unidad'],
            'meta_fisica'           =>  $row['meta_fisica'],
            'meta_financiera'       =>  $row['meta_financiera'],
            'precio'                =>  $row['precio'],
            'aporte_pcc'            =>  $row['aporte_pcc'],
            'aporte_oa'             =>  $row['aporte_oa'],
            'estado'                =>  1,
            'created_auth'          =>  1,
            'created_at'            =>  Carbon::now(),
            'updated_auth'          =>  1,
            'updated_at'            =>  Carbon::now()
        ]);
    }

    public function rules(): array
    {
        return [
            'codigo'            =>  'required',
            'orden'             =>  'required|integer',
            'descripcion'       =>  'required|max:600',
            'unidad'            =>  'required|max:255',
            'meta_fisica'       =>  'required|numeric',
            'meta_financiera'   =>  'required|numeric',
            'precio'            =>  'required|numeric',
            'aporte_pcc'        =>  'required|numeric',
            'aporte_oa'         =>  'required|numeric',
        ];
    }

    public function getRowCount(): int
    {
        return $this->numRows;
    }
}

