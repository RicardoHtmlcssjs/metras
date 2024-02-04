<?php
    session_start();
    // $id_usu = $_SESSION["id_usuario"];
    $id_usu = $_POST["id_mesa"];
    require('../js/fpdf/fpdf.php');
    require_once "../../usuario/modelo/mod_usuario.php";
    $tabla = "mesas";
    $campos = "nombre_mesa, descripcion_estado";
    $enlace = "INNER JOIN seguridad.usuarios ON sistema.mesas.fk_usuario=seguridad.usuarios.pk_usuario INNER JOIN
    ubicacion.estado ON sistema.mesas.fk_estado=ubicacion.estado.pk_estado INNER JOIN
    sistema.consejos_comunales ON sistema.mesas.fk_consejo_comunal=sistema.consejos_comunales.pk_consejo_comunal";
    $condicion = "pk_mesa = $id_usu";
    $obj_usuario=new usuarios();
	$func_consultar=$obj_usuario->consultar($tabla, $campos, $enlace, $condicion);
    if ($resultado=pg_fetch_array($func_consultar)){
        $_SESSION["nombre_mesa_certificado_imp"] = $resultado['nombre_mesa'];
        $_SESSION["descripcion_estado_certificado_imp"] = $resultado['descripcion_estado'];
    }
    $_SESSION["id_mesa"] = $id_usu;

    class PDF extends FPDF{
        function Header(){
            $this->Image('../../img/fondo_1.png', 0, 0, 200);
            $this->Image('../../img/fondo_2.png', 0, 0, 190);
            $this->Image('../../img/logo_1.png', 0, 25, 120);
            $this->Image('../../img/footer_verde.png', 0, 206, 290);
            $this->Image('../../img/gobierno_bolivariano.png', 3, 206, 60);
            $this->Image('../../img/logo_minec_blanco.png', 245, 207, 30);
            $this->Image('../../img/200_años_bicentenario.png', 230, 207, 10);
            $this->SetFont('Arial', '', 28);
            /* ENCABEZADO */
            $this->Cell(110);  // mover a la derecha
            $this->SetFont('Times', 'B', 25);
            $this->Cell(0, 40, utf8_decode("MINISTERIO DEL PODER POPULAR PARA"), 0, 0, 'R', 0);
            $this->Ln(5);

            $this->Cell(146);  // mover a la derecha
            $this->Cell(0, 55, utf8_decode("EL ECOSOCIALISMO"), 0, 0, 'R', 0);
            $this->Ln(5);

            $this->Cell(127);  // mover a la derecha
            // $this->SetTextColor(45, 87, 44);
            $this->SetFont('Arial', 'B', 30);
            $this->Cell(0, 80, utf8_decode("CERTIFICADO DE REGISTRO"), 0, 0, 'R', 0);
            $this->Ln(5);

            $this->Cell(140);  // mover a la derecha
            $this->SetTextColor(0, 0, 0);
            $this->SetFont('Arial', 'B', 15);
            $this->Cell(0, 100, utf8_decode("OTORGADO AL EQUIPO DE TRABAJO DE LAS METRAS"), 0, 0, 'R', 0);
            $this->Ln(5);

                //CUERPO DEDICADO
                $this->SetFont('Arial', 'B', 33);
                $this->Cell(0, 125, utf8_decode('IDMETRA: '. $_SESSION["id_mesa"]), 0, 0, 'R', 0);
                $this->Ln(5);

                $nombre_metra = 'Nombre: '.$_SESSION["nombre_mesa_certificado_imp"];
                if(strlen($nombre_metra) >= 42){
                    $this->SetFont('Arial', 'I', 25);
                    $this->Cell(0, 150, utf8_decode($nombre_metra), 0, 0, 'R', 0);
                    // $this->Ln(5);

                    $this->SetFont('Arial', 'B', 33);
                    $this->Cell(0, 185, utf8_decode('Estado: '.$_SESSION["descripcion_estado_certificado_imp"]), 0, 0, 'R', 0);
                    $this->Ln(5);
                }else{
                    $this->SetFont('Arial', 'I', 33);
                    $this->Cell(0, 145, utf8_decode($nombre_metra), 0, 0, 'R', 0);
                    $this->Ln(5);

                    $this->SetFont('Arial', 'B', 33);
                    $this->Cell(0, 165, utf8_decode('Estado: '.$_SESSION["descripcion_estado_certificado_imp"]), 0, 0, 'R', 0);
                    $this->Ln(5);
                }

            // CUERPO DEBAJO
            // $this->Cell(110);  // mover a la derecha
            $this->SetFont('Arial', 'B', 15);
            $this->Cell(0, 200, utf8_decode("En pro de fortalecer el proceso en el manejo y gestión "), 0, 0, 'R', 0);
            $this->Ln(5);

            $this->Cell(0, 205, utf8_decode("integral de la residuos y desechos, como modelos de "), 0, 0, 'R', 0);
            $this->Ln(5);

            $this->Cell(0, 210, utf8_decode("gestión promoviendo desde el origen: Reducir, "), 0, 0, 'R', 0);
            $this->Ln(5);

            $this->Cell(0, 215, utf8_decode("reutilizar y reciclar en la consolidación del Proyecto "), 0, 0, 'R', 0);
            $this->Ln(5);

            $this->Cell(0, 220, utf8_decode("Socialista Bolivariano."), 0, 0, 'R', 0);
            $this->Ln(5);
        }
        function Footer(){
            $this->SetY(-35); // Posición: a 1,5 cm del final
            $this->SetFont('Arial', 'I', 16); //tipo fuente, cursiva, tamañoTexto
            $this->Cell(0, 10, utf8_decode('"Lo que está ocurriendo es una transformación cultural"'), 0, 0, 'C');

            $this->SetY(-25); // Posición: a 1,5 cm del final
            $this->SetTextColor(45, 106, 79);
            $this->SetFont('Times', '', 16);
            $this->Cell(0, 10, utf8_decode('Josué Alejandro Lorca Vega'), 0, 0, 'C'); //pie de pagina(numero de pagina)
        }
    }
        $pdf = new PDF();
        $pdf->AddPage("landscape", "letter"); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
        $pdf->AliasNbPages();
        $pdf->SetFont('Arial', '', 12); //colorBorde
        $pdf->Output('certificado_' . $id_usu . $_SESSION['nombre_mesa_certificado_imp'] . '.pdf', 'D');
?>