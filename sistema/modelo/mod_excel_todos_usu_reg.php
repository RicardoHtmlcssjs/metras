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
    $campos = "cedula, nombre, apellido, genero,
    CASE fk_privilegio
               WHEN 1
               THEN 'Encargado'
               WHEN 2
               THEN 'Colaborador'
               WHEN 3
               THEN 'Administrador'
               WHEN 4
               THEN 'Transcriptor'
               WHEN 5
               THEN 'Técnico'
               ELSE 'Estatus desconocido'
           END AS laboracomo,
     correo, telefono, nombre_mesa, descripcion_estado, descripcion_municipio, codigo_situr , nombre_consejo_comunal, poblacion_impactar, capacidad_toneladas";
    $enlace = "INNER JOIN mesas ON pk_mesa=fk_mesa
    INNER JOIN consejos_comunales ON pk_consejo_comunal=fk_consejo_comunal
    INNER JOIN estado ON pk_estado=fk_estado
    INNER JOIN municipio ON pk_municipio=fk_municipio";
    $condicion = "1=1 ORDER BY descripcion_estado, nombre_mesa, fk_privilegio";
    $obj_usuario=new usuarios();
    $func_consultar=$obj_usuario->consultar($tabla, $campos, $enlace, $condicion);

    // instanciando la fecha
    $fecha = new DateTime();

    $spreadsheet = new SpreadSheet();
    // ESPESIFICADOR CREADO Y TITULO
    $spreadsheet->getProperties()->setCreator("Ricardo Torres")->setTitle("Todos los usuarios de metras");

    $spreadsheet->setActiveSheetIndex(0);
    // SE ESTABLECE QUE TRABAJARA CON UNA HOJA ACTIVA
    $hojaActiva = $spreadsheet->getActiveSheet();
    // fuente
    $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');

    // fecha
    $f_tit =  $fecha->format('Y-m-d');
    //
    $hojaActiva->mergeCells('A1:M1');
    $hojaActiva->setCellValue("A1", $f_tit . ' METRAS - USUARIOS REGISTRADOS');
    $hojaActiva->setCellValue("A2", 'CEDULA');
    $hojaActiva->getColumnDimension('A')->setWidth(12);
    $hojaActiva->setCellValue("B2", "NOMBRE");
    $hojaActiva->getColumnDimension('B')->setWidth(14);
    $hojaActiva->setCellValue("C2", "APELLIDO");
    $hojaActiva->getColumnDimension('C')->setWidth(14);
    $hojaActiva->setCellValue("D2", 'GENERO');
    $hojaActiva->getColumnDimension('D')->setWidth(12);
    $hojaActiva->setCellValue("E2", "CORREO");
    $hojaActiva->getColumnDimension('E')->setWidth(35);
    $hojaActiva->setCellValue("F2", "TELEFONO");
    $hojaActiva->getColumnDimension('F')->setWidth(15);
    $hojaActiva->setCellValue("G2", 'NOMBRE MESA');
    $hojaActiva->getColumnDimension('G')->setWidth(35);
    $hojaActiva->setCellValue("H2", "ESTADO");
    $hojaActiva->getColumnDimension('H')->setWidth(15);
    $hojaActiva->setCellValue("I2", "MUNICIPIO");
    $hojaActiva->getColumnDimension('I')->setWidth(15);
    $hojaActiva->setCellValue("J2", 'CODIGO');
    $hojaActiva->getColumnDimension('J')->setWidth(24);
    $hojaActiva->setCellValue("K2", "CONSEJO COMUNAL");
    $hojaActiva->getColumnDimension('K')->setWidth(50);
    $hojaActiva->setCellValue("L2", "POBLACION A IMPACTAR");
    $hojaActiva->getColumnDimension('L')->setWidth(25);
    $hojaActiva->setCellValue("M2", "TONELADAS");
    $hojaActiva->getColumnDimension('M')->setWidth(15);

    $fila = 3;
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
    // tamaño de letra de primera liena
    $style_tit = [
        'font' => [
            'size' => 20,
        ],
    ];
    // color verde a la fila 2 de los titulos
    $style = [
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => [
                'argb' => 'FF008000',
            ],
        ],
    ];

    // estilos a primera linea
    $hojaActiva->getStyle('A1')->applyFromArray($style_tit);
    // Aplica el estilo a la celda A2
    $hojaActiva->getStyle('A2')->applyFromArray($style);
    $hojaActiva->getStyle('B2')->applyFromArray($style);
    $hojaActiva->getStyle('C2')->applyFromArray($style);
    $hojaActiva->getStyle('D2')->applyFromArray($style);
    $hojaActiva->getStyle('E2')->applyFromArray($style);
    $hojaActiva->getStyle('F2')->applyFromArray($style);
    $hojaActiva->getStyle('G2')->applyFromArray($style);
    $hojaActiva->getStyle('H2')->applyFromArray($style);
    $hojaActiva->getStyle('I2')->applyFromArray($style);
    $hojaActiva->getStyle('J2')->applyFromArray($style);
    $hojaActiva->getStyle('K2')->applyFromArray($style);
    $hojaActiva->getStyle('L2')->applyFromArray($style);
    $hojaActiva->getStyle('M2')->applyFromArray($style);
    // centar y color verde
    $hojaActiva->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $hojaActiva->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $hojaActiva->getStyle('A2')->getFont()->setColor(new Color(Color::COLOR_WHITE));
    $hojaActiva->getStyle('B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $hojaActiva->getStyle('B2')->getFont()->setColor(new Color(Color::COLOR_WHITE));
    $hojaActiva->getStyle('C2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $hojaActiva->getStyle('C2')->getFont()->setColor(new Color(Color::COLOR_WHITE));
    $hojaActiva->getStyle('D2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $hojaActiva->getStyle('D2')->getFont()->setColor(new Color(Color::COLOR_WHITE));
    $hojaActiva->getStyle('E2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $hojaActiva->getStyle('E2')->getFont()->setColor(new Color(Color::COLOR_WHITE));
    $hojaActiva->getStyle('F2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $hojaActiva->getStyle('F2')->getFont()->setColor(new Color(Color::COLOR_WHITE));
    $hojaActiva->getStyle('G2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $hojaActiva->getStyle('G2')->getFont()->setColor(new Color(Color::COLOR_WHITE));
    $hojaActiva->getStyle('H2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $hojaActiva->getStyle('H2')->getFont()->setColor(new Color(Color::COLOR_WHITE));
    $hojaActiva->getStyle('I2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $hojaActiva->getStyle('I2')->getFont()->setColor(new Color(Color::COLOR_WHITE));
    $hojaActiva->getStyle('J2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $hojaActiva->getStyle('J2')->getFont()->setColor(new Color(Color::COLOR_WHITE));
    $hojaActiva->getStyle('K2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $hojaActiva->getStyle('K2')->getFont()->setColor(new Color(Color::COLOR_WHITE));
    $hojaActiva->getStyle('L2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $hojaActiva->getStyle('L2')->getFont()->setColor(new Color(Color::COLOR_WHITE));
    $hojaActiva->getStyle('M2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $hojaActiva->getStyle('M2')->getFont()->setColor(new Color(Color::COLOR_WHITE));

    $writer = new Xlsx($spreadsheet);
    // espesificar fecha
    
    $f =  $fecha->format('Y-m-d');
    $to = $f."_todos_usurios_metras.xlsx";

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$to.'"');
    header('Cache-Control: max-age=0');

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('php://output');
    exit;
?>