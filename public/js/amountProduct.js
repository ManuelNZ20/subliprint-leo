const contadorElement = document.getElementById("contador");
const aumentarButton = document.getElementById("aumentar");
const disminuirButton = document.getElementById("disminuir");

let contador = 1;

function actualizarContador() {
    contadorElement.textContent = contador;
}

aumentarButton.addEventListener("click", function() {
    contador++;
    actualizarContador();
});

disminuirButton.addEventListener("click", function() {
    if(contador > 1) {
        contador--;
    }
    actualizarContador();
});