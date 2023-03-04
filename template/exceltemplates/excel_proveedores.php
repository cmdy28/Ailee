<?php
require_once "../../vendor/autoload.php";

# Nuestra base de datos
include '../conexion.php';
include '../../class/provision/proveedor.class.php';

$proveedores = new Proveedor();

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
->setDescription('Proveedores exportados desde Ailee');

$hojaDeProveedores = $documento->getActiveSheet();
$hojaDeProveedores->setTitle("Proveedores");

$documento->getDefaultStyle()->getFont()->setName('Roboto');
$hojaDeProveedoresMerge=$hojaDeProveedores->mergeCells("A1:H1");
$hojaDeProveedores->setCellValue('A1',"LISTA DE PROVEEDORES")->getStyle('A1')->getAlignment()->setHorizontal('center');
$documento->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(20)->getColor()->setRGB('82bf26');
$documento->getActiveSheet()->getStyle('A2:H2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('82bf26');

# Encabezado de los cedula
$encabezado = ["NOMBRE COMERCIAL","CONTACTO", "RUC", "EMAIL", "TELÉFONO", "CELULAR", "DIRECCIÓN", "ESTADO"];
# El último argumento es por defecto A1
$hojaDeProveedores->fromArray($encabezado, null, 'A2')->getStyle('A2:H2')->getFont()->setBold(true)->setSize(12)->getColor()->setRGB('FFFFFF');

$sentencia=$proveedores->traerProveedoresExcel($gbd);
# Comenzamos en la fila 3
$numeroDeFila = 3;
while ($proveedor = $sentencia->fetchObject()) {
# Obtener registros de MySQL
$nombre = $proveedor->nombre_comercial;
$contacto = $proveedor->nombre_contacto;
$cedula = $proveedor->ruc;
$email = $proveedor->email;
$telefono = $proveedor->telefono;
$celular = $proveedor->celular;
$direccion = $proveedor->direccion;
$estado = $proveedor->estado;
# Escribir registros en el documento
$hojaDeProveedores->setCellValueByColumnAndRow(1, $numeroDeFila, $nombre)->getColumnDimension('A')->setAutoSize(true);
$hojaDeProveedores->setCellValueByColumnAndRow(2, $numeroDeFila, $contacto)->getColumnDimension('B')->setAutoSize(true);
$hojaDeProveedores->setCellValueByColumnAndRow(3, $numeroDeFila, $cedula)->getColumnDimension('C')->setAutoSize(true);
$hojaDeProveedores->setCellValueByColumnAndRow(4, $numeroDeFila, $email)->getColumnDimension('D')->setAutoSize(true);
$hojaDeProveedores->setCellValueByColumnAndRow(5, $numeroDeFila, $telefono)->getColumnDimension('E')->setAutoSize(true);
$hojaDeProveedores->setCellValueByColumnAndRow(6, $numeroDeFila, $celular)->getColumnDimension('F')->setAutoSize(true);
$hojaDeProveedores->setCellValueByColumnAndRow(7, $numeroDeFila, $direccion)->getColumnDimension('G')->setAutoSize(true);
$hojaDeProveedores->setCellValueByColumnAndRow(8, $numeroDeFila, $estado)->getColumnDimension('H')->setAutoSize(true);
$numeroDeFila++;
}

$fecha_actual = date('hmsYmd');
$fileName = "listaProveedores$fecha_actual.xlsx";
# Crear un "escritor"
$writer = new Xlsx($documento);
#Guardamos
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
$writer->save('php://output');
?>