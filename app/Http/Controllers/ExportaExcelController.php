<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Evento;
use App\EventoCompromiso;
use App\ConvenioMarco;
use Carbon\Carbon;
use DB;

class ExportaExcelController extends Controller
{
    #1. Valido el formulario y genero los estilos
    public function __construct()
    {
        $this->middleware('auth');
    }

    #2. Obtengo la matriz de eventos y compromisos
    public function exportaMatrizCompromisos()
    {
        #1. Definimos los estilos del documento a exportar
        $tituloPrincipal = [
		    'font'	=>	[
		    			'size'			=>	18,
						'bold' 			=> TRUE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> 'ffffff'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_THIN],
		                'left' 		=> ['borderStyle' => Border::BORDER_THIN],
		                'right' 	=> ['borderStyle' => Border::BORDER_THIN],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_THIN],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => '354049'],
		            ],
		];
		$cabecera = [
		    'font'	=>	[
		    			'size'			=>	10,
						'bold' 			=> TRUE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> 'ffffff'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'left' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'right' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => '354049'],
		            ],
        ];
        $body 	= [
		    'font'	=>	[
		    			'size'			=>	8,
						'bold' 			=> FALSE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> '000000'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'left' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'right' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => 'FFFFFF'],
		            ],
        ];     
        $numerico  = [
		    'formatCode' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
        $justificado 	= [
		    'font'	=>	[
		    			'size'			=>	8,
						'bold' 			=> FALSE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> '000000'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => 'FFFFFF'],
		            ],
        ];
        #2. Llamamos a la clase
        $reporteExcel   =   new Spreadsheet();
        #3. Creamos el nombre del archivo
        $namefile       =   "Consolidado_Matriz_Compromisos_".Carbon::now().".xlsx";
        #4. Generamos el título del Reporte
        $tituloReporte  =   "Matriz de compromisos - MINAGRI";
        #6. Genero la metadata del archivo
        $reporteExcel->getProperties()->setCreator('Oscar Javier Pazos M.')
            ->setLastModifiedBy('Oscar Javier Pazos M.')
            ->setTitle('Office 2007 XLSX Text Document')
            ->setSubject('Office 2007 XLSX Text Document')
            ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
            ->setKeywords('Office 2007 openxml php')
            ->setCategory('Test result file');
        #7. Indico el numero de pestaña donde se iniciará el documento
        $reporteExcel->setActiveSheetIndex(0);
        #8. Genero los títulos
        $reporteExcel->getActiveSheet()
            ->setCellValue('A1', $tituloReporte)

            ->setCellValue('A2', 'Datos de la comisión')
            ->setCellValue('N2', 'Estado situacional')
            ->setCellValue('Q2', 'Compromiso MINAGRI')
            ->setCellValue('V2', 'Implementación del compromiso')

            ->setCellValue('A3', 'Tipo')
            ->setCellValue('B3', 'Nombre de la comisión')
            ->setCellValue('C3', 'Secretaría técnica')
            ->setCellValue('D3', 'Representante secretaría técnica')
            ->setCellValue('E3', 'Institución que lidera')
            ->setCellValue('F3', 'Representante que preside')
            ->setCellValue('G3', 'Instituciones participantes')
            ->setCellValue('H3', 'Región')
            ->setCellValue('I3', 'Provincia')
            ->setCellValue('J3', 'Distrito')
            ->setCellValue('K3', 'Representante PCC')
            ->setCellValue('L3', 'Oficina desconcertada')
            ->setCellValue('M3', 'Cargo representante PCC')
            ->setCellValue('N3', 'Estado del compromiso')
            ->setCellValue('O3', 'Comentario')
            ->setCellValue('P3', 'Fecha de actualizacion')
            ->setCellValue('Q3', 'Documento que sustenta el compromiso')
            ->setCellValue('R3', 'Fecha de documento del compromiso')
            ->setCellValue('S3', 'Tipo de compromiso')
            ->setCellValue('T3', 'Compromiso')
            ->setCellValue('U3', 'Responsable')
            ->setCellValue('V3', 'Fecha de implementación')
            ->setCellValue('W3', 'Etapa del compromiso')
            ->setCellValue('X3', 'Responsable de la implementación')
            ->setCellValue('Y3', 'Resultados')
            ->setCellValue('Z3', 'Observaciones')
            ;
        #9. Genero el contenido de la tabla       
        $contenido      =   Evento::getDataMatriz();
        $numFila        =   3;     
        foreach ($contenido as $keyNumber => $row) 
        {
            $numFila++;
            $reporteExcel->getActiveSheet()
                ->setCellValue('A'.$numFila, $row->tipo_evento)
                ->setCellValue('B'.$numFila, $row->nombre_evento)
                ->setCellValue('C'.$numFila, $row->secretaria_tecnica)
                ->setCellValue('D'.$numFila, $row->representante_secretaria_tecnica)
                ->setCellValue('E'.$numFila, $row->institucion_organizadora)
                ->setCellValue('F'.$numFila, $row->representante_institucion_organizadora)
                ->setCellValue('G'.$numFila, $row->integrantes)
                ->setCellValue('H'.$numFila, $row->region)
                ->setCellValue('I'.$numFila, $row->provincia)
                ->setCellValue('J'.$numFila, $row->distrito)
                ->setCellValue('K'.$numFila, $row->responsable_pcc)
                ->setCellValue('L'.$numFila, $row->oficina)
                ->setCellValue('M'.$numFila, $row->cargo)

                ->setCellValue('N'.$numFila, $row->estado)
                ->setCellValue('O'.$numFila, '')
                ->setCellValue('P'.$numFila, $row->fecha_actualizacion)

                ->setCellValue('Q'.$numFila, $row->nroDocumento)
                ->setCellValue('R'.$numFila, $row->fechaDocumento)
                ->setCellValue('S'.$numFila, $row->tipo_compromiso)
                ->setCellValue('T'.$numFila, $row->compromiso)
                ->setCellValue('U'.$numFila, $row->responsable)

                ->setCellValue('V'.$numFila, $row->fecha_implementacion)
                ->setCellValue('W'.$numFila, $row->etapa_compromiso)
                ->setCellValue('X'.$numFila, $row->responsable_implementacion)
                ->setCellValue('Y'.$numFila, $row->resultados)
                ->setCellValue('Z'.$numFila, $row->observaciones)
                ;
            #Añado un borde para el contenido
            $reporteExcel->getActiveSheet()->getStyle('A'.($numFila).':Z'.($numFila))->getBorders()->getTop()->applyFromArray(
                [
                    'borderStyle'   =>  Border::BORDER_DASHDOT,
                    'color'         =>  [
                        'rgb'   =>  '808080'
                    ]
                ]
            );
        }

        #10. Defino el ancho de las columnas 
        $reporteExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $reporteExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $reporteExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $reporteExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $reporteExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
        $reporteExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
        $reporteExcel->getActiveSheet()->getColumnDimension('G')->setWidth(40);
        $reporteExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $reporteExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $reporteExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $reporteExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
        $reporteExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
        $reporteExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
        $reporteExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
        $reporteExcel->getActiveSheet()->getColumnDimension('O')->setWidth(40);
        $reporteExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
        $reporteExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
        $reporteExcel->getActiveSheet()->getColumnDimension('R')->setWidth(20);
        $reporteExcel->getActiveSheet()->getColumnDimension('S')->setWidth(20);
        $reporteExcel->getActiveSheet()->getColumnDimension('T')->setWidth(40);
        $reporteExcel->getActiveSheet()->getColumnDimension('U')->setWidth(40);
        $reporteExcel->getActiveSheet()->getColumnDimension('V')->setWidth(20);
        $reporteExcel->getActiveSheet()->getColumnDimension('W')->setWidth(30);
        $reporteExcel->getActiveSheet()->getColumnDimension('X')->setWidth(30);
        $reporteExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(30);
        $reporteExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(30);
        
        #11. Defino los estilos de la estructura Excel
        $reporteExcel->getActiveSheet()->mergeCells('A1:Z1');
        $reporteExcel->getActiveSheet()->mergeCells('A2:M2');
        $reporteExcel->getActiveSheet()->mergeCells('N2:P2');
        $reporteExcel->getActiveSheet()->mergeCells('Q2:U2');
        $reporteExcel->getActiveSheet()->mergeCells('V2:Z2');
        $reporteExcel->getActiveSheet()->getStyle('A1:Z1')->applyFromArray($tituloPrincipal);
        $reporteExcel->getActiveSheet()->getStyle('A2:Z3')->applyFromArray($cabecera);            
        $reporteExcel->getActiveSheet()->getStyle('A4:Z'.$numFila)->applyFromArray($body);
        
        #12. Defino el titulo de la pestaña activa
        $reporteExcel->getActiveSheet()->setTitle('Matriz de compromisos MINAGRI');
        
        #13. Insumos requeridos para la generación del documento
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$namefile\"");
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public');
        
        #14. Genero el archivo requerido
        $writer     =   IOFactory::createWriter($reporteExcel, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    #3. Obtengo un archivo con el resultado de la consulta resumen de compromisos
    public function exportaCompromisoResumen($tipo, $estado)
    {
        #1. Definimos los estilos del documento a exportar
        $tituloPrincipal = [
		    'font'	=>	[
		    			'size'			=>	18,
						'bold' 			=> TRUE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> 'ffffff'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_THIN],
		                'left' 		=> ['borderStyle' => Border::BORDER_THIN],
		                'right' 	=> ['borderStyle' => Border::BORDER_THIN],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_THIN],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => '354049'],
		            ],
		];
		$cabecera = [
		    'font'	=>	[
		    			'size'			=>	10,
						'bold' 			=> TRUE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> 'ffffff'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'left' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'right' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => '6915482'],
		            ],
        ];
        $body 	= [
		    'font'	=>	[
		    			'size'			=>	8,
						'bold' 			=> FALSE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> '000000'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'left' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'right' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => 'FFFFFF'],
		            ],
        ];     
        $numerico  = [
		    'formatCode' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
        $justificado 	= [
		    'font'	=>	[
		    			'size'			=>	8,
						'bold' 			=> FALSE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> '000000'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => 'FFFFFF'],
		            ],
        ];
        #2. Llamamos a la clase
        $reporteExcel   =   new Spreadsheet();
        #3. Creamos el nombre del archivo
        $namefile       =   "Consolidado_Resumen_Compromisos_".Carbon::now().".xlsx";
        #4. Generamos el título del Reporte
        $tituloReporte  =   "Matriz resumen de compromisos - MINAGRI";
        #5. Genero la metadata del archivo
        $reporteExcel->getProperties()->setCreator('Oscar Javier Pazos M.')
            ->setLastModifiedBy('Oscar Javier Pazos M.')
            ->setTitle('Office 2007 XLSX Text Document')
            ->setSubject('Office 2007 XLSX Text Document')
            ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
            ->setKeywords('Office 2007 openxml php')
            ->setCategory('Test result file');
        #6. Indico el numero de pestaña donde se iniciará el documento
        $reporteExcel->setActiveSheetIndex(0);
        #7. Genero los títulos
        $reporteExcel->getActiveSheet()
            ->setCellValue('A1', $tituloReporte)
            ->setCellValue('A2', 'Nº')
            ->setCellValue('B2', 'REGIÓN')
            ->setCellValue('C2', 'ORIGEN DEL COMPROMISO')
            ->setCellValue('D2', 'TIPO DE COMPROMISO')
            ->setCellValue('E2', 'COMPROMISO')
            ->setCellValue('F2', 'FECHA LÍMITE')
            ->setCellValue('G2', 'ESTADO')
            ;
        #8. Genero el contenido de la tabla 
        $data           =   EventoCompromiso::getCompromisos($tipo, $estado);
        $numFila        =   2;     
        foreach ($data as $keyNumber => $row) 
        {
            $numFila++;
            $reporteExcel->getActiveSheet()
                ->setCellValue('A'.$numFila, $keyNumber++)
                ->setCellValue('B'.$numFila, $row->region)
                ->setCellValue('C'.$numFila, $row->origen)
                ->setCellValue('D'.$numFila, $row->tipo)
                ->setCellValue('E'.$numFila, $row->compromiso)
                ->setCellValue('F'.$numFila, $row->fecha_limite)
                ->setCellValue('G'.$numFila, $row->estado)
            ;
            #Añado un borde para el contenido
            $reporteExcel->getActiveSheet()->getStyle('A'.($numFila).':G'.($numFila))->getBorders()->getTop()->applyFromArray(
                [
                    'borderStyle'   =>  Border::BORDER_DASHDOT,
                    'color'         =>  [
                        'rgb'   =>  '808080'
                    ]
                ]
            );
        }
        #9. Defino el ancho de las columnas 
        $reporteExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $reporteExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $reporteExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $reporteExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $reporteExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
        #10. Defino los estilos de la estructura Excel
        $reporteExcel->getActiveSheet()->mergeCells('A1:G1');
        $reporteExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($tituloPrincipal);
        $reporteExcel->getActiveSheet()->getStyle('A2:G2')->applyFromArray($cabecera);            
        $reporteExcel->getActiveSheet()->getStyle('A3:G'.$numFila)->applyFromArray($body);
        $reporteExcel->getActiveSheet()->getStyle('C3:C'.$numFila)->applyFromArray($justificado);
        $reporteExcel->getActiveSheet()->getStyle('E3:E'.$numFila)->applyFromArray($justificado);

        #11. Defino el titulo de la pestaña activa
        $reporteExcel->getActiveSheet()->setTitle('Matriz de compromisos MINAGRI');
        #12. Insumos requeridos para la generación del documento
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$namefile\"");
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public');
        #13. Genero el archivo requerido
        $writer     =   IOFactory::createWriter($reporteExcel, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    #4. Obtengo un consolidado de convenios de acuerdo al tipo y estado del convenio
    public function exportaConsolidadoConvenio($tipo, $estado)
    {
        #1. Definimos los estilos del documento a exportar
        $tituloPrincipal = [
		    'font'	=>	[
		    			'size'			=>	18,
						'bold' 			=> TRUE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> 'ffffff'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_THIN],
		                'left' 		=> ['borderStyle' => Border::BORDER_THIN],
		                'right' 	=> ['borderStyle' => Border::BORDER_THIN],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_THIN],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => '354049'],
		            ],
		];
		$cabecera = [
		    'font'	=>	[
		    			'size'			=>	10,
						'bold' 			=> TRUE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> 'ffffff'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'left' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'right' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => '6915482'],
		            ],
        ];
        $body 	= [
		    'font'	=>	[
		    			'size'			=>	8,
						'bold' 			=> FALSE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> '000000'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'left' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'right' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => 'FFFFFF'],
		            ],
        ];     
        $numerico  = [
		    'formatCode' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
        $justificado 	= [
		    'font'	=>	[
		    			'size'			=>	8,
						'bold' 			=> FALSE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> '000000'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => 'FFFFFF'],
		            ],
        ];
        #2. Llamamos a la clase
        $reporteExcel   =   new Spreadsheet();
        #3. Creamos el nombre del archivo
        $namefile       =   "Consolidado_Resumen_Convenios_".Carbon::now().".xlsx";
        #4. Generamos el título del Reporte
        $tituloReporte  =   "Matriz Convenios Interistitucionales";
        #5. Genero la metadata del archivo
        $reporteExcel->getProperties()->setCreator('Oscar Javier Pazos M.')
            ->setLastModifiedBy('Oscar Javier Pazos M.')
            ->setTitle('Office 2007 XLSX Text Document')
            ->setSubject('Office 2007 XLSX Text Document')
            ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
            ->setKeywords('Office 2007 openxml php')
            ->setCategory('Test result file');
        #6. Indico el numero de pestaña donde se iniciará el documento
        $reporteExcel->setActiveSheetIndex(0);
        #7. Genero los títulos
        $reporteExcel->getActiveSheet()
            ->setCellValue('A1', $tituloReporte)
            ->setCellValue('A2', 'Nº')
            ->setCellValue('B2', 'PERIODO')
            ->setCellValue('C2', 'Nº CUT')
            ->setCellValue('D2', 'NOMBRE DE LA INSTITUCION')
            ->setCellValue('E2', 'REGIÓN')
            ->setCellValue('F2', 'DIRECCIÓN')
            ->setCellValue('G2', 'REPRESENTANTE LEGAL')
            ->setCellValue('H2', 'CARGO')
            ->setCellValue('I2', 'FECHA DE FIRMA')
            ->setCellValue('J2', 'FECHA DE TÉRMINO')
            ->setCellValue('K2', 'COORDINADOR TITULAR PCC')
            ->setCellValue('L2', 'COORDINADOR SUPLENTE PCC')
            ->setCellValue('M2', 'COORDINADOR TITULAR ENTIDAD')
            ->setCellValue('N2', 'COORDINADOR SUPLENTE ENTIDAD')
            ->setCellValue('O2', 'PRESUPUESTO ASIGNADO (S/.)')
            ->setCellValue('P2', 'Nº DE ADENDAS')
            ->setCellValue('Q2', 'ESTADO ACTUAL')
            ;
        #8. Genero el contenido de la tabla 
        $data           =   ConvenioMarco::getConvenios($tipo, $estado);
        $numFila        =   2;     
        foreach ($data as $keyNumber => $row) 
        {
            $numFila++;
            $reporteExcel->getActiveSheet()
                ->setCellValue('A'.$numFila, $row->nro_convenio)
                ->setCellValue('B'.$numFila, $row->periodo)
                ->setCellValue('C'.$numFila, $row->nro_cut)
                ->setCellValue('D'.$numFila, $row->razon_social)
                ->setCellValue('E'.$numFila, $row->region)
                ->setCellValue('F'.$numFila, $row->direccion)
                ->setCellValue('G'.$numFila, $row->rl_nombre)
                ->setCellValue('H'.$numFila, $row->rl_cargo)
                ->setCellValue('I'.$numFila, $row->fecha_firma)
                ->setCellValue('J'.$numFila, $row->fecha_termino)
                ->setCellValue('K'.$numFila, $row->coordinador_pcc_titular)
                ->setCellValue('L'.$numFila, $row->coordinador_pcc_suplente)
                ->setCellValue('M'.$numFila, $row->coordinador_entidad_titular)
                ->setCellValue('N'.$numFila, $row->coordinador_entidad_suplente)
                ->setCellValue('O'.$numFila, $row->importe)
                ->setCellValue('P'.$numFila, '-')
                ->setCellValue('Q'.$numFila, $row->estado_situacional)
            ;
            #Añado un borde para el contenido
            $reporteExcel->getActiveSheet()->getStyle('A'.($numFila).':Q'.($numFila))->getBorders()->getTop()->applyFromArray(
                [
                    'borderStyle'   =>  Border::BORDER_DASHDOT,
                    'color'         =>  [
                        'rgb'   =>  '808080'
                    ]
                ]
            );
        }        
        #9. Defino el ancho de las columnas 
        $reporteExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $reporteExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $reporteExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $reporteExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
        $reporteExcel->getActiveSheet()->getColumnDimension('F')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
        $reporteExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
        $reporteExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
        $reporteExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
        $reporteExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
        $reporteExcel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
        $reporteExcel->getActiveSheet()->getColumnDimension('M')->setWidth(25);
        $reporteExcel->getActiveSheet()->getColumnDimension('N')->setWidth(25);
        $reporteExcel->getActiveSheet()->getColumnDimension('O')->setWidth(25);
        $reporteExcel->getActiveSheet()->getColumnDimension('P')->setWidth(25);
        $reporteExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(25);
        #10. Defino los estilos de la estructura Excel
        $reporteExcel->getActiveSheet()->mergeCells('A1:Q1');
        $reporteExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($tituloPrincipal);
        $reporteExcel->getActiveSheet()->getStyle('A2:Q2')->applyFromArray($cabecera);            
        $reporteExcel->getActiveSheet()->getStyle('A3:Q'.$numFila)->applyFromArray($body);
        #11. Defino el titulo de la pestaña activa
        $reporteExcel->getActiveSheet()->setTitle('Información Consolidada');
        #12. Insumos requeridos para la generación del documento
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$namefile\"");
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public');
        #13. Genero el archivo requerido
        $writer     =   IOFactory::createWriter($reporteExcel, 'Xlsx');
        $writer->save('php://output');
        exit;        
    }

























    #3. Obtengo la matriz para el Reporte mesas tecnicas 1,2,4 y 5
    public function exportaReport01()
    {
        #1. Definimos los estilos del documento a exportar
        $tituloPrincipal = [
		    'font'	=>	[
		    			'size'			=>	18,
						'bold' 			=> TRUE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> 'ffffff'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_THIN],
		                'left' 		=> ['borderStyle' => Border::BORDER_THIN],
		                'right' 	=> ['borderStyle' => Border::BORDER_THIN],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_THIN],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => '354049'],
		            ],
		];
		$cabecera = [
		    'font'	=>	[
		    			'size'			=>	10,
						'bold' 			=> TRUE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> 'ffffff'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'left' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'right' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => '354049'],
		            ],
        ];
        $body 	= [
		    'font'	=>	[
		    			'size'			=>	8,
						'bold' 			=> FALSE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> '000000'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'left' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'right' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => 'FFFFFF'],
		            ],
        ];     
        $numerico  = [
		    'formatCode' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
        $justificado 	= [
		    'font'	=>	[
		    			'size'			=>	8,
						'bold' 			=> FALSE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> '000000'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => 'FFFFFF'],
		            ],
        ];
        #2. Llamamos a la clase
        $reporteExcel   =   new Spreadsheet();
        #3. Creamos el nombre del archivo
        $namefile       =   "Consolidado_Matriz_Compromisos_".Carbon::now().".xlsx";
        #4. Generamos el título del Reporte
        $tituloReporte  =   "MATRIZ DE SEGUIMIENTO AL CUMPLIMIENTO DE LOS 81 ACUERDOS";
        #6. Genero la metadata del archivo
        $reporteExcel->getProperties()->setCreator('Oscar Javier Pazos M.')
            ->setLastModifiedBy('Oscar Javier Pazos M.')
            ->setTitle('Office 2007 XLSX Text Document')
            ->setSubject('Office 2007 XLSX Text Document')
            ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
            ->setKeywords('Office 2007 openxml php')
            ->setCategory('Test result file');
        #7. Indico el numero de pestaña donde se iniciará el documento
        $reporteExcel->setActiveSheetIndex(0);
        #8. Genero los títulos
        $reporteExcel->getActiveSheet()
            ->setCellValue('A1', $tituloReporte)
            ->setCellValue('A2', 'MESA')
            ->setCellValue('B2', 'SUBMESA')
            ->setCellValue('C2', 'ITEM')
            ->setCellValue('D2', 'ACUERDOS')
            ->setCellValue('E2', 'ESTADO')
            ->setCellValue('F2', 'SITUACIÓN ACTUAL')
            ->setCellValue('G2', 'ACTORES')
            ->setCellValue('H2', 'RESPONSABLE')
            ->setCellValue('I2', 'DIRECTOR GENERAL / JEFE')
            ;     
        #9. Genero el contenido de la tabla       
        $contenido      =   Evento::getDataReport01();
        $numFila        =   2;     
        foreach ($contenido as $keyNumber => $row) 
        {
            $numFila++;
            $reporteExcel->getActiveSheet()
                ->setCellValue('A'.$numFila, $row->nombre)
                ->setCellValue('B'.$numFila, '-')
                ->setCellValue('C'.$numFila, $keyNumber+1)
                ->setCellValue('D'.$numFila, $row->compromiso)
                ->setCellValue('E'.$numFila, $row->situacion)
                ->setCellValue('F'.$numFila, $row->resultados)
                ->setCellValue('G'.$numFila, $row->actores)
                ->setCellValue('H'.$numFila, $row->responsable)
                ->setCellValue('I'.$numFila, $row->representante)
                ;
            #Añado un borde para el contenido
            $reporteExcel->getActiveSheet()->getStyle('A'.($numFila).':I'.($numFila))->getBorders()->getTop()->applyFromArray(
                [
                    'borderStyle'   =>  Border::BORDER_DASHDOT,
                    'color'         =>  [
                        'rgb'   =>  '808080'
                    ]
                ]
            );
        }      
        #10. Defino el ancho de las columnas 
        $reporteExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
        $reporteExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $reporteExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
        $reporteExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $reporteExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $reporteExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $reporteExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
        $reporteExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $reporteExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);       

        #11. Defino los estilos de la estructura Excel
        $reporteExcel->getActiveSheet()->mergeCells('A1:I1');
        $reporteExcel->getActiveSheet()->getStyle('A1:I1')->applyFromArray($tituloPrincipal);
        $reporteExcel->getActiveSheet()->getStyle('A2:I2')->applyFromArray($cabecera);            
        $reporteExcel->getActiveSheet()->getStyle('A3:I'.$numFila)->applyFromArray($body);        

        #12. Defino el titulo de la pestaña activa
        $reporteExcel->getActiveSheet()->setTitle('Reportes Mesas técnicas');
        
        #13. Insumos requeridos para la generación del documento
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$namefile\"");
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public');
        
        #14. Genero el archivo requerido
        $writer     =   IOFactory::createWriter($reporteExcel, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    #4. Obtengo la matriz del gore amazonas
    public function exportaReport02()
    {
        #1. Definimos los estilos del documento a exportar
        $tituloPrincipal = [
		    'font'	=>	[
		    			'size'			=>	18,
						'bold' 			=> TRUE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> 'ffffff'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_THIN],
		                'left' 		=> ['borderStyle' => Border::BORDER_THIN],
		                'right' 	=> ['borderStyle' => Border::BORDER_THIN],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_THIN],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => '354049'],
		            ],
		];
		$cabecera = [
		    'font'	=>	[
		    			'size'			=>	10,
						'bold' 			=> TRUE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> 'ffffff'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'left' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'right' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => '354049'],
		            ],
        ];
        $body 	= [
		    'font'	=>	[
		    			'size'			=>	8,
						'bold' 			=> FALSE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> '000000'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'left' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'right' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => 'FFFFFF'],
		            ],
        ];     
        $numerico  = [
		    'formatCode' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
        $justificado 	= [
		    'font'	=>	[
		    			'size'			=>	8,
						'bold' 			=> FALSE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> '000000'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => 'FFFFFF'],
		            ],
        ];
        #2. Llamamos a la clase
        $reporteExcel   =   new Spreadsheet();
        #3. Creamos el nombre del archivo
        $namefile       =   "Consolidado_Matriz_Compromisos_".Carbon::now().".xlsx";
        #4. Generamos el título del Reporte
        $tituloReporte  =   "REPORTE DE AVANCE DE COMPROMISOS DE GORE EJECUTIVO";
        #6. Genero la metadata del archivo
        $reporteExcel->getProperties()->setCreator('Oscar Javier Pazos M.')
            ->setLastModifiedBy('Oscar Javier Pazos M.')
            ->setTitle('Office 2007 XLSX Text Document')
            ->setSubject('Office 2007 XLSX Text Document')
            ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
            ->setKeywords('Office 2007 openxml php')
            ->setCategory('Test result file');
        #7. Indico el numero de pestaña donde se iniciará el documento
        $reporteExcel->setActiveSheetIndex(0);
        #8. Genero los títulos
        $reporteExcel->getActiveSheet()
            ->setCellValue('A1', $tituloReporte)
            ->setCellValue('A2', 'Pedidos')
            ->setCellValue('D2', 'Compromisos')
            ->setCellValue('I2', 'Actividad')
            ->setCellValue('M2', 'Avance actual')
            ->setCellValue('A3', 'Gore')
            ->setCellValue('B3', 'Pedido')
            ->setCellValue('C3', 'Solicitante')
            ->setCellValue('D3', 'Nombre')
            ->setCellValue('E3', 'Responsable')
            ->setCellValue('F3', 'Tipo')
            ->setCellValue('G3', 'Plazo')
            ->setCellValue('H3', 'Estado')
            ->setCellValue('I3', 'Nombre')
            ->setCellValue('J3', 'Avance (%)')
            ->setCellValue('K3', 'Plazo')
            ->setCellValue('L3', 'Estado')
            ;     
        #9. Genero el contenido de la tabla       
        $contenido      =   Evento::getDataReport02();
        $numFila        =   3;     
        foreach ($contenido as $keyNumber => $row) 
        {
            $numFila++;
            $reporteExcel->getActiveSheet()
                ->setCellValue('A'.$numFila, $row->nombre)
                ->setCellValue('B'.$numFila, $row->objetivo)
                ->setCellValue('C'.$numFila, $row->integrantes)

                ->setCellValue('D'.$numFila, $row->compromiso)
                ->setCellValue('E'.$numFila, $row->responsable)
                ->setCellValue('F'.$numFila, $row->tipo)
                ->setCellValue('G'.$numFila, $row->fecha_plazo)
                ->setCellValue('H'.$numFila, $row->situacion)

                ->setCellValue('I'.$numFila, $row->compromiso)
                ->setCellValue('J'.$numFila, '-')
                ->setCellValue('K'.$numFila, $row->fecha_plazo)
                ->setCellValue('L'.$numFila, $row->situacion)
                ->setCellValue('M'.$numFila, $row->resultados)
                ;
            #Añado un borde para el contenido
            $reporteExcel->getActiveSheet()->getStyle('A'.($numFila).':M'.($numFila))->getBorders()->getTop()->applyFromArray(
                [
                    'borderStyle'   =>  Border::BORDER_DASHDOT,
                    'color'         =>  [
                        'rgb'   =>  '808080'
                    ]
                ]
            );
        }      
        #10. Defino el ancho de las columnas 
        $reporteExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $reporteExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $reporteExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $reporteExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $reporteExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $reporteExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $reporteExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $reporteExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $reporteExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);  
        $reporteExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);  
        $reporteExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);  
        $reporteExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);  
        $reporteExcel->getActiveSheet()->getColumnDimension('M')->setWidth(30);       

        #11. Defino los estilos de la estructura Excel
        $reporteExcel->getActiveSheet()->mergeCells('A1:M1');
        $reporteExcel->getActiveSheet()->mergeCells('A2:C2');
        $reporteExcel->getActiveSheet()->mergeCells('D2:H2');
        $reporteExcel->getActiveSheet()->mergeCells('I2:L2');
        $reporteExcel->getActiveSheet()->mergeCells('M2:M3');
        $reporteExcel->getActiveSheet()->getStyle('A1:M1')->applyFromArray($tituloPrincipal);
        $reporteExcel->getActiveSheet()->getStyle('A2:M3')->applyFromArray($cabecera);            
        $reporteExcel->getActiveSheet()->getStyle('A4:M'.$numFila)->applyFromArray($body);        

        #12. Defino el titulo de la pestaña activa
        $reporteExcel->getActiveSheet()->setTitle('10mo Gore ejecutivo');
        
        #13. Insumos requeridos para la generación del documento
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$namefile\"");
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public');
        
        #14. Genero el archivo requerido
        $writer     =   IOFactory::createWriter($reporteExcel, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    #5. Obtengo la matrix del 11vo gore ejecutivo
    public function exportaReport03()
    {
        #1. Definimos los estilos del documento a exportar
        $tituloPrincipal = [
		    'font'	=>	[
		    			'size'			=>	18,
						'bold' 			=> TRUE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> 'ffffff'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_THIN],
		                'left' 		=> ['borderStyle' => Border::BORDER_THIN],
		                'right' 	=> ['borderStyle' => Border::BORDER_THIN],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_THIN],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => '354049'],
		            ],
		];
		$cabecera = [
		    'font'	=>	[
		    			'size'			=>	10,
						'bold' 			=> TRUE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> 'ffffff'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'left' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'right' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => '354049'],
		            ],
        ];
        $body 	= [
		    'font'	=>	[
		    			'size'			=>	8,
						'bold' 			=> FALSE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> '000000'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'left' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'right' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => 'FFFFFF'],
		            ],
        ];     
        $numerico  = [
		    'formatCode' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
        $justificado 	= [
		    'font'	=>	[
		    			'size'			=>	8,
						'bold' 			=> FALSE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> '000000'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => 'FFFFFF'],
		            ],
        ];
        #2. Llamamos a la clase
        $reporteExcel   =   new Spreadsheet();
        #3. Creamos el nombre del archivo
        $namefile       =   "Consolidado_Matriz_Compromisos_".Carbon::now().".xlsx";
        #4. Generamos el título del Reporte
        $tituloReporte  =   "REPORTE DE AVANCE DE COMPROMISOS DE GORE EJECUTIVO";
        #6. Genero la metadata del archivo
        $reporteExcel->getProperties()->setCreator('Oscar Javier Pazos M.')
            ->setLastModifiedBy('Oscar Javier Pazos M.')
            ->setTitle('Office 2007 XLSX Text Document')
            ->setSubject('Office 2007 XLSX Text Document')
            ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
            ->setKeywords('Office 2007 openxml php')
            ->setCategory('Test result file');
        #7. Indico el numero de pestaña donde se iniciará el documento
        $reporteExcel->setActiveSheetIndex(0);
        #8. Genero los títulos
        $reporteExcel->getActiveSheet()
            ->setCellValue('B1', $tituloReporte)
            ->setCellValue('B2', 'MACROREGION')
            ->setCellValue('C2', 'COMPROMISO')
            ->setCellValue('D2', 'RESPONSABLE')
            ->setCellValue('E2', 'ACTIVIDADES')
            ->setCellValue('F2', 'RESPONSABLES EN EL SECTOR')
            ->setCellValue('G2', 'AVANCES')
            ;     
        #9. Genero el contenido de la tabla       
        $contenido      =   Evento::getDataReport03();
        $numFila        =   2;     
        foreach ($contenido as $keyNumber => $row) 
        {
            $numFila++;
            $reporteExcel->getActiveSheet()
                ->setCellValue('B'.$numFila, $row->nombre)
                ->setCellValue('C'.$numFila, $row->compromiso)
                ->setCellValue('D'.$numFila, $row->responsable)
                ->setCellValue('E'.$numFila, $row->etapa)
                ->setCellValue('F'.$numFila, $row->organizadores)
                ->setCellValue('G'.$numFila, $row->resultados)
                ;
            #Añado un borde para el contenido
            $reporteExcel->getActiveSheet()->getStyle('B'.($numFila).':G'.($numFila))->getBorders()->getTop()->applyFromArray(
                [
                    'borderStyle'   =>  Border::BORDER_DASHDOT,
                    'color'         =>  [
                        'rgb'   =>  '808080'
                    ]
                ]
            );
        }      
        #10. Defino el ancho de las columnas 
        $reporteExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $reporteExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $reporteExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $reporteExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $reporteExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $reporteExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
     
        
        #11. Defino los estilos de la estructura Excel
        $reporteExcel->getActiveSheet()->mergeCells('B1:G1');
        $reporteExcel->getActiveSheet()->getStyle('B1:G1')->applyFromArray($tituloPrincipal);
        $reporteExcel->getActiveSheet()->getStyle('B2:G2')->applyFromArray($cabecera);            
        $reporteExcel->getActiveSheet()->getStyle('B3:G'.$numFila)->applyFromArray($body);        

        #12. Defino el titulo de la pestaña activa
        $reporteExcel->getActiveSheet()->setTitle('11 Gore ejecutivo');
        
        #13. Insumos requeridos para la generación del documento
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$namefile\"");
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public');
        
        #14. Genero el archivo requerido
        $writer     =   IOFactory::createWriter($reporteExcel, 'Xlsx');
        $writer->save('php://output');
        exit;        
    }

    #6. Obtengo la matrix de la 12vo gore ejecutivo
    public function exportaReport04()
    {
        #1. Definimos los estilos del documento a exportar
        $tituloPrincipal = [
		    'font'	=>	[
		    			'size'			=>	18,
						'bold' 			=> TRUE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> 'ffffff'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_THIN],
		                'left' 		=> ['borderStyle' => Border::BORDER_THIN],
		                'right' 	=> ['borderStyle' => Border::BORDER_THIN],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_THIN],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => '354049'],
		            ],
		];
		$cabecera = [
		    'font'	=>	[
		    			'size'			=>	10,
						'bold' 			=> TRUE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> 'ffffff'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'left' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'right' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => '354049'],
		            ],
        ];
        $body 	= [
		    'font'	=>	[
		    			'size'			=>	8,
						'bold' 			=> FALSE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> '000000'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'left' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'right' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => 'FFFFFF'],
		            ],
        ];     
        $numerico  = [
		    'formatCode' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
        $justificado 	= [
		    'font'	=>	[
		    			'size'			=>	8,
						'bold' 			=> FALSE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> '000000'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => 'FFFFFF'],
		            ],
        ];
        #2. Llamamos a la clase
        $reporteExcel   =   new Spreadsheet();
        #3. Creamos el nombre del archivo
        $namefile       =   "Consolidado_Matriz_Compromisos_".Carbon::now().".xlsx";
        #4. Generamos el título del Reporte
        $tituloReporte  =   "AVANCES EN EL CUMPLIMIENTO DE COMPROMISOS 12avo GORE EJECUTIVO";
        #6. Genero la metadata del archivo
        $reporteExcel->getProperties()->setCreator('Oscar Javier Pazos M.')
            ->setLastModifiedBy('Oscar Javier Pazos M.')
            ->setTitle('Office 2007 XLSX Text Document')
            ->setSubject('Office 2007 XLSX Text Document')
            ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
            ->setKeywords('Office 2007 openxml php')
            ->setCategory('Test result file');
        #7. Indico el numero de pestaña donde se iniciará el documento
        $reporteExcel->setActiveSheetIndex(0);
        #8. Genero los títulos
        $reporteExcel->getActiveSheet()
            ->setCellValue('B1', $tituloReporte)
            ->setCellValue('B2', 'REGION')
            ->setCellValue('C2', 'COMPROMISO')
            ->setCellValue('D2', 'AVANCES')
            ->setCellValue('E2', 'SITUACION')
            ;     
        #9. Genero el contenido de la tabla       
        $contenido      =   Evento::getDataReport04();
        $numFila        =   2;     
        foreach ($contenido as $keyNumber => $row) 
        {
            $numFila++;
            $reporteExcel->getActiveSheet()
                ->setCellValue('B'.$numFila, $row->region)
                ->setCellValue('C'.$numFila, $row->compromiso)
                ->setCellValue('D'.$numFila, $row->resultados)
                ->setCellValue('E'.$numFila, $row->situacion)
                ;
            #Añado un borde para el contenido
            $reporteExcel->getActiveSheet()->getStyle('B'.($numFila).':E'.($numFila))->getBorders()->getTop()->applyFromArray(
                [
                    'borderStyle'   =>  Border::BORDER_DASHDOT,
                    'color'         =>  [
                        'rgb'   =>  '808080'
                    ]
                ]
            );
        }      
        #10. Defino el ancho de las columnas 
        $reporteExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $reporteExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $reporteExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $reporteExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
       
        #11. Defino los estilos de la estructura Excel
        $reporteExcel->getActiveSheet()->mergeCells('B1:E1');
        $reporteExcel->getActiveSheet()->getStyle('B1:E1')->applyFromArray($tituloPrincipal);
        $reporteExcel->getActiveSheet()->getStyle('B2:E2')->applyFromArray($cabecera);            
        $reporteExcel->getActiveSheet()->getStyle('B3:E'.$numFila)->applyFromArray($body);        

        #12. Defino el titulo de la pestaña activa
        $reporteExcel->getActiveSheet()->setTitle('12 Gore ejecutivo');
        
        #13. Insumos requeridos para la generación del documento
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$namefile\"");
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public');
        
        #14. Genero el archivo requerido
        $writer     =   IOFactory::createWriter($reporteExcel, 'Xlsx');
        $writer->save('php://output');
        exit;    
    }

    #7. Obtengo la matriz de compromiso zarumilla
    public function exportaReport05()
    {
        #1. Definimos los estilos del documento a exportar
        $tituloPrincipal = [
		    'font'	=>	[
		    			'size'			=>	18,
						'bold' 			=> TRUE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> 'ffffff'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_THIN],
		                'left' 		=> ['borderStyle' => Border::BORDER_THIN],
		                'right' 	=> ['borderStyle' => Border::BORDER_THIN],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_THIN],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => '354049'],
		            ],
		];
		$cabecera = [
		    'font'	=>	[
		    			'size'			=>	10,
						'bold' 			=> TRUE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> 'ffffff'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'left' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'right' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => '354049'],
		            ],
        ];
        $body 	= [
		    'font'	=>	[
		    			'size'			=>	8,
						'bold' 			=> FALSE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> '000000'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'left' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'right' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => 'FFFFFF'],
		            ],
        ];     
        $numerico  = [
		    'formatCode' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
        $justificado 	= [
		    'font'	=>	[
		    			'size'			=>	8,
						'bold' 			=> FALSE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> '000000'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => 'FFFFFF'],
		            ],
        ];
        #2. Llamamos a la clase
        $reporteExcel   =   new Spreadsheet();
        #3. Creamos el nombre del archivo
        $namefile       =   "Consolidado_Matriz_Compromisos_".Carbon::now().".xlsx";
        #4. Generamos el título del Reporte
        $tituloReporte  =   "AVANCES EN EL CUMPLIMIENTO DE COMPROMISOS ZARUMILLA";
        #6. Genero la metadata del archivo
        $reporteExcel->getProperties()->setCreator('Oscar Javier Pazos M.')
            ->setLastModifiedBy('Oscar Javier Pazos M.')
            ->setTitle('Office 2007 XLSX Text Document')
            ->setSubject('Office 2007 XLSX Text Document')
            ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
            ->setKeywords('Office 2007 openxml php')
            ->setCategory('Test result file');
        #7. Indico el numero de pestaña donde se iniciará el documento
        $reporteExcel->setActiveSheetIndex(0);
        #8. Genero los títulos
        $reporteExcel->getActiveSheet()
            ->setCellValue('B1', $tituloReporte)
            ->setCellValue('B2', 'DEPARTAMENTO')
            ->setCellValue('C2', 'NOMBRE DE LA COMISION')
            ->setCellValue('D2', 'COMPROMISO')
            ->setCellValue('E2', 'AVANCES')
            ;     
        #9. Genero el contenido de la tabla       
        $contenido      =   Evento::getDataReport05();
        $numFila        =   2;     
        foreach ($contenido as $keyNumber => $row) 
        {
            $numFila++;
            $reporteExcel->getActiveSheet()
                ->setCellValue('B'.$numFila, $row->region)
                ->setCellValue('C'.$numFila, $row->nombre)
                ->setCellValue('D'.$numFila, $row->compromiso)
                ->setCellValue('E'.$numFila, $row->resultados)
                ;
            #Añado un borde para el contenido
            $reporteExcel->getActiveSheet()->getStyle('B'.($numFila).':E'.($numFila))->getBorders()->getTop()->applyFromArray(
                [
                    'borderStyle'   =>  Border::BORDER_DASHDOT,
                    'color'         =>  [
                        'rgb'   =>  '808080'
                    ]
                ]
            );
        }      
        #10. Defino el ancho de las columnas 
        $reporteExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $reporteExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $reporteExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $reporteExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
       
        #11. Defino los estilos de la estructura Excel
        $reporteExcel->getActiveSheet()->mergeCells('B1:E1');
        $reporteExcel->getActiveSheet()->getStyle('B1:E1')->applyFromArray($tituloPrincipal);
        $reporteExcel->getActiveSheet()->getStyle('B2:E2')->applyFromArray($cabecera);            
        $reporteExcel->getActiveSheet()->getStyle('B3:E'.$numFila)->applyFromArray($body);        

        #12. Defino el titulo de la pestaña activa
        $reporteExcel->getActiveSheet()->setTitle('Compromiso Zarumilla');
        
        #13. Insumos requeridos para la generación del documento
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$namefile\"");
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public');
        
        #14. Genero el archivo requerido
        $writer     =   IOFactory::createWriter($reporteExcel, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    #8. Obtengo la información de compromisos Bagua
    public function exportaReport06()
    {
        #1. Definimos los estilos del documento a exportar
        $tituloPrincipal = [
		    'font'	=>	[
		    			'size'			=>	18,
						'bold' 			=> TRUE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> 'ffffff'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_THIN],
		                'left' 		=> ['borderStyle' => Border::BORDER_THIN],
		                'right' 	=> ['borderStyle' => Border::BORDER_THIN],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_THIN],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => '354049'],
		            ],
		];
		$cabecera = [
		    'font'	=>	[
		    			'size'			=>	10,
						'bold' 			=> TRUE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> 'ffffff'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'left' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'right' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => '354049'],
		            ],
        ];
        $body 	= [
		    'font'	=>	[
		    			'size'			=>	8,
						'bold' 			=> FALSE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> '000000'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'left' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'right' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => 'FFFFFF'],
		            ],
        ];     
        $numerico  = [
		    'formatCode' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
        $justificado 	= [
		    'font'	=>	[
		    			'size'			=>	8,
						'bold' 			=> FALSE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> '000000'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => 'FFFFFF'],
		            ],
        ];
        #2. Llamamos a la clase
        $reporteExcel   =   new Spreadsheet();
        #3. Creamos el nombre del archivo
        $namefile       =   "Consolidado_Matriz_Compromisos_".Carbon::now().".xlsx";
        #4. Generamos el título del Reporte
        $tituloReporte  =   "ACUERDOS Y COMPROMISOS - MUNICIPALIDAD PROVINCIAL DE BAGUA";
        #6. Genero la metadata del archivo
        $reporteExcel->getProperties()->setCreator('Oscar Javier Pazos M.')
            ->setLastModifiedBy('Oscar Javier Pazos M.')
            ->setTitle('Office 2007 XLSX Text Document')
            ->setSubject('Office 2007 XLSX Text Document')
            ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
            ->setKeywords('Office 2007 openxml php')
            ->setCategory('Test result file');
        #7. Indico el numero de pestaña donde se iniciará el documento
        $reporteExcel->setActiveSheetIndex(0);
        #8. Genero los títulos
        $reporteExcel->getActiveSheet()
            ->setCellValue('B1', $tituloReporte)
            ->setCellValue('B2', 'Nº')
            ->setCellValue('C2', 'COMPROMISO')
            ->setCellValue('D2', 'MESA DE TRABAJO')
            ->setCellValue('E2', 'RESPONSABLES')
            ->setCellValue('F2', 'AVANCES')
            ;     
        #9. Genero el contenido de la tabla       
        $contenido      =   Evento::getDataReport06();
        $numFila        =   2;     
        foreach ($contenido as $keyNumber => $row) 
        {
            $numFila++;
            $reporteExcel->getActiveSheet()
                ->setCellValue('B'.$numFila, $keyNumber+1)
                ->setCellValue('C'.$numFila, $row->compromiso)
                ->setCellValue('D'.$numFila, $row->nombre)
                ->setCellValue('E'.$numFila, $row->responsable)
                ->setCellValue('F'.$numFila, $row->resultados)
                ;
            #Añado un borde para el contenido
            $reporteExcel->getActiveSheet()->getStyle('B'.($numFila).':F'.($numFila))->getBorders()->getTop()->applyFromArray(
                [
                    'borderStyle'   =>  Border::BORDER_DASHDOT,
                    'color'         =>  [
                        'rgb'   =>  '808080'
                    ]
                ]
            );
        }      
        #10. Defino el ancho de las columnas 
        $reporteExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $reporteExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $reporteExcel->getActiveSheet()->getColumnDimension('F')->setWidth(50);
       
        #11. Defino los estilos de la estructura Excel
        $reporteExcel->getActiveSheet()->mergeCells('B1:F1');
        $reporteExcel->getActiveSheet()->getStyle('B1:F1')->applyFromArray($tituloPrincipal);
        $reporteExcel->getActiveSheet()->getStyle('B2:F2')->applyFromArray($cabecera);            
        $reporteExcel->getActiveSheet()->getStyle('B3:F'.$numFila)->applyFromArray($body);        

        #12. Defino el titulo de la pestaña activa
        $reporteExcel->getActiveSheet()->setTitle('Compromisos y acuerdos Bagua');
        
        #13. Insumos requeridos para la generación del documento
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$namefile\"");
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public');
        
        #14. Genero el archivo requerido
        $writer     =   IOFactory::createWriter($reporteExcel, 'Xlsx');
        $writer->save('php://output');
        exit;
    }    

    #9. Obtengo la información de compromisos Condorcanqui
    public function exportaReport07()
    {
        #1. Definimos los estilos del documento a exportar
        $tituloPrincipal = [
		    'font'	=>	[
		    			'size'			=>	18,
						'bold' 			=> TRUE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> 'ffffff'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_THIN],
		                'left' 		=> ['borderStyle' => Border::BORDER_THIN],
		                'right' 	=> ['borderStyle' => Border::BORDER_THIN],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_THIN],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => '354049'],
		            ],
		];
		$cabecera = [
		    'font'	=>	[
		    			'size'			=>	10,
						'bold' 			=> TRUE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> 'ffffff'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'left' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'right' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => '354049'],
		            ],
        ];
        $body 	= [
		    'font'	=>	[
		    			'size'			=>	8,
						'bold' 			=> FALSE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> '000000'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'left' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'right' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => 'FFFFFF'],
		            ],
        ];     
        $numerico  = [
		    'formatCode' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
        $justificado 	= [
		    'font'	=>	[
		    			'size'			=>	8,
						'bold' 			=> FALSE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> '000000'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => 'FFFFFF'],
		            ],
        ];
        #2. Llamamos a la clase
        $reporteExcel   =   new Spreadsheet();
        #3. Creamos el nombre del archivo
        $namefile       =   "Consolidado_Matriz_Compromisos_".Carbon::now().".xlsx";
        #4. Generamos el título del Reporte
        $tituloReporte  =   "ACUERDOS Y COMPROMISOS - MUNICIPALIDAD PROVINCIAL DE CONDORCANQUI";
        #6. Genero la metadata del archivo
        $reporteExcel->getProperties()->setCreator('Oscar Javier Pazos M.')
            ->setLastModifiedBy('Oscar Javier Pazos M.')
            ->setTitle('Office 2007 XLSX Text Document')
            ->setSubject('Office 2007 XLSX Text Document')
            ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
            ->setKeywords('Office 2007 openxml php')
            ->setCategory('Test result file');
        #7. Indico el numero de pestaña donde se iniciará el documento
        $reporteExcel->setActiveSheetIndex(0);
        #8. Genero los títulos
        $reporteExcel->getActiveSheet()
            ->setCellValue('B1', $tituloReporte)
            ->setCellValue('B2', 'Nº')
            ->setCellValue('C2', 'COMPROMISO')
            ->setCellValue('D2', 'MESA DE TRABAJO')
            ->setCellValue('E2', 'RESPONSABLES')
            ->setCellValue('F2', 'AVANCES')
            ;     
        #9. Genero el contenido de la tabla       
        $contenido      =   Evento::getDataReport07();
        $numFila        =   2;     
        foreach ($contenido as $keyNumber => $row) 
        {
            $numFila++;
            $reporteExcel->getActiveSheet()
                ->setCellValue('B'.$numFila, $keyNumber+1)
                ->setCellValue('C'.$numFila, $row->compromiso)
                ->setCellValue('D'.$numFila, $row->nombre)
                ->setCellValue('E'.$numFila, $row->responsable)
                ->setCellValue('F'.$numFila, $row->resultados)
                ;
            #Añado un borde para el contenido
            $reporteExcel->getActiveSheet()->getStyle('B'.($numFila).':F'.($numFila))->getBorders()->getTop()->applyFromArray(
                [
                    'borderStyle'   =>  Border::BORDER_DASHDOT,
                    'color'         =>  [
                        'rgb'   =>  '808080'
                    ]
                ]
            );
        }      
        #10. Defino el ancho de las columnas 
        $reporteExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $reporteExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $reporteExcel->getActiveSheet()->getColumnDimension('F')->setWidth(50);
       
        #11. Defino los estilos de la estructura Excel
        $reporteExcel->getActiveSheet()->mergeCells('B1:F1');
        $reporteExcel->getActiveSheet()->getStyle('B1:F1')->applyFromArray($tituloPrincipal);
        $reporteExcel->getActiveSheet()->getStyle('B2:F2')->applyFromArray($cabecera);            
        $reporteExcel->getActiveSheet()->getStyle('B3:F'.$numFila)->applyFromArray($body);        

        #12. Defino el titulo de la pestaña activa
        $reporteExcel->getActiveSheet()->setTitle('Compromisos Condorcanqui');
        
        #13. Insumos requeridos para la generación del documento
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$namefile\"");
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public');
        
        #14. Genero el archivo requerido
        $writer     =   IOFactory::createWriter($reporteExcel, 'Xlsx');
        $writer->save('php://output');
        exit;        
    }

    #10. Obtengo la información de compromisos Moquegua
    public function exportaReport08()
    {
        #1. Definimos los estilos del documento a exportar
        $tituloPrincipal = [
		    'font'	=>	[
		    			'size'			=>	18,
						'bold' 			=> TRUE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> 'ffffff'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_THIN],
		                'left' 		=> ['borderStyle' => Border::BORDER_THIN],
		                'right' 	=> ['borderStyle' => Border::BORDER_THIN],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_THIN],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => '354049'],
		            ],
		];
		$cabecera = [
		    'font'	=>	[
		    			'size'			=>	10,
						'bold' 			=> TRUE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> 'ffffff'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'left' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'right' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => '354049'],
		            ],
        ];
        $body 	= [
		    'font'	=>	[
		    			'size'			=>	8,
						'bold' 			=> FALSE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> '000000'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'left' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'right' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => 'FFFFFF'],
		            ],
        ];     
        $numerico  = [
		    'formatCode' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
        $justificado 	= [
		    'font'	=>	[
		    			'size'			=>	8,
						'bold' 			=> FALSE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> '000000'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => 'FFFFFF'],
		            ],
        ];
        #2. Llamamos a la clase
        $reporteExcel   =   new Spreadsheet();
        #3. Creamos el nombre del archivo
        $namefile       =   "Consolidado_Matriz_Compromisos_".Carbon::now().".xlsx";
        #4. Generamos el título del Reporte
        $tituloReporte  =   "Compromisos asumidos en la Mesa de Diálogo para analizar la problemática minera del Departamento de Moquegua";
        #6. Genero la metadata del archivo
        $reporteExcel->getProperties()->setCreator('Oscar Javier Pazos M.')
            ->setLastModifiedBy('Oscar Javier Pazos M.')
            ->setTitle('Office 2007 XLSX Text Document')
            ->setSubject('Office 2007 XLSX Text Document')
            ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
            ->setKeywords('Office 2007 openxml php')
            ->setCategory('Test result file');
        #7. Indico el numero de pestaña donde se iniciará el documento
        $reporteExcel->setActiveSheetIndex(0);
        #8. Genero los títulos
        $reporteExcel->getActiveSheet()
            ->setCellValue('B1', $tituloReporte)
            ->setCellValue('B2', 'Nº')
            ->setCellValue('C2', 'COMPROMISO')
            ->setCellValue('D2', 'RESPONSABLES')
            ->setCellValue('E2', 'AVANCES')
            ;     
        #9. Genero el contenido de la tabla       
        $contenido      =   Evento::getDataReport08();
        $numFila        =   2;     
        foreach ($contenido as $keyNumber => $row) 
        {
            $numFila++;
            $reporteExcel->getActiveSheet()
                ->setCellValue('B'.$numFila, $keyNumber+1)
                ->setCellValue('C'.$numFila, $row->compromiso)
                ->setCellValue('D'.$numFila, $row->responsable)
                ->setCellValue('E'.$numFila, $row->resultados)
                ;
            #Añado un borde para el contenido
            $reporteExcel->getActiveSheet()->getStyle('B'.($numFila).':E'.($numFila))->getBorders()->getTop()->applyFromArray(
                [
                    'borderStyle'   =>  Border::BORDER_DASHDOT,
                    'color'         =>  [
                        'rgb'   =>  '808080'
                    ]
                ]
            );
        }      
        #10. Defino el ancho de las columnas 
        $reporteExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $reporteExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
       
        #11. Defino los estilos de la estructura Excel
        $reporteExcel->getActiveSheet()->mergeCells('B1:E1');
        $reporteExcel->getActiveSheet()->getStyle('B1:E1')->applyFromArray($tituloPrincipal);
        $reporteExcel->getActiveSheet()->getStyle('B2:E2')->applyFromArray($cabecera);            
        $reporteExcel->getActiveSheet()->getStyle('B3:E'.$numFila)->applyFromArray($body);        

        #12. Defino el titulo de la pestaña activa
        $reporteExcel->getActiveSheet()->setTitle('Compromisos Moquegua');
        
        #13. Insumos requeridos para la generación del documento
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$namefile\"");
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public');
        
        #14. Genero el archivo requerido
        $writer     =   IOFactory::createWriter($reporteExcel, 'Xlsx');
        $writer->save('php://output');
        exit;        
    }

    #11. Obtengo la información de compromisos Olmos
    public function exportaReport09()
    {
        #1. Definimos los estilos del documento a exportar
        $tituloPrincipal = [
		    'font'	=>	[
		    			'size'			=>	18,
						'bold' 			=> TRUE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> 'ffffff'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_THIN],
		                'left' 		=> ['borderStyle' => Border::BORDER_THIN],
		                'right' 	=> ['borderStyle' => Border::BORDER_THIN],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_THIN],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => '354049'],
		            ],
		];
		$cabecera = [
		    'font'	=>	[
		    			'size'			=>	10,
						'bold' 			=> TRUE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> 'ffffff'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'left' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'right' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => '354049'],
		            ],
        ];
        $body 	= [
		    'font'	=>	[
		    			'size'			=>	8,
						'bold' 			=> FALSE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> '000000'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'left' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'right' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => 'FFFFFF'],
		            ],
        ];     
        $numerico  = [
		    'formatCode' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
        $justificado 	= [
		    'font'	=>	[
		    			'size'			=>	8,
						'bold' 			=> FALSE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> '000000'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => 'FFFFFF'],
		            ],
        ];
        #2. Llamamos a la clase
        $reporteExcel   =   new Spreadsheet();
        #3. Creamos el nombre del archivo
        $namefile       =   "Consolidado_Matriz_Compromisos_".Carbon::now().".xlsx";
        #4. Generamos el título del Reporte
        $tituloReporte  =   "MATRIZ DE COMPROMISOS MINISTERIO DE AGRICULTURA Y RIEGO";
        #6. Genero la metadata del archivo
        $reporteExcel->getProperties()->setCreator('Oscar Javier Pazos M.')
            ->setLastModifiedBy('Oscar Javier Pazos M.')
            ->setTitle('Office 2007 XLSX Text Document')
            ->setSubject('Office 2007 XLSX Text Document')
            ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
            ->setKeywords('Office 2007 openxml php')
            ->setCategory('Test result file');
        #7. Indico el numero de pestaña donde se iniciará el documento
        $reporteExcel->setActiveSheetIndex(0);
        #8. Genero los títulos
        $reporteExcel->getActiveSheet()
            ->setCellValue('A1', $tituloReporte)
            ->setCellValue('A2', 'ITEM')
            ->setCellValue('B2', 'UBICACIÓN')
            ->setCellValue('E2', 'AMBITOS')
            ->setCellValue('F2', 'NOMBRE DEL ESPACIO DE DIÁLOGO')
            ->setCellValue('G2', 'NOMBRE PROYECTO / ACTIVIDAD')
            ->setCellValue('H2', 'FECHA ACTA DEL COMPROMISO')
            ->setCellValue('I2', 'RESPONSABLE PROYECTOS')
            ->setCellValue('K2', 'FASE  DEL PROYECTO DE INVERSION')
            ->setCellValue('L2', 'CÓDIGO SNIP')
            ->setCellValue('M2', 'CÓDIGO UNIFICADO')
            ->setCellValue('N2', 'COSTO ESTIMADO')
            ->setCellValue('O2', 'PROGRAMACIÓN MULTIANUAL MINAGRI')
            ->setCellValue('Q2', 'ESTADO SITUACIONAL')
            ->setCellValue('R2', 'EVIDENCIA DE LA GESTIÓN REALIZADA (OFICIOS, DOCUMENTOS, INFORMES, ETC.)')
            ->setCellValue('S2', 'COMENTARIO Y OBSERVACIONES')
            ->setCellValue('T2', 'ESTADO DEL COMPROMISO')
            ->setCellValue('U2', 'RESPONSABLES')
            ->setCellValue('B3', 'REGIÓN')
            ->setCellValue('C3', 'PROVINCIA')
            ->setCellValue('D3', 'DISTRITO')
            ->setCellValue('I3', 'UNIDAD FORMULADORA')
            ->setCellValue('J3', 'UNIDAD EJECUTORA')
            ->setCellValue('O3', '2020')
            ->setCellValue('P3', '2021')
            ;     
        #9. Genero el contenido de la tabla        
        $contenido      =   Evento::getDataReport09();
        $numFila        =   3;     
        foreach ($contenido as $keyNumber => $row) 
        {
            $numFila++;
            $reporteExcel->getActiveSheet()
                ->setCellValue('A'.$numFila, $keyNumber+1)
                ->setCellValue('B'.$numFila, $row->region)
                ->setCellValue('C'.$numFila, $row->provincia)
                ->setCellValue('D'.$numFila, $row->distrito)
                ->setCellValue('E'.$numFila, 'Olmos')
                ->setCellValue('F'.$numFila, $row->nombre)
                ->setCellValue('G'.$numFila, $row->compromiso)
                ->setCellValue('H'.$numFila, $row->fecha)
                ->setCellValue('I'.$numFila, $row->responsable)
                ->setCellValue('J'.$numFila, '-')
                ->setCellValue('K'.$numFila, '-')
                ->setCellValue('L'.$numFila, '-')
                ->setCellValue('M'.$numFila, '-')
                ->setCellValue('N'.$numFila, $row->inversion)
                ->setCellValue('O'.$numFila, '-')
                ->setCellValue('P'.$numFila, '-')
                ->setCellValue('Q'.$numFila, $row->situacion)
                ->setCellValue('R'.$numFila, '-')
                ->setCellValue('S'.$numFila, '-')
                ->setCellValue('T'.$numFila, $row->resultados)
                ->setCellValue('U'.$numFila, $row->responsable)
                ;
            #Añado un borde para el contenido
            $reporteExcel->getActiveSheet()->getStyle('B'.($numFila).':U'.($numFila))->getBorders()->getTop()->applyFromArray(
                [
                    'borderStyle'   =>  Border::BORDER_DASHDOT,
                    'color'         =>  [
                        'rgb'   =>  '808080'
                    ]
                ]
            );
        }        
        #10. Defino el ancho de las columnas 
        $reporteExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $reporteExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('F')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('G')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('H')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('I')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('J')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('K')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('L')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('M')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('N')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('O')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('P')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('R')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('S')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('T')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('U')->setWidth(50);

        #11. Defino los estilos de la estructura Excel
        $reporteExcel->getActiveSheet()->mergeCells('A1:U1');
        $reporteExcel->getActiveSheet()->mergeCells('A2:A3');
        $reporteExcel->getActiveSheet()->mergeCells('B2:D2');
        $reporteExcel->getActiveSheet()->mergeCells('E2:E3');
        $reporteExcel->getActiveSheet()->mergeCells('F2:F3');
        $reporteExcel->getActiveSheet()->mergeCells('G2:G3');
        $reporteExcel->getActiveSheet()->mergeCells('H2:H3');
        $reporteExcel->getActiveSheet()->mergeCells('I2:J2');
        $reporteExcel->getActiveSheet()->mergeCells('K2:K3');
        $reporteExcel->getActiveSheet()->mergeCells('L2:L3');
        $reporteExcel->getActiveSheet()->mergeCells('M2:M3');
        $reporteExcel->getActiveSheet()->mergeCells('N2:N3');
        $reporteExcel->getActiveSheet()->mergeCells('O2:P2');
        $reporteExcel->getActiveSheet()->mergeCells('Q2:Q3');
        $reporteExcel->getActiveSheet()->mergeCells('R2:R3');
        $reporteExcel->getActiveSheet()->mergeCells('S2:S3');
        $reporteExcel->getActiveSheet()->mergeCells('T2:T3');
        $reporteExcel->getActiveSheet()->mergeCells('U2:U3');

        $reporteExcel->getActiveSheet()->getStyle('A1:U1')->applyFromArray($tituloPrincipal);
        $reporteExcel->getActiveSheet()->getStyle('A2:U3')->applyFromArray($cabecera);            
        $reporteExcel->getActiveSheet()->getStyle('A4:U'.$numFila)->applyFromArray($body);        

        #12. Defino el titulo de la pestaña activa
        $reporteExcel->getActiveSheet()->setTitle('Compromisos Olmos');        

        #13. Insumos requeridos para la generación del documento
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$namefile\"");
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public');
        
        #14. Genero el archivo requerido
        $writer     =   IOFactory::createWriter($reporteExcel, 'Xlsx');
        $writer->save('php://output');
        exit;    

    }

    #12. Compromisos San Martin
    public function exportaReport10()
    {
        #1. Definimos los estilos del documento a exportar
        $tituloPrincipal = [
		    'font'	=>	[
		    			'size'			=>	18,
						'bold' 			=> TRUE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> 'ffffff'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_THIN],
		                'left' 		=> ['borderStyle' => Border::BORDER_THIN],
		                'right' 	=> ['borderStyle' => Border::BORDER_THIN],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_THIN],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => '354049'],
		            ],
		];
		$cabecera = [
		    'font'	=>	[
		    			'size'			=>	10,
						'bold' 			=> TRUE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> 'ffffff'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'left' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'right' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => '354049'],
		            ],
        ];
        $body 	= [
		    'font'	=>	[
		    			'size'			=>	8,
						'bold' 			=> FALSE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> '000000'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'left' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'right' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => 'FFFFFF'],
		            ],
        ];     
        $numerico  = [
		    'formatCode' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
        $justificado 	= [
		    'font'	=>	[
		    			'size'			=>	8,
						'bold' 			=> FALSE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> '000000'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => 'FFFFFF'],
		            ],
        ];
        #2. Llamamos a la clase
        $reporteExcel   =   new Spreadsheet();
        #3. Creamos el nombre del archivo
        $namefile       =   "Consolidado_Matriz_Compromisos_".Carbon::now().".xlsx";
        #4. Generamos el título del Reporte
        $tituloReporte  =   "ACUERDOS Y COMPROMISOS - SAN MARTIN";
        #6. Genero la metadata del archivo
        $reporteExcel->getProperties()->setCreator('Oscar Javier Pazos M.')
            ->setLastModifiedBy('Oscar Javier Pazos M.')
            ->setTitle('Office 2007 XLSX Text Document')
            ->setSubject('Office 2007 XLSX Text Document')
            ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
            ->setKeywords('Office 2007 openxml php')
            ->setCategory('Test result file');
        #7. Indico el numero de pestaña donde se iniciará el documento
        $reporteExcel->setActiveSheetIndex(0);
        #8. Genero los títulos
        $reporteExcel->getActiveSheet()
            ->setCellValue('B1', $tituloReporte)
            ->setCellValue('B2', 'Nº')
            ->setCellValue('C2', 'DEPARTAMENTO')
            ->setCellValue('D2', 'NOMBRE DE LA COMISIÓN')
            ->setCellValue('E2', 'COMPROMISO')
            ->setCellValue('F2', 'AVANCES')
            ->setCellValue('G2', 'COMENTARIOS')
            ;     
        #9. Genero el contenido de la tabla       
        $contenido      =   Evento::getDataReport10();
        $numFila        =   2;     
        foreach ($contenido as $keyNumber => $row) 
        {
            $numFila++;
            $reporteExcel->getActiveSheet()
                ->setCellValue('B'.$numFila, $keyNumber+1)
                ->setCellValue('C'.$numFila, $row->region)
                ->setCellValue('D'.$numFila, $row->nombre)
                ->setCellValue('E'.$numFila, $row->compromiso)
                ->setCellValue('F'.$numFila, $row->resultados)
                ->setCellValue('G'.$numFila, $row->observaciones)
                ;
            #Añado un borde para el contenido
            $reporteExcel->getActiveSheet()->getStyle('B'.($numFila).':G'.($numFila))->getBorders()->getTop()->applyFromArray(
                [
                    'borderStyle'   =>  Border::BORDER_DASHDOT,
                    'color'         =>  [
                        'rgb'   =>  '808080'
                    ]
                ]
            );
        }      
        #10. Defino el ancho de las columnas 
        $reporteExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $reporteExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('F')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('G')->setWidth(50);
       
        #11. Defino los estilos de la estructura Excel
        $reporteExcel->getActiveSheet()->mergeCells('B1:G1');
        $reporteExcel->getActiveSheet()->getStyle('B1:G1')->applyFromArray($tituloPrincipal);
        $reporteExcel->getActiveSheet()->getStyle('B2:G2')->applyFromArray($cabecera);            
        $reporteExcel->getActiveSheet()->getStyle('B3:G'.$numFila)->applyFromArray($body);        

        #12. Defino el titulo de la pestaña activa
        $reporteExcel->getActiveSheet()->setTitle('Compromisos San martin');
        
        #13. Insumos requeridos para la generación del documento
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$namefile\"");
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public');
        
        #14. Genero el archivo requerido
        $writer     =   IOFactory::createWriter($reporteExcel, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    #13. Compromisos alto amazonas
    public function exportaReport11()
    {
        #1. Definimos los estilos del documento a exportar
        $tituloPrincipal = [
		    'font'	=>	[
		    			'size'			=>	18,
						'bold' 			=> TRUE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> 'ffffff'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_THIN],
		                'left' 		=> ['borderStyle' => Border::BORDER_THIN],
		                'right' 	=> ['borderStyle' => Border::BORDER_THIN],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_THIN],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => '354049'],
		            ],
		];
		$cabecera = [
		    'font'	=>	[
		    			'size'			=>	10,
						'bold' 			=> TRUE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> 'ffffff'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'left' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'right' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => '354049'],
		            ],
        ];
        $body 	= [
		    'font'	=>	[
		    			'size'			=>	8,
						'bold' 			=> FALSE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> '000000'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'left' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'right' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => 'FFFFFF'],
		            ],
        ];     
        $numerico  = [
		    'formatCode' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
        $justificado 	= [
		    'font'	=>	[
		    			'size'			=>	8,
						'bold' 			=> FALSE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> '000000'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => 'FFFFFF'],
		            ],
        ];
        #2. Llamamos a la clase
        $reporteExcel   =   new Spreadsheet();
        #3. Creamos el nombre del archivo
        $namefile       =   "Consolidado_Matriz_Compromisos_".Carbon::now().".xlsx";
        #4. Generamos el título del Reporte
        $tituloReporte  =   "AVANCES EN LAS ACTIVIDADES REALIZADAS POR SU ENTIDAD EN EL MARCO DE LA MESA TECNICA AGRARIA PARA DESARROLLO DE ALTO AMAZONAS";
        #6. Genero la metadata del archivo
        $reporteExcel->getProperties()->setCreator('Oscar Javier Pazos M.')
            ->setLastModifiedBy('Oscar Javier Pazos M.')
            ->setTitle('Office 2007 XLSX Text Document')
            ->setSubject('Office 2007 XLSX Text Document')
            ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
            ->setKeywords('Office 2007 openxml php')
            ->setCategory('Test result file');
        #7. Indico el numero de pestaña donde se iniciará el documento
        $reporteExcel->setActiveSheetIndex(0);
        #8. Genero los títulos
        $reporteExcel->getActiveSheet()
            ->setCellValue('A1', $tituloReporte)
            ->setCellValue('A2', 'TEMA')
            ->setCellValue('B2', 'GRANDES TEMAS')
            ->setCellValue('C2', 'Nº')
            ->setCellValue('D2', 'PROPUESTAS')
            ->setCellValue('E2', 'ACTIVIDADES')
            ->setCellValue('F2', 'RESPONSABLE')
            ->setCellValue('G2', 'ESTADO')
            ->setCellValue('H2', 'AVANCES A LAS ACTIVIDADES')
            ;     
        #9. Genero el contenido de la tabla       
        $contenido      =   Evento::getDataReport11();
        $numFila        =   2;     
        foreach ($contenido as $keyNumber => $row) 
        {
            $numFila++;
            $reporteExcel->getActiveSheet()
                ->setCellValue('A'.$numFila, 'T4')
                ->setCellValue('B'.$numFila, 'INSTITUCIONALIZACIÓN')
                ->setCellValue('C'.$numFila, $keyNumber+1)
                ->setCellValue('D'.$numFila, $row->compromiso)
                ->setCellValue('E'.$numFila, '-')
                ->setCellValue('F'.$numFila, 'MINAGRI (AGROIDEAS)')
                ->setCellValue('G'.$numFila, $row->situacion)
                ->setCellValue('H'.$numFila, $row->resultados)
                ;
            #Añado un borde para el contenido
            $reporteExcel->getActiveSheet()->getStyle('A'.($numFila).':H'.($numFila))->getBorders()->getTop()->applyFromArray(
                [
                    'borderStyle'   =>  Border::BORDER_DASHDOT,
                    'color'         =>  [
                        'rgb'   =>  '808080'
                    ]
                ]
            );
        }      
        #10. Defino el ancho de las columnas 
        $reporteExcel->getActiveSheet()->getColumnDimension('A')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
        $reporteExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('F')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('G')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('H')->setWidth(50);
       
        #11. Defino los estilos de la estructura Excel
        $reporteExcel->getActiveSheet()->mergeCells('A1:H1');
        $reporteExcel->getActiveSheet()->getStyle('A1:H1')->applyFromArray($tituloPrincipal);
        $reporteExcel->getActiveSheet()->getStyle('A2:H2')->applyFromArray($cabecera);            
        $reporteExcel->getActiveSheet()->getStyle('A3:H'.$numFila)->applyFromArray($body);        

        #12. Defino el titulo de la pestaña activa
        $reporteExcel->getActiveSheet()->setTitle('Compromisos Alto amazonas');
        
        #13. Insumos requeridos para la generación del documento
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$namefile\"");
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public');
        
        #14. Genero el archivo requerido
        $writer     =   IOFactory::createWriter($reporteExcel, 'Xlsx');
        $writer->save('php://output');
        exit;
    }    

    #14. Compromisos quellaveco
    public function exportaReport12()
    {
        #1. Definimos los estilos del documento a exportar
        $tituloPrincipal = [
		    'font'	=>	[
		    			'size'			=>	16,
						'bold' 			=> TRUE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> 'ffffff'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_THIN],
		                'left' 		=> ['borderStyle' => Border::BORDER_THIN],
		                'right' 	=> ['borderStyle' => Border::BORDER_THIN],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_THIN],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => '354049'],
		            ],
		];
		$cabecera = [
		    'font'	=>	[
		    			'size'			=>	10,
						'bold' 			=> TRUE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> 'ffffff'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'left' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'right' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => '354049'],
		            ],
        ];
        $body 	= [
		    'font'	=>	[
		    			'size'			=>	8,
						'bold' 			=> FALSE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> '000000'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'left' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'right' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => 'FFFFFF'],
		            ],
        ];     
        $numerico  = [
		    'formatCode' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
        $justificado 	= [
		    'font'	=>	[
		    			'size'			=>	8,
						'bold' 			=> FALSE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> '000000'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => 'FFFFFF'],
		            ],
        ];
        #2. Llamamos a la clase
        $reporteExcel   =   new Spreadsheet();
        #3. Creamos el nombre del archivo
        $namefile       =   "Consolidado_Matriz_Compromisos_".Carbon::now().".xlsx";
        #4. Generamos el título del Reporte
        $tituloReporte  =   "Compromisos asumidos en la Mesa de Diálogo para analizar la problemática minera del Departamento de Moquegua";
        #6. Genero la metadata del archivo
        $reporteExcel->getProperties()->setCreator('Oscar Javier Pazos M.')
            ->setLastModifiedBy('Oscar Javier Pazos M.')
            ->setTitle('Office 2007 XLSX Text Document')
            ->setSubject('Office 2007 XLSX Text Document')
            ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
            ->setKeywords('Office 2007 openxml php')
            ->setCategory('Test result file');
        #7. Indico el numero de pestaña donde se iniciará el documento
        $reporteExcel->setActiveSheetIndex(0);
        #8. Genero los títulos
        $reporteExcel->getActiveSheet()
            ->setCellValue('B1', $tituloReporte)
            ->setCellValue('B2', 'MINISTERIO DE AGRICULTURA')
            ->setCellValue('B3', 'Nº')
            ->setCellValue('C3', 'COMPROMISOS')
            ->setCellValue('D3', 'RESPONSABLE')
            ->setCellValue('E3', 'ACCIONES')
            ;     
        #9. Genero el contenido de la tabla       
        $contenido      =   Evento::getDataReport12();
        $numFila        =   3;     
        foreach ($contenido as $keyNumber => $row) 
        {
            $numFila++;
            $reporteExcel->getActiveSheet()
                ->setCellValue('B'.$numFila, $keyNumber+1)
                ->setCellValue('C'.$numFila, $row->compromiso)
                ->setCellValue('D'.$numFila, $row->responsable)
                ->setCellValue('E'.$numFila, $row->resultados)
                ;
            #Añado un borde para el contenido
            $reporteExcel->getActiveSheet()->getStyle('B'.($numFila).':E'.($numFila))->getBorders()->getTop()->applyFromArray(
                [
                    'borderStyle'   =>  Border::BORDER_DASHDOT,
                    'color'         =>  [
                        'rgb'   =>  '808080'
                    ]
                ]
            );
        }      
        #10. Defino el ancho de las columnas 
        $reporteExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $reporteExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
       
        #11. Defino los estilos de la estructura Excel
        $reporteExcel->getActiveSheet()->mergeCells('B1:E1');
        $reporteExcel->getActiveSheet()->mergeCells('B2:E2');
        $reporteExcel->getActiveSheet()->getStyle('B1:E1')->applyFromArray($tituloPrincipal);
        $reporteExcel->getActiveSheet()->getStyle('B2:E3')->applyFromArray($cabecera);            
        $reporteExcel->getActiveSheet()->getStyle('B4:E'.$numFila)->applyFromArray($body);        

        #12. Defino el titulo de la pestaña activa
        $reporteExcel->getActiveSheet()->setTitle('Compromisos Quellaveco');
        
        #13. Insumos requeridos para la generación del documento
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$namefile\"");
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public');
        
        #14. Genero el archivo requerido
        $writer     =   IOFactory::createWriter($reporteExcel, 'Xlsx');
        $writer->save('php://output');
        exit;
    } 

    #15. Compromisos Hidrovía amazonica
    public function exportaReport13()
    {
        #1. Definimos los estilos del documento a exportar
        $tituloPrincipal = [
		    'font'	=>	[
		    			'size'			=>	16,
						'bold' 			=> TRUE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> 'ffffff'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_THIN],
		                'left' 		=> ['borderStyle' => Border::BORDER_THIN],
		                'right' 	=> ['borderStyle' => Border::BORDER_THIN],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_THIN],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => '354049'],
		            ],
		];
		$cabecera = [
		    'font'	=>	[
		    			'size'			=>	10,
						'bold' 			=> TRUE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> 'ffffff'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'left' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'right' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => '354049'],
		            ],
        ];
        $body 	= [
		    'font'	=>	[
		    			'size'			=>	8,
						'bold' 			=> FALSE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> '000000'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'left' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'right' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => 'FFFFFF'],
		            ],
        ];     
        $numerico  = [
		    'formatCode' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
        $justificado 	= [
		    'font'	=>	[
		    			'size'			=>	8,
						'bold' 			=> FALSE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> '000000'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => 'FFFFFF'],
		            ],
        ];
        #2. Llamamos a la clase
        $reporteExcel   =   new Spreadsheet();
        #3. Creamos el nombre del archivo
        $namefile       =   "Consolidado_Matriz_Compromisos_".Carbon::now().".xlsx";
        #4. Generamos el título del Reporte
        $tituloReporte  =   "Compromisos Hidrovía Amazónica";
        #6. Genero la metadata del archivo
        $reporteExcel->getProperties()->setCreator('Oscar Javier Pazos M.')
            ->setLastModifiedBy('Oscar Javier Pazos M.')
            ->setTitle('Office 2007 XLSX Text Document')
            ->setSubject('Office 2007 XLSX Text Document')
            ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
            ->setKeywords('Office 2007 openxml php')
            ->setCategory('Test result file');
        #7. Indico el numero de pestaña donde se iniciará el documento
        $reporteExcel->setActiveSheetIndex(0);
        #8. Genero los títulos
        $reporteExcel->getActiveSheet()
            ->setCellValue('A1', $tituloReporte)
            ->setCellValue('A2', 'Nº')
            ->setCellValue('B2', 'PROYECTO/ACTIVIDAD')
            ->setCellValue('C2', 'ESTADO')
            ->setCellValue('D2', 'CUENCA')
            ->setCellValue('E2', 'DISTRITO')
            ->setCellValue('F2', 'PROVINCIA')
            ->setCellValue('G2', 'REGIÓN')
            ->setCellValue('H2', 'COMUNIDAD')
            ->setCellValue('I2', 'PEDIDO')
            ->setCellValue('J2', 'ENTIDAD COMPETENTE')
            ->setCellValue('K2', 'COMPROMISO')
            ->setCellValue('L2', 'ORGANO RESPONSABLE')
            ->setCellValue('M2', 'COMENTARIOS DEL ESTADO')
            ->setCellValue('N2', 'ESTADO')
            ->setCellValue('O2', 'CRUCE CON OTRAS MESAS DE DIÁLOGO')
            ;     
        #9. Genero el contenido de la tabla       
        $contenido      =   Evento::getDataReport13();
        $numFila        =   2;     
        foreach ($contenido as $keyNumber => $row) 
        {
            $numFila++;
            $reporteExcel->getActiveSheet()
                ->setCellValue('A'.$numFila, $keyNumber+1)
                ->setCellValue('B'.$numFila, $row->etapa)
                ->setCellValue('C'.$numFila, $row->situacion)
                ->setCellValue('D'.$numFila, '-')
                ->setCellValue('E'.$numFila, $row->distrito)
                ->setCellValue('F'.$numFila, $row->provincia)
                ->setCellValue('G'.$numFila, $row->region)
                ->setCellValue('H'.$numFila, '-')
                ->setCellValue('I'.$numFila, '-')
                ->setCellValue('J'.$numFila, 'MINAGRI')
                ->setCellValue('K'.$numFila, $row->compromiso)
                ->setCellValue('L'.$numFila, 'Programa AGROIDEAS')
                ->setCellValue('M'.$numFila, $row->resultados)
                ->setCellValue('N'.$numFila, $row->situacion)
                ->setCellValue('O'.$numFila, '-')
                ;
            #Añado un borde para el contenido
            $reporteExcel->getActiveSheet()->getStyle('A'.($numFila).':O'.($numFila))->getBorders()->getTop()->applyFromArray(
                [
                    'borderStyle'   =>  Border::BORDER_DASHDOT,
                    'color'         =>  [
                        'rgb'   =>  '808080'
                    ]
                ]
            );
        }      
        #10. Defino el ancho de las columnas 
        $reporteExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $reporteExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('F')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('G')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('H')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('I')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('J')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('K')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('L')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('M')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('N')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('O')->setWidth(50);

       
        #11. Defino los estilos de la estructura Excel
        $reporteExcel->getActiveSheet()->mergeCells('A1:O1');
        $reporteExcel->getActiveSheet()->getStyle('A1:O1')->applyFromArray($tituloPrincipal);
        $reporteExcel->getActiveSheet()->getStyle('A2:O2')->applyFromArray($cabecera);            
        $reporteExcel->getActiveSheet()->getStyle('A3:O'.$numFila)->applyFromArray($body);        

        #12. Defino el titulo de la pestaña activa
        $reporteExcel->getActiveSheet()->setTitle('Hidrovía Amazónica');
        
        #13. Insumos requeridos para la generación del documento
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$namefile\"");
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public');
        
        #14. Genero el archivo requerido
        $writer     =   IOFactory::createWriter($reporteExcel, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    #14. Compromisos quellaveco
    public function exportaReport14()
    {
        #1. Definimos los estilos del documento a exportar
        $tituloPrincipal = [
		    'font'	=>	[
		    			'size'			=>	16,
						'bold' 			=> TRUE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> 'ffffff'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_THIN],
		                'left' 		=> ['borderStyle' => Border::BORDER_THIN],
		                'right' 	=> ['borderStyle' => Border::BORDER_THIN],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_THIN],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => '354049'],
		            ],
		];
		$cabecera = [
		    'font'	=>	[
		    			'size'			=>	10,
						'bold' 			=> TRUE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> 'ffffff'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'left' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'right' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => '354049'],
		            ],
        ];
        $body 	= [
		    'font'	=>	[
		    			'size'			=>	8,
						'bold' 			=> FALSE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> '000000'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'left' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'right' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => 'FFFFFF'],
		            ],
        ];     
        $numerico  = [
		    'formatCode' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
        $justificado 	= [
		    'font'	=>	[
		    			'size'			=>	8,
						'bold' 			=> FALSE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> '000000'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => 'FFFFFF'],
		            ],
        ];
        #2. Llamamos a la clase
        $reporteExcel   =   new Spreadsheet();
        #3. Creamos el nombre del archivo
        $namefile       =   "Consolidado_Matriz_Compromisos_".Carbon::now().".xlsx";
        #4. Generamos el título del Reporte
        $tituloReporte  =   "AVANCES DE COMPROMISOS ASUMIDOS EN MESAS DE DIÁLOGO ";
        #6. Genero la metadata del archivo
        $reporteExcel->getProperties()->setCreator('Oscar Javier Pazos M.')
            ->setLastModifiedBy('Oscar Javier Pazos M.')
            ->setTitle('Office 2007 XLSX Text Document')
            ->setSubject('Office 2007 XLSX Text Document')
            ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
            ->setKeywords('Office 2007 openxml php')
            ->setCategory('Test result file');
        #7. Indico el numero de pestaña donde se iniciará el documento
        $reporteExcel->setActiveSheetIndex(0);
        #8. Genero los títulos
        $reporteExcel->getActiveSheet()
            ->setCellValue('B1', $tituloReporte)
            ->setCellValue('B2', 'DEPARTAMENTO')
            ->setCellValue('C2', 'NOMBRE DE LA COMISIÓN')
            ->setCellValue('D2', 'COMPROMISO')
            ->setCellValue('E2', 'AVANCES')
            ->setCellValue('F2', 'EVIDENCIA DE AVANCES')
            ;     
        #9. Genero el contenido de la tabla       
        $contenido      =   Evento::getDataReport14();
        $numFila        =   2;     
        foreach ($contenido as $keyNumber => $row) 
        {
            $numFila++;
            $reporteExcel->getActiveSheet()
                ->setCellValue('B'.$numFila, $row->region)
                ->setCellValue('C'.$numFila, $row->nombre)
                ->setCellValue('D'.$numFila, $row->compromiso)
                ->setCellValue('E'.$numFila, $row->resultados)
                ->setCellValue('F'.$numFila, '-')
                ;
            #Añado un borde para el contenido
            $reporteExcel->getActiveSheet()->getStyle('B'.($numFila).':F'.($numFila))->getBorders()->getTop()->applyFromArray(
                [
                    'borderStyle'   =>  Border::BORDER_DASHDOT,
                    'color'         =>  [
                        'rgb'   =>  '808080'
                    ]
                ]
            );
        }      
        #10. Defino el ancho de las columnas 
        $reporteExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $reporteExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('F')->setWidth(50);
       
        #11. Defino los estilos de la estructura Excel
        $reporteExcel->getActiveSheet()->mergeCells('B1:F1');
        $reporteExcel->getActiveSheet()->getStyle('B1:F1')->applyFromArray($tituloPrincipal);
        $reporteExcel->getActiveSheet()->getStyle('B2:F2')->applyFromArray($cabecera);            
        $reporteExcel->getActiveSheet()->getStyle('B3:F'.$numFila)->applyFromArray($body);        

        #12. Defino el titulo de la pestaña activa
        $reporteExcel->getActiveSheet()->setTitle('Compromisos Candarave');
        
        #13. Insumos requeridos para la generación del documento
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$namefile\"");
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public');
        
        #14. Genero el archivo requerido
        $writer     =   IOFactory::createWriter($reporteExcel, 'Xlsx');
        $writer->save('php://output');
        exit;
    } 

    #15. Obtengo la información de compromisos Olmos
    public function exportaReport15()
    {
        #1. Definimos los estilos del documento a exportar
        $tituloPrincipal = [
		    'font'	=>	[
		    			'size'			=>	18,
						'bold' 			=> TRUE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> 'ffffff'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_THIN],
		                'left' 		=> ['borderStyle' => Border::BORDER_THIN],
		                'right' 	=> ['borderStyle' => Border::BORDER_THIN],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_THIN],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => '354049'],
		            ],
		];
		$cabecera = [
		    'font'	=>	[
		    			'size'			=>	10,
						'bold' 			=> TRUE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> 'ffffff'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'left' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'right' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => '354049'],
		            ],
        ];
        $body 	= [
		    'font'	=>	[
		    			'size'			=>	8,
						'bold' 			=> FALSE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> '000000'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'borders' => [
		                'top' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'left' 		=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'right' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		                'bottom' 	=> ['borderStyle' => Border::BORDER_MEDIUM],
		            ],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => 'FFFFFF'],
		            ],
        ];     
        $numerico  = [
		    'formatCode' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
        $justificado 	= [
		    'font'	=>	[
		    			'size'			=>	8,
						'bold' 			=> FALSE,
						'italic' 		=> FALSE,
						'strikethrough' => FALSE,
						'color' 		=> [
											'rgb'	=> '000000'
										]
					],
		    'alignment' => [
				    	'vertical' 		=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
				        'horizontal' 	=> \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
				        'textRotation' 	=> 0,
				        'wrapText'     	=> TRUE
		    		],
		    'fill' 	=> [
		                'fillType' 	=> Fill::FILL_SOLID,
		                'color' 	=> ['rgb' => 'FFFFFF'],
		            ],
        ];
        #2. Llamamos a la clase
        $reporteExcel   =   new Spreadsheet();
        #3. Creamos el nombre del archivo
        $namefile       =   "Consolidado_Matriz_Compromisos_".Carbon::now().".xlsx";
        #4. Generamos el título del Reporte
        $tituloReporte  =   "MATRIZ DE COMPROMISOS MINISTERIO DE AGRICULTURA Y RIEGO";
        #6. Genero la metadata del archivo
        $reporteExcel->getProperties()->setCreator('Oscar Javier Pazos M.')
            ->setLastModifiedBy('Oscar Javier Pazos M.')
            ->setTitle('Office 2007 XLSX Text Document')
            ->setSubject('Office 2007 XLSX Text Document')
            ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
            ->setKeywords('Office 2007 openxml php')
            ->setCategory('Test result file');
        #7. Indico el numero de pestaña donde se iniciará el documento
        $reporteExcel->setActiveSheetIndex(0);
        #8. Genero los títulos
        $reporteExcel->getActiveSheet()
            ->setCellValue('A1', $tituloReporte)
            ->setCellValue('A2', 'ITEM')
            ->setCellValue('B2', 'UBICACIÓN')
            ->setCellValue('E2', 'AMBITOS')
            ->setCellValue('F2', 'NOMBRE DEL ESPACIO DE DIÁLOGO')
            ->setCellValue('G2', 'NOMBRE PROYECTO / ACTIVIDAD')
            ->setCellValue('H2', 'FECHA ACTA DEL COMPROMISO')
            ->setCellValue('I2', 'RESPONSABLE PROYECTOS')
            ->setCellValue('K2', 'FASE  DEL PROYECTO DE INVERSION')
            ->setCellValue('L2', 'CÓDIGO SNIP')
            ->setCellValue('M2', 'CÓDIGO UNIFICADO')
            ->setCellValue('N2', 'COSTO ESTIMADO')
            ->setCellValue('O2', 'PROGRAMACIÓN MULTIANUAL MINAGRI')
            ->setCellValue('Q2', 'ESTADO SITUACIONAL')
            ->setCellValue('R2', 'EVIDENCIA DE LA GESTIÓN REALIZADA (OFICIOS, DOCUMENTOS, INFORMES, ETC.)')
            ->setCellValue('S2', 'COMENTARIO Y OBSERVACIONES')
            ->setCellValue('T2', 'ESTADO DEL COMPROMISO')
            ->setCellValue('U2', 'RESPONSABLES')
            ->setCellValue('B3', 'REGIÓN')
            ->setCellValue('C3', 'PROVINCIA')
            ->setCellValue('D3', 'DISTRITO')
            ->setCellValue('I3', 'UNIDAD FORMULADORA')
            ->setCellValue('J3', 'UNIDAD EJECUTORA')
            ->setCellValue('O3', '2020')
            ->setCellValue('P3', '2021')
            ;     
        #9. Genero el contenido de la tabla        
        $contenido      =   Evento::getDataReport15();
        $numFila        =   3;     
        foreach ($contenido as $keyNumber => $row) 
        {
            $numFila++;
            $reporteExcel->getActiveSheet()
                ->setCellValue('A'.$numFila, $keyNumber+1)
                ->setCellValue('B'.$numFila, $row->region)
                ->setCellValue('C'.$numFila, $row->provincia)
                ->setCellValue('D'.$numFila, $row->distrito)
                ->setCellValue('E'.$numFila, 'VRAEM')
                ->setCellValue('F'.$numFila, $row->nombre)
                ->setCellValue('G'.$numFila, $row->compromiso)
                ->setCellValue('H'.$numFila, $row->fecha)
                ->setCellValue('I'.$numFila, $row->responsable)
                ->setCellValue('J'.$numFila, '-')
                ->setCellValue('K'.$numFila, '-')
                ->setCellValue('L'.$numFila, '-')
                ->setCellValue('M'.$numFila, '-')
                ->setCellValue('N'.$numFila, $row->inversion)
                ->setCellValue('O'.$numFila, '-')
                ->setCellValue('P'.$numFila, '-')
                ->setCellValue('Q'.$numFila, $row->situacion)
                ->setCellValue('R'.$numFila, '-')
                ->setCellValue('S'.$numFila, '-')
                ->setCellValue('T'.$numFila, $row->resultados)
                ->setCellValue('U'.$numFila, $row->responsable)
                ;
            #Añado un borde para el contenido
            $reporteExcel->getActiveSheet()->getStyle('B'.($numFila).':U'.($numFila))->getBorders()->getTop()->applyFromArray(
                [
                    'borderStyle'   =>  Border::BORDER_DASHDOT,
                    'color'         =>  [
                        'rgb'   =>  '808080'
                    ]
                ]
            );
        }        
        #10. Defino el ancho de las columnas 
        $reporteExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $reporteExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('F')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('G')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('H')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('I')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('J')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('K')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('L')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('M')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('N')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('O')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('P')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('R')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('S')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('T')->setWidth(50);
        $reporteExcel->getActiveSheet()->getColumnDimension('U')->setWidth(50);

        #11. Defino los estilos de la estructura Excel
        $reporteExcel->getActiveSheet()->mergeCells('A1:U1');
        $reporteExcel->getActiveSheet()->mergeCells('A2:A3');
        $reporteExcel->getActiveSheet()->mergeCells('B2:D2');
        $reporteExcel->getActiveSheet()->mergeCells('E2:E3');
        $reporteExcel->getActiveSheet()->mergeCells('F2:F3');
        $reporteExcel->getActiveSheet()->mergeCells('G2:G3');
        $reporteExcel->getActiveSheet()->mergeCells('H2:H3');
        $reporteExcel->getActiveSheet()->mergeCells('I2:J2');
        $reporteExcel->getActiveSheet()->mergeCells('K2:K3');
        $reporteExcel->getActiveSheet()->mergeCells('L2:L3');
        $reporteExcel->getActiveSheet()->mergeCells('M2:M3');
        $reporteExcel->getActiveSheet()->mergeCells('N2:N3');
        $reporteExcel->getActiveSheet()->mergeCells('O2:P2');
        $reporteExcel->getActiveSheet()->mergeCells('Q2:Q3');
        $reporteExcel->getActiveSheet()->mergeCells('R2:R3');
        $reporteExcel->getActiveSheet()->mergeCells('S2:S3');
        $reporteExcel->getActiveSheet()->mergeCells('T2:T3');
        $reporteExcel->getActiveSheet()->mergeCells('U2:U3');

        $reporteExcel->getActiveSheet()->getStyle('A1:U1')->applyFromArray($tituloPrincipal);
        $reporteExcel->getActiveSheet()->getStyle('A2:U3')->applyFromArray($cabecera);            
        $reporteExcel->getActiveSheet()->getStyle('A4:U'.$numFila)->applyFromArray($body);        

        #12. Defino el titulo de la pestaña activa
        $reporteExcel->getActiveSheet()->setTitle('Compromisos VRAEM');        

        #13. Insumos requeridos para la generación del documento
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$namefile\"");
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public');
        
        #14. Genero el archivo requerido
        $writer     =   IOFactory::createWriter($reporteExcel, 'Xlsx');
        $writer->save('php://output');
        exit;    
    }
}
