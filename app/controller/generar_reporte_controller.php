<?php
require_once(__DIR__.'/../model/CategoryModel.php');
require_once('../../vendor/autoload.php');

class ReportePDF
{   
    private $nameReport;
    private $titulo;
    private $encabezado;
    private $datos;
    private $pdf;

    public function __construct($titulo, $encabezado, $datos)
    {
        $this->titulo = $titulo;
        $this->encabezado = $encabezado;
        $this->datos = $datos;
        $this->pdf = new FPDF();
    }

    public function setTitleReport($titulo)
    {
        $this->pdf->SetTitle($titulo);
    }

    public function setIcon() {
        $this->pdf->Image('https://res.cloudinary.com/dqpzipc8i/image/upload/v1701632028/ecommerce/ypi6vyac45obw2mojjtj.png', 10, 10, 30);
    }

    public function generarPDF($nameReport)
    { 
        $this->nameReport = $nameReport;
        // Incluir la librería fpdf
        // Crear una instancia de Fpdi
        $this->pdf->AddPage();
        $this->setIcon();
        // Configurar la fuente y el tamaño para el título
        $this->pdf->SetFont('Arial', 'B', 20);

        // Título del informe
        $this->pdf->Cell(0, 10, utf8_decode($this->titulo) , 0, 1, 'C'); // Salto de línea después del título
        // Mover mas abajo
        $this->pdf->Ln(18);
        // Crear la tabla con encabezado y datos
        switch ($this->nameReport) {
            case 'Reporte de inventario':
                $this->createTableInventory($this->pdf);
                break;
            case 'Reporte de categorías':
                $this->crearTabla($this->pdf);
                break;
            case 'Reporte de productos':
                $this->crearTabla($this->pdf);
                break;
            case 'Reporte de proveedores':
                $this->crearTabla($this->pdf);
                break;
            case 'Reporte de ventas':
                $this->crearTabla($this->pdf);
                break;
            case 'Reporte de usuarios':
                $this->crearTabla($this->pdf);
                break;
            default:
                # code...
                break;
        }

        // Nombre del archivo de salida
        $nombre_archivo = 'informe_personalizado.pdf';
        ob_end_clean(); // Limpiar el búfer de salida
        // Salida del PDF al navegador en una nueva pestaña
        $this->pdf->Output($nombre_archivo, 'I');
        // $this->pdf->Output($nombre_archivo, 'I');
    }

    private function createTableInventory($pdf)
    {
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFillColor(0, 0, 0);
        $index = 0;
        $indexFinal = count($this->encabezado);
        foreach ($this->encabezado as $columna) {
            if($index==0 || $index >= $indexFinal-2) {
                $pdf->Cell(30, 10, utf8_decode($columna), 1,0,'C',true);
            } else {
                $pdf->Cell(100, 10, utf8_decode($columna), 1,0,'C',true);
                // if($columna === 'Imagen') {
                //     $pdf->Cell(45, 10, utf8_decode($columna), 1,0,'C',true);
                // } else {
                //     $pdf->Cell(90, 10, utf8_decode($columna), 1,0,'C',true);
                // }
            }
            $index++;
        }
        $pdf->Ln();
        $indexFinal = count($this->encabezado);
        foreach ($this->datos as $fila) {
            $index = 0;
            // Establecer la altura deseada para la fila
            $pdf->SetFontSize(10); // Ajusta la altura según tus necesidades
            foreach ($fila as $dato) {
                // Controla el ancho de la celda
                if($index==0 || $index >= $indexFinal-2) {
                    $pdf->SetTextColor(0, 0, 0);
                    $pdf->Cell(30, 30, utf8_decode($dato), 1);
                } else {
                    $pdf->SetTextColor(0, 0, 0);
                    if ($pdf->GetStringWidth(utf8_decode($dato)) > 100) {
                        $pdf->Cell(100, 30, utf8_decode($dato), 1);

                    } else {
                        // Utilizar Cell con la altura establecida
                        $pdf->Cell(100, 30, utf8_decode($dato), 1);
                    }
                }
                $index++;
            }
            $pdf->Ln();
        }
    }
}

