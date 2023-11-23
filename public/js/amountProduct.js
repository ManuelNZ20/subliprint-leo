// Obtener el elemento de entrada y los botones


// Función para incrementar el contador
function incrementar(idProduct) {
    var contadorInput = document.getElementById('contadorInput'+idProduct);
    var valorActual = parseInt(contadorInput.value, 10);
    contadorInput.value = valorActual + 1;
}

// Función para decrementar el contador
function decrementar(idProduct) {
    var contadorInput = document.getElementById('contadorInput'+idProduct);
    var valorActual = parseInt(contadorInput.value, 10);
    
    // Asegurarse de que el valor no sea negativo
    if (valorActual > 1) {
        contadorInput.value = valorActual - 1;
    }
}
// document.addEventListener("DOMContentLoaded", function() {
// });
