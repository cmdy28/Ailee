<?php
require_once "../../vendor/autoload.php";

# Nuestra base de datos
include '../conexion.php';
include '../../class/clientes/cliente.class.php';
$clientes = new Cliente();

//Librerias
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;

$documento = new Spreadsheet();
$documento
->getProperties()
->setCreator("Carolina Yuqui")
->setLastModifiedBy('Ailee')
->setTitle('Archivo generado desde Ailee')
->setDescription('Clientes exportados desde Ailee');

$hojaDeClientes = $documento->getActiveSheet();
$hojaDeClientes->setTitle("Clientes");

$documento->getDefaultStyle()->getFont()->setName('Roboto');
$hojaDeClientesMerge=$hojaDeClientes->mergeCells("A1:F1");
$hojaDeClientes->setCellValue('A1',"LISTA DE CLIENTES")->getStyle('A1')->getAlignment()->setHorizontal('center');
$documento->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(20)->getColor()->setRGB('82bf26');
$documento->getActiveSheet()->getStyle('A2:F2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('82bf26');

# Encabezado de los cedula
$encabezado = ["CLIENTE", "CÉDULA", "EMAIL", "TELÉFONO", "CELULAR", "DIRECCIÓN"];
# El último argumento es por defecto A1
$hojaDeClientes->fromArray($encabezado, null, 'A2')->getStyle('A2:F2')->getFont()->setBold(true)->setSize(12)->getColor()->setRGB('FFFFFF');

//trae todos los clientes 
$sentencia=$clientes->traerClientesExcel($gbd);
# Comenzamos en la fila 3
$numeroDeFila = 3;
while ($cliente = $sentencia->fetchObject()) {
# Obtener registros de MySQL
$nombre = $cliente->nombre;
$cedula = $cliente->cedula;
$email = $cliente->email;
$telefono = $cliente->telefono;
$celular = $cliente->celular;
$direccion = $cliente->direccion;
# Escribir registros en el documento
$hojaDeClientes->setCellValueByColumnAndRow(1, $numeroDeFila, $nombre)->getColumnDimension('A')->setAutoSize(true);
$hojaDeClientes->setCellValueByColumnAndRow(2, $numeroDeFila, $cedula)->getColumnDimension('B')->setAutoSize(true);
$hojaDeClientes->setCellValueByColumnAndRow(3, $numeroDeFila, $email)->getColumnDimension('C')->setAutoSize(true);
$hojaDeClientes->setCellValueByColumnAndRow(4, $numeroDeFila, $telefono)->getColumnDimension('D')->setAutoSize(true);
$hojaDeClientes->setCellValueByColumnAndRow(5, $numeroDeFila, $celular)->getColumnDimension('E')->setAutoSize(true);
$hojaDeClientes->setCellValueByColumnAndRow(6, $numeroDeFila, $direccion)->getColumnDimension('F')->setAutoSize(true);
$numeroDeFila++;
}

$fecha_actual = date('hmsYmd');
$fileName = "listaClientes$fecha_actual.xlsx";
# Crear un "escritor"
$writer = new Xlsx($documento);
#Guardamos
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
$writer->save('php://output');
?>