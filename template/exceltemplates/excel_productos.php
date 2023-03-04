<?php
require_once "../../vendor/autoload.php";
include '../conexion.php';

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
->setDescription('Productos exportados desde Ailee');

$hojaDeProductos = $documento->getActiveSheet();
$hojaDeProductos->setTitle("Productos");

$documento->getDefaultStyle()->getFont()->setName('Roboto');
$hojaDeClientesMerge=$hojaDeProductos->mergeCells("A1:K1");
$hojaDeProductos->setCellValue('A1',"LISTA DE PRODUCTOS")->getStyle('A1')->getAlignment()->setHorizontal('center');
$documento->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(20)->getColor()->setRGB('82bf26');
$documento->getActiveSheet()->getStyle('A2:K2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('82bf26');

# Encabezado de los cedula
$encabezado = ["PRODUCTO","CÓDIGO", "DESCRIPCIÓN", "CATEGORÍA", "PRECIO CON IVA", "PRECIO SIN IVA", "ES MATERIA PRIMA", "INCLUIR EN EL MENÚ", "¿IMPUESTO DE IVA?", "¿IMPUESTO DE SERVICIO?", "ESTADO"];
# El último argumento es por defecto A1
$hojaDeProductos->fromArray($encabezado, null, 'A2')->getStyle('A2:K2')->getFont()->setBold(true)->setSize(12)->getColor()->setRGB('FFFFFF');

$consulta = "select * from productos";
$sentencia = $gbd->prepare($consulta, [
PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,
]);
$sentencia->execute();
# Comenzamos en la fila 3
$numeroDeFila = 3;
while ($producto = $sentencia->fetchObject()) {
# Obtener registros de MySQL
$nombre = $producto->nombre;
$codigo = $producto->codigo;
$descripcion = $producto->descripcion;
$categoria = $producto->categoria;
$precio_iva = $producto->precio_con_iva;
$precio_sin_iva = $producto->precio_sin_iva;
$es_materia_prima = $producto->es_materia_prima;
$incluir_en_menu = $producto->incluir_en_menu;
$impuesto_iva = $producto->impuesto_iva;
$impuesto_servicio = $producto->impuesto_servicio;
$estado = $producto->estado;

# Escribir registros en el documento
$hojaDeProductos->setCellValueByColumnAndRow(1, $numeroDeFila, $nombre)->getColumnDimension('A')->setAutoSize(true);
$hojaDeProductos->setCellValueByColumnAndRow(2, $numeroDeFila, $codigo)->getColumnDimension('B')->setAutoSize(true);
$hojaDeProductos->setCellValueByColumnAndRow(3, $numeroDeFila, $descripcion)->getColumnDimension('C')->setAutoSize(true);
$hojaDeProductos->setCellValueByColumnAndRow(4, $numeroDeFila, $categoria)->getColumnDimension('D')->setAutoSize(true);
$hojaDeProductos->setCellValueByColumnAndRow(5, $numeroDeFila, $precio_iva)->getColumnDimension('E')->setAutoSize(true);
$hojaDeProductos->setCellValueByColumnAndRow(6, $numeroDeFila, $precio_sin_iva)->getColumnDimension('F')->setAutoSize(true);
$hojaDeProductos->setCellValueByColumnAndRow(7, $numeroDeFila, $es_materia_prima)->getColumnDimension('G')->setAutoSize(true);
$hojaDeProductos->setCellValueByColumnAndRow(8, $numeroDeFila, $incluir_en_menu)->getColumnDimension('H')->setAutoSize(true);
$hojaDeProductos->setCellValueByColumnAndRow(9, $numeroDeFila, $impuesto_iva)->getColumnDimension('I')->setAutoSize(true);
$hojaDeProductos->setCellValueByColumnAndRow(10, $numeroDeFila, $impuesto_servicio)->getColumnDimension('J')->setAutoSize(true);
$hojaDeProductos->setCellValueByColumnAndRow(11, $numeroDeFila, $estado)->getColumnDimension('K')->setAutoSize(true);
$numeroDeFila++;
}

$fecha_actual = date('hmsYmd');
$fileName = "listaProductos$fecha_actual.xlsx";
# Crear un "escritor"
$writer = new Xlsx($documento);
#Guardamos
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
$writer->save('php://output');
?>