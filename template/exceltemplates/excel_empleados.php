<?php
require_once "../../vendor/autoload.php";

# Nuestra base de datos
include '../../class/conexion.php';
include '../../class/administrador/empleado.class.php';
$empleados = new Empleado();

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
->setDescription('Empleados exportados desde Ailee');

$hojaDeClientes = $documento->getActiveSheet();
$hojaDeClientes->setTitle("Empleados");

$documento->getDefaultStyle()->getFont()->setName('Roboto');
$hojaDeClientesMerge=$hojaDeClientes->mergeCells("A1:E1");
$hojaDeClientes->setCellValue('A1',"LISTA DE EMPLEADOS")->getStyle('A1')->getAlignment()->setHorizontal('center');
$documento->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(20)->getColor()->setRGB('82bf26');
$documento->getActiveSheet()->getStyle('A2:E2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('82bf26');

# Encabezado de los cedula
$encabezado = ["NOMBRE EMPLEADO", "CÉDULA", "EMAIL", "CELULAR", "DIRECCIÓN"];
# El último argumento es por defecto A1
$hojaDeClientes->fromArray($encabezado, null, 'A2')->getStyle('A2:E2')->getFont()->setBold(true)->setSize(12)->getColor()->setRGB('FFFFFF');

$sentencia=$empleados->traerEmpleadosExcel($gbd);
# Comenzamos en la fila 3
$numeroDeFila = 3;
while ($empleado = $sentencia->fetchObject()) {
# Obtener registros de MySQL
$nombre = $empleado->nombre;
$cedula = $empleado->cedula;
$email = $empleado->email;
$telefono = $empleado->telefono;
$direccion = $empleado->direccion;
# Escribir registros en el documento
$hojaDeClientes->setCellValueByColumnAndRow(1, $numeroDeFila, $nombre)->getColumnDimension('A')->setAutoSize(true);
$hojaDeClientes->setCellValueByColumnAndRow(2, $numeroDeFila, $cedula)->getColumnDimension('B')->setAutoSize(true);
$hojaDeClientes->setCellValueByColumnAndRow(3, $numeroDeFila, $email)->getColumnDimension('C')->setAutoSize(true);
$hojaDeClientes->setCellValueByColumnAndRow(4, $numeroDeFila, $telefono)->getColumnDimension('D')->setAutoSize(true);
$hojaDeClientes->setCellValueByColumnAndRow(5, $numeroDeFila, $direccion)->getColumnDimension('E')->setAutoSize(true);
$numeroDeFila++;
}

$fecha_actual = date('hmsYmd');
$fileName = "listaEmpleados$fecha_actual.xlsx";
# Crear un "escritor"
$writer = new Xlsx($documento);
#Guardamos
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
$writer->save('php://output');
?>