<?php
require 'PHPExcel-1.8/Classes/PHPExcel.php';
require_once "../../usuario/modelo/mod_usuario.php";
// require_once 'PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';

$tabla = "usuarios";
$campos = "cedula, nombre, apellido, genero, correo, telefono, nombre_mesa, descripcion_estado, descripcion_municipio, codigo_situr , nombre_consejo_comunal, poblacion_impactar, capacidad_toneladas";
$enlace = "INNER JOIN mesas ON pk_mesa=fk_mesa
    INNER JOIN consejos_comunales ON pk_consejo_comunal=fk_consejo_comunal
    INNER JOIN estado ON pk_estado=fk_estado
    INNER JOIN municipio ON pk_municipio=fk_municipio";
$condicion = "fk_privilegio=1 ORDER BY descripcion_estado, nombre_mesa";
$obj_usuario=new usuarios();
$func_consultar=$obj_usuario->consultar($tabla, $campos, $enlace, $condicion);

// instanciando la fecha
$fecha = new DateTime();
$f_tit =  $fecha->format('Y-m-d');

// Crea un objeto PHPExcel
$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator('ricardo')->setTitle('titulo')->setDescription('descripcion')->setKeywords('llaves')->setCategory('ejemplos');
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle('Hoja1');

// TITULOS DE LAS COLUMNAS
$objPHPExcel->getActiveSheet()->setCellValue('A2', 'CEDULA');
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(13);
$objPHPExcel->getActiveSheet()->setCellValue('B2', 'NOMBRE');
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(14);
$objPHPExcel->getActiveSheet()->setCellValue('C2', 'APELLIDO');
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(14);
$objPHPExcel->getActiveSheet()->setCellValue('D2', 'GENERO');
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(13);
$objPHPExcel->getActiveSheet()->setCellValue('E2', 'CORREO');
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(35);
$objPHPExcel->getActiveSheet()->setCellValue('F2', 'TELEFONO');
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$objPHPExcel->getActiveSheet()->setCellValue('G2', 'NOMBRE MESA');
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(35);
$objPHPExcel->getActiveSheet()->setCellValue('H2', 'ESTADO');
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
$objPHPExcel->getActiveSheet()->setCellValue('I2', 'MUNICIPIO');
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
$objPHPExcel->getActiveSheet()->setCellValue('J2', 'CODIGO');
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(24);
$objPHPExcel->getActiveSheet()->setCellValue('K2', 'CONSEJO COMUNAL');
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(50);
$objPHPExcel->getActiveSheet()->setCellValue('L2', 'POBLACION A IMPACTAR');
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
$objPHPExcel->getActiveSheet()->setCellValue('M2', 'TONELADAS');
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);

$fila = 3;
    while ($resultado = pg_fetch_array($func_consultar)) {
        $objPHPExcel->getActiveSheet()->setCellValue("A" . $fila, $resultado["cedula"]);
        $objPHPExcel->getActiveSheet()->setCellValue("B" . $fila, $resultado["nombre"]);
        $objPHPExcel->getActiveSheet()->setCellValue("C" . $fila, $resultado["apellido"]);
        $objPHPExcel->getActiveSheet()->setCellValue("D" . $fila, $resultado["genero"]);
        $objPHPExcel->getActiveSheet()->setCellValue("E" . $fila, $resultado["correo"]);
        $objPHPExcel->getActiveSheet()->setCellValue("F" . $fila, $resultado["telefono"]);
        $objPHPExcel->getActiveSheet()->setCellValue("G" . $fila, $resultado["nombre_mesa"]);
        $objPHPExcel->getActiveSheet()->setCellValue("H" . $fila, $resultado["descripcion_estado"]);
        $objPHPExcel->getActiveSheet()->setCellValue("I" . $fila, $resultado["descripcion_municipio"]);
        $objPHPExcel->getActiveSheet()->setCellValue("J" . $fila, $resultado["codigo_situr"]);
        $objPHPExcel->getActiveSheet()->setCellValue("K" . $fila, $resultado["nombre_consejo_comunal"]);
        $objPHPExcel->getActiveSheet()->setCellValue("L" . $fila, $resultado["poblacion_impactar"]);
        $objPHPExcel->getActiveSheet()->setCellValue("M" . $fila, $resultado["capacidad_toneladas"]);
        $fila = $fila + 1;
    }

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="excel.xlsx"');
header('Cache-Control: max-age=0');

$objPHPExcel = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objPHPExcel->save('php://output');
?>
