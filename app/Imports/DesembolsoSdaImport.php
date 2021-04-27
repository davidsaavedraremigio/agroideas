<?php

namespace App\Imports;
use App\ImportEjecPresupuesto;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class DesembolsoSdaImport implements ToModel, WithHeadingRow, WithValidation
{
    private $numRows = 0;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        ++$this->numRows;
        return new ImportEjecPresupuesto([
            'codigo'                =>  $row['codigo'],
            'periodo'               =>  $row['periodo'],
            'mes'                   =>  $row['mes'],
            'importe'               =>  $row['importe']
        ]);
    }

    public function rules(): array
    {
        return [
            'codigo'                =>  'required',
            'periodo'               =>  'required|integer',
            'mes'                   =>  'required|integer',
            'importe'               =>  'required'
        ];
    }

    public function getRowCount(): int
    {
        return $this->numRows;
    }
}
