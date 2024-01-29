<?php
    require '../../vendor/autoload.php';
    require_once "../../usuario/modelo/mod_usuario.php";

    use PhpOffice\PhpSpreadsheet\SpreadSheet;
    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\Fill;
    use PhpOffice\PhpSpreadsheet\Style\Alignment;
    use PhpOffice\PhpSpreadsheet\Style\Color;

    $tabla = "usuarios";
    $campos = "cedula, nombre, apellido, genero, correo, telefono, nombre_mesa, descripcion_estado, descripcion_municipio, codigo_situr , nombre_consejo_comunal, poblacion_impactar, capacidad_toneladas";
    $enlace = "INNER JOIN mesas ON pk_mesa=fk_mesa
    INNER JOIN consejos_comunales ON pk_consejo_comunal=fk_consejo_comunal
    INNER JOIN estado ON pk_estado=fk_estado
    INNER JOIN municipio ON pk_municipio=fk_municipio";
    $condicion = "fk_privilegio=1 ORDER BY descripcion_estado, nombre_mesa";
    $obj_usuario=new usuarios();
    $func_consultar=$obj_usuario->consultar($tabla, $campos, $enlace, $condicion);

    $spreadsheet = new SpreadSheet();
    // ESPESIFICADOR CREADO Y TITULO
    $spreadsheet->getProperties()->setCreator("Ricardo Torres")->setTitle("Todas las metras");

    $spreadsheet->setActiveSheetIndex(0);
    // SE ESTABLECE QUE TRABAJARA CON UNA HOJA ACTIVA
    $hojaActiva = $spreadsheet->getActiveSheet();
    // fuente
    $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');

    $hojaActiva->setCellValue("A1", 'CEDULA');
    $hojaActiva->getColumnDimension('A')->setWidth(12);
    $hojaActiva->setCellValue("B1", "NOMBRE");
    $hojaActiva->getColumnDimension('B')->setWidth(14);
    $hojaActiva->setCellValue("C1", "APELLIDO");
    $hojaActiva->getColumnDimension('C')->setWidth(14);
    $hojaActiva->setCellValue("D1", 'GENERO');
    $hojaActiva->getColumnDimension('D')->setWidth(12);
    $hojaActiva->setCellValue("E1", "CORREO");
    $hojaActiva->getColumnDimension('E')->setWidth(35);
    $hojaActiva->setCellValue("F1", "TELEFONO");
    $hojaActiva->getColumnDimension('F')->setWidth(15);
    $hojaActiva->setCellValue("G1", 'NOMBRE MESA');
    $hojaActiva->getColumnDimension('G')->setWidth(35);
    $hojaActiva->setCellValue("H1", "ESTADO");
    $hojaActiva->getColumnDimension('H')->setWidth(15);
    $hojaActiva->setCellValue("I1", "MUNICIPIO");
    $hojaActiva->getColumnDimension('I')->setWidth(15);
    $hojaActiva->setCellValue("J1", 'CODIGO');
    $hojaActiva->getColumnDimension('J')->setWidth(24);
    $hojaActiva->setCellValue("K1", "CONSEJO COMUNAL");
    $hojaActiva->getColumnDimension('K')->setWidth(50);
    $hojaActiva->setCellValue("L1", "POBLACION A IMPACTAR");
    $hojaActiva->getColumnDimension('L')->setWidth(25);
    $hojaActiva->setCellValue("M1", "TONRLADAS");
    $hojaActiva->getColumnDimension('M')->setWidth(15);

    $fila = 2;
    while ($resultado = pg_fetch_array($func_consultar)) {
        $hojaActiva->setCellValue("A" . $fila, $resultado["cedula"]);
        $hojaActiva->setCellValue("B" . $fila, $resultado["nombre"]);
        $hojaActiva->setCellValue("C" . $fila, $resultado["apellido"]);
        $hojaActiva->setCellValue("D" . $fila, $resultado["genero"]);
        $hojaActiva->setCellValue("E" . $fila, $resultado["correo"]);
        $hojaActiva->setCellValue("F" . $fila, $resultado["telefono"]);
        $hojaActiva->setCellValue("G" . $fila, $resultado["nombre_mesa"]);
        $hojaActiva->setCellValue("H" . $fila, $resultado["descripcion_estado"]);
        $hojaActiva->setCellValue("I" . $fila, $resultado["descripcion_municipio"]);
        $hojaActiva->setCellValue("J" . $fila, $resultado["codigo_situr"]);
        $hojaActiva->setCellValue("K" . $fila, $resultado["nombre_consejo_comunal"]);
        $hojaActiva->setCellValue("L" . $fila, $resultado["poblacion_impactar"]);
        $hojaActiva->setCellValue("M" . $fila, $resultado["capacidad_toneladas"]);
        $fila = $fila + 1;
    }

    $style = new Fill();
    $style = [
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => [
                'argb' => 'FF008000',
            ],
        ],
    ];

    // Aplica el estilo a la celda A1
    $hojaActiva->getStyle('A1')->applyFromArray($style);
    $hojaActiva->getStyle('B1')->applyFromArray($style);
    $hojaActiva->getStyle('C1')->applyFromArray($style);
    $hojaActiva->getStyle('D1')->applyFromArray($style);
    $hojaActiva->getStyle('E1')->applyFromArray($style);
    $hojaActiva->getStyle('F1')->applyFromArray($style);
    $hojaActiva->getStyle('G1')->applyFromArray($style);
    $hojaActiva->getStyle('H1')->applyFromArray($style);
    $hojaActiva->getStyle('I1')->applyFromArray($style);
    $hojaActiva->getStyle('J1')->applyFromArray($style);
    $hojaActiva->getStyle('K1')->applyFromArray($style);
    $hojaActiva->getStyle('L1')->applyFromArray($style);
    $hojaActiva->getStyle('M1')->applyFromArray($style);
    // centar y color verde
    $hojaActiva->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $hojaActiva->getStyle('A1')->getFont()->setColor(new Color(Color::COLOR_WHITE));
    $hojaActiva->getStyle('B1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $hojaActiva->getStyle('B1')->getFont()->setColor(new Color(Color::COLOR_WHITE));
    $hojaActiva->getStyle('C1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $hojaActiva->getStyle('C1')->getFont()->setColor(new Color(Color::COLOR_WHITE));
    $hojaActiva->getStyle('D1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $hojaActiva->getStyle('D1')->getFont()->setColor(new Color(Color::COLOR_WHITE));
    $hojaActiva->getStyle('E1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $hojaActiva->getStyle('E1')->getFont()->setColor(new Color(Color::COLOR_WHITE));
    $hojaActiva->getStyle('F1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $hojaActiva->getStyle('F1')->getFont()->setColor(new Color(Color::COLOR_WHITE));
    $hojaActiva->getStyle('G1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $hojaActiva->getStyle('G1')->getFont()->setColor(new Color(Color::COLOR_WHITE));
    $hojaActiva->getStyle('H1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $hojaActiva->getStyle('H1')->getFont()->setColor(new Color(Color::COLOR_WHITE));
    $hojaActiva->getStyle('I1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $hojaActiva->getStyle('I1')->getFont()->setColor(new Color(Color::COLOR_WHITE));
    $hojaActiva->getStyle('J1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $hojaActiva->getStyle('J1')->getFont()->setColor(new Color(Color::COLOR_WHITE));
    $hojaActiva->getStyle('K1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $hojaActiva->getStyle('K1')->getFont()->setColor(new Color(Color::COLOR_WHITE));
    $hojaActiva->getStyle('L1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $hojaActiva->getStyle('L1')->getFont()->setColor(new Color(Color::COLOR_WHITE));
    $hojaActiva->getStyle('M1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $hojaActiva->getStyle('M1')->getFont()->setColor(new Color(Color::COLOR_WHITE));

    $writer = new Xlsx($spreadsheet);

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="metras_totales.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('php://output');
    exit;
?>