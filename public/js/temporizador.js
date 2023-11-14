let tiempoRestante = 30;
      
function actualizarContador() {
    document.getElementById("tiempo-restante").textContent = tiempoRestante;
}

function iniciarCronometro() {
    actualizarContador();
    const intervalo = setInterval(function() {
        tiempoRestante--;
        if (tiempoRestante <= 0) {
            clearInterval(intervalo);
            tiempoRestante = 30;
            actualizarContador();
            // Actualizar la página
            location.reload();
        } else {
            actualizarContador();
        }
    }, 1000);
}

// Iniciar el cronómetro automáticamente
iniciarCronometro();

// Obtener el botón por ID
const btnActualizar = document.getElementById("btnActualizar");
// Agregar un evento de clic al botón
btnActualizar.addEventListener("click", function() {
    // Actualizar la página
    location.reload();
});