<?php
require_once(__DIR__.'/../model/CategoryModel.php');
require_once('../../vendor/autoload.php');

class ReportePDF
{
    private $titulo;
    private $encabezado;
    private $datos;

    public function __construct($titulo, $encabezado, $datos)
    {
        $this->titulo = $titulo;
        $this->encabezado = $encabezado;
        $this->datos = $datos;
    }

    public function generarPDF()
    {
        // Incluir la librería fpdf
        // Crear una instancia de Fpdi
        $pdf = new FPDF();
        $pdf->AddPage();
        // Configurar la fuente y el tamaño para el título
        $pdf->SetFont('Arial', 'B', 20);

        // Título del informe
        $pdf->Cell(0, 10, utf8_decode($this->titulo) , 0, 1, 'C'); // Salto de línea después del título

        // Crear la tabla con encabezado y datos
        $this->crearTabla($pdf);

        // Nombre del archivo de salida
        $nombre_archivo = 'informe_personalizado.pdf';
        
        // Salida del PDF al navegador en una nueva pestaña
        $pdf->Output($nombre_archivo, 'I');
        // $pdf->Output($nombre_archivo, 'I');
    }

    private function crearTabla($pdf)
    {
        // Configurar la fuente y el tamaño para la tabla
        $pdf->SetFont('Arial', '', 12);
        // Agregar color de fondo al encabezado de la tabla
        // Agregar color de texto al encabezado de la tabla
        $pdf->SetTextColor(0, 0, 0);
        
        // Encabezados de la tabla
        foreach ($this->encabezado as $columna) {
            // El ancho inicial de cada columna es de 40 mm
            // Agregar celda que ocupe todo el espacio posible distribuyendo el ancho de forma equitativa
            // Se envian parametros: ancho, alto, texto, borde, salto de línea, alineación, relleno
            $pdf->Cell(65, 10, utf8_decode($columna), 1);
            // Agregar color de fondo
            // $pdf->Cell(40, 10, utf8_decode($columna), 1);
        }
        $pdf->Ln(); // Salto de línea después de los encabezados

        // Agregar filas de datos
        foreach ($this->datos as $fila) {
            foreach ($fila as $dato) {
                // Agregar celda
                // Se envian parametros: ancho, alto, texto, borde
                // $pdf->Cell(40, 10, utf8_decode($dato), 1,0,'C',0);
                // Agregar en campos separados
                $pdf->Cell(65, 10, utf8_decode($dato), 1);
                // $pdf->Cell(40, 10, $dato, 1);
            }
            $pdf->Ln(); // Salto de línea después de cada fila
        }
    }
}

// Ejemplo de uso
$titulo = 'Categoría de productos';
$categoryModel = new CategoryModel();
// print_r($categoryModel->getCategory());
// $encabezado = ['Columna 1', 'Columna 2', 'Columna 3'];
$encabezado = ['Id', 'Nombre de categoría', 'Estado de categoría'];
$datos = [
    // listar los datos de la categoria usando el metodo getCategory()
    ['Dato 1', 'Dato 2', 'Dato 3'],
    ['Dato 1', 'Dato 2', 'Dato 3'],
];
// Crear instancia de la clase y generar el PDF
$reportePersonalizado = new ReportePDF($titulo, $encabezado, $datos);
$reportePersonalizado->generarPDF();
