//    document.addEventListener("DOMContentLoaded", function() {
//         // Código de inicialización o llamadas a funciones aquí
//         const contadorElement = document.getElementById("contador");
//         const aumentarButton = document.getElementById("aumentar");
//         const disminuirButton = document.getElementById("disminuir");

//         let contador = 1;

//         function actualizarContador() {
//             contadorElement.textContent = contador;
//         }

//         aumentarButton.addEventListener("click", function() {
//             contador++;
//             actualizarContador();
//         });

//         disminuirButton.addEventListener("click", function() {
//             if (contador > 1) {
//                 contador--;
//             }
//             actualizarContador();
//         });
//     });

// Obtener el elemento de entrada y los botones
var contadorInput = document.getElementById('contadorInput');

// Función para incrementar el contador
function incrementar() {
    var valorActual = parseInt(contadorInput.value, 10);
    contadorInput.value = valorActual + 1;
}

// Función para decrementar el contador
function decrementar() {
    var valorActual = parseInt(contadorInput.value, 10);
    
    // Asegurarse de que el valor no sea negativo
    if (valorActual > 1) {
        contadorInput.value = valorActual - 1;
    }
}
// document.addEventListener("DOMContentLoaded", function() {
// });
console.log(contadorInput.value)