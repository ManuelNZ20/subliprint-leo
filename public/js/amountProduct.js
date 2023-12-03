// Obtener el elemento de entrada y los botones


// Función para incrementar el contador
function incrementar(idProduct, stock) {
    var contadorInput = document.getElementById('contadorInput'+idProduct);
    var valorActual = parseInt(contadorInput.value, 10);
    console.log(stock)
    console.log('Hola')
    // Asegurarse de que el valor no sea mayor que el stock
    if (valorActual >= stock) {
        contadorInput.value = stock;
        return;
    }
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
