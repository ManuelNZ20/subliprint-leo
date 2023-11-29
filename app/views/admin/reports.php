<!-- Vista (view/generar_reporte_view.php) -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Reporte</title>
</head>
<body>

    <!-- Contenido de tu página -->
    <h1>Generar Reporte</h1>

    <!-- Botón para generar el informe -->
    <button id="btnGenerarReporte">Generar Reporte</button>

    <!-- Agrega el script para manejar el clic del botón -->
    <script>
       // Agrega el script para manejar el clic del botón
document.getElementById('btnGenerarReporte').addEventListener('click', function() {
    // Realiza una solicitud al servidor cuando se hace clic en el botón
    // Puedes usar JavaScript puro o una biblioteca como Axios para hacer la solicitud
    // En este ejemplo, se usa la API Fetch de JavaScript
    fetch('generar_reporte_controller.php?generar_reporte=true') // La ruta del controlador que genera el informe
        .then(response => response.json())
        .then(data => {
            // Puedes manejar la respuesta del servidor aquí si es necesario
            console.log(data);
        })
        .catch(error => {
            console.error('Error al generar el informe:', error);
        });
});

    </script>

</body>
</html>
