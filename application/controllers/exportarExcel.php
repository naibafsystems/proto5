<?php
ini_set('memory_limit', '512M');
//ini_set('memory_limit','-1');
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controlador para generar archivo Excel
 * @author oagarzond
 * @since 2016-06-08
 * @review 2016-06-08
 */
class ExportarExcel extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library("PHPExcel");
    }

    public function index() {

    }

    public function prueba() {
        $sheetId = 0;
        $this->phpexcel->createSheet(NULL, $sheetId);
        $this->phpexcel->setActiveSheetIndex($sheetId);
        $this->phpexcel->getActiveSheet()->setTitle("Excel de Prueba");
        $sheet = $this->phpexcel->getActiveSheet();
        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getColumnDimension('G')->setWidth(30);
        $styleArray = array('font' => array('bold' => true));
        $sheet->setCellValue('A3', 'Columna A3');
        $sheet->setCellValue('B3', 'Columna BB');
        $sheet->setCellValue('C3', 'Columna C3');
        $sheet->setCellValue('D3', 'Columna D3');
        $sheet->setCellValue('E3', 'Columna E3');
        $sheet->setCellValue('F3', 'Columna F3');
        $sheet->setCellValue('G3', 'Columna G3');
        $sheet->setCellValue('A4', 'Columna A4');
        $sheet->setCellValue('B4', 'Columna B4');
        $sheet->setCellValue('C4', 'Columna C4');
        $sheet->setCellValue('D4', 'Columna D4');
        $sheet->setCellValue('E4', 'Columna E4');
        $sheet->setCellValue('F4', 'Columna F4');
        $sheet->setCellValue('G4', 'Columna G4');
        $writer = new PHPExcel_Writer_Excel5($this->phpexcel);
        //header('Content-type: application/vnd.ms-excel');
        //$writer->save('php://output');
        //oagarzond - Para que se cargue uo diferente en IE se agrega un numero radicado al final del archivo - 2016-06-08
        $random = rand(100, 999);
        $writer->save(base_dir_tmp("prueba-" . $random . ".xls"));
        echo base_url_tmp("prueba-" . $random . ".xls");
    }

    public function cellColor($sheet, $cells, $color) {
        $sheet->getStyle($cells)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => $color
            )
        ));
    }

    public function pruebaHTML() {
        header('Content-type: application/vnd.ms-excel; charset=UTF-8');
        header("Content-Disposition: attachment; filename=excel.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        $html = '<h1>Mi primer reporte</h1>
        <p>Hemos creado nuestro reporte.</p>
        <table>
            <thead>
                <tr>
                    <th style="text-align:left;">Nombre</th>
                    <th style="text-align:left;">Apellido</th>
                    <th style="text-align:left;">Sexo</th>
                    <th style="text-align:left;">Nacimiento</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align:left;">Nombre</th>
                    <td style="text-align:left;">Apellido</th>
                    <td style="text-align:left;">Sexo</th>
                    <td style="text-align:left;">Nacimiento</th>
                </tr>
            </tbody>
        </table>';
        echo $html;
    }

}
// EOC
