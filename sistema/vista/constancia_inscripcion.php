<?php
// session_start();
    require('../js/fpdf/fpdf.php');
    class PDF extends FPDF{
        function Header(){
            $this->Image('../../img/fondo_1.png', 0, 0, 200);
            $this->Image('../../img/fondo_2.png', 0, 0, 190);
            $this->Image('../../img/logo_1.png', 0, 25, 120);
            $this->Image('../../img/imagen_aba_izq1.png', 20, 195, 22);
            $this->Image('../../img/imagen_aba_der_1.png', 235, 195, 17);
            $this->SetFont('Arial', '', 25);
            /* ENCABEZADO */
            $this->Cell(110);  // mover a la derecha
            $this->SetFont('Arial', '', 25);
            $this->Cell(96, 40, utf8_decode("MINISTERIO DEL PODER POPULAR"), 0, 0, '', 0);
            $this->Ln(5);

            $this->Cell(146);  // mover a la derecha
            $this->Cell(59, 55, utf8_decode("PARA EL ECOSOCIALISMO"), 0, 0, '', 0);
            $this->Ln(5);

            $this->Cell(127);  // mover a la derecha
            $this->SetTextColor(45, 87, 44);
            $this->SetFont('Arial', '', 27);
            $this->Cell(59, 70, utf8_decode("CERTIFICADO DE REGISTRO"), 0, 0, '', 0);
            $this->Ln(5);

            $this->Cell(140);  // mover a la derecha
            $this->SetTextColor(0, 0, 0);
            $this->SetFont('Arial', '', 12);
            $this->Cell(59, 75, utf8_decode("OTORGADO AL EQUIPO DE TRABAJO DE LAS METRAS"), 0, 0, '', 0);
            $this->Ln(5);
            
            //CUERPO DEDICADO
            $this->Cell(120); 
            $this->SetFont('Arial', 'B', 33);
            $this->Cell(0, 115, utf8_decode("U-CCO-07-06-01-014622"), 0, 0, 'C', 0);
            $this->Ln(5);

            $this->Cell(120); 
            $this->SetFont('Arial', 'I', 33);
            $this->Cell(0, 135, utf8_decode("19 de Diciembre"), 0, 0, 'C', 0);
            $this->Ln(5);

            $this->Cell(127); 
            $this->SetFont('Arial', 'B', 33);
            $this->Cell(0, 155, utf8_decode("AMAZONAS"), 0, 0, 'C', 0);
            $this->Ln(5);

            // CUERPO DEBAJO
            // $this->Cell(110);  // mover a la derecha
            $this->SetFont('Arial', '', 15);
            $this->Cell(0, 220, utf8_decode("En su organización y empoderamiento del Poder"), 0, 0, 'R', 0);
            $this->Ln(5);

            $this->Cell(0, 225, utf8_decode("Popular aportando a la gestión integral de la"), 0, 0, 'R', 0);
            $this->Ln(5);

            $this->Cell(0, 230, utf8_decode("basura como política para promover la reducción,"), 0, 0, 'R', 0);
            $this->Ln(5);

            $this->Cell(0, 235, utf8_decode("reciclaje y reutilización en la consolidación del"), 0, 0, 'R', 0);
            $this->Ln(5);

            $this->Cell(0, 240, utf8_decode("Proyecto Socialista Bolivariano."), 0, 0, 'R', 0);
            $this->Ln(5);
        }
        function Footer(){
            $this->SetY(-25); // Posición: a 1,5 cm del final
            $this->SetFont('Arial', 'B', 14); //tipo fuente, cursiva, tamañoTexto
            $this->Cell(0, 10, utf8_decode('"Lo que está ocurriendo es una transformación cultural"'), 0, 0, 'C');

            $this->SetY(-15); // Posición: a 1,5 cm del final
            $this->SetTextColor(45, 106, 79);
            $this->SetFont('Arial', '', 14);
            $this->Cell(0, 10, utf8_decode('Josué Alejandro Lorca Vega'), 0, 0, 'C'); //pie de pagina(numero de pagina)
        }
    }
        $pdf = new PDF();
        $pdf->AddPage("landscape", "letter"); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
        $pdf->AliasNbPages();
        $pdf->SetFont('Arial', '', 12); //colorBorde
        $pdf->Output('inicio.pdf', 'D');
?>