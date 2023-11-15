// console.log('cartProducts.js')
// require_once('../../../app/controller/ProductController.php');
// Implementar la funcion de agregar al carrito
// function addProduct(id) {
//     // Obtener la cantidad de productos
//     const amountProduct = document.getElementById("contador");
//     // Instanciar un objeto FormData
//     const formData = new FormData();
//     // Agregar datos al objeto
//     formData.append("id", id);
//     formData.append("amount", amountProduct.textContent);
//     // Instanciar un objeto XMLHttpRequest
//     const xhr = new XMLHttpRequest();
//     // Definir una función a ejecutar cuando se reciban datos
//     xhr.onload = function() {
//         // Código a ejecutar cuando se termina la petición
//         if (this.status === 200) {
//             const num_cart = document.getElementById("num_cart");
//             num_cart.innerHTML = this.responseText;
//         }
//     };
//     // Definir la dirección del archivo a cargar
//     xhr.open("POST", "../../../app/controller/CartController.php");
//     // Enviar la petición
//     xhr.send(formData);
// }
//
// Implementar la funcion de agregar al carrito
function addProduct(id){
    //
    const amountProduct = document.getElementById("contador");// cantidad de productos
    let url = `../../../app/model/CartModel.php`;
    let formData = new FormData(); // objeto para enviar datos
    formData.append("id", id);
    formData.append("amount", amountProduct.textContent);
    fetch(url, // url a la que se envia la peticion
         {
        method: "POST", // se envia por el metodo post
        body: formData, // se envia el objeto con los datos
        mode: "cors" // se envia por cors
    })
    .then(response => response.json())
    .then(data => {
        const num_cart = document.getElementById("num_cart");
        num_cart.innerHTML = data;
    })
    .catch(error => console.log(error));
}

// function addProduct(id) {
//     const amountProduct = document.getElementById("contador"); // cantidad de productos
//     let url = `../../../app/controller/CartController.php`;// url a la que se envia la peticion
//     let formData = new FormData(); // objeto para enviar datos
//     formData.append("id", id);
//     formData.append("amount", amountProduct.textContent);

//     fetch(url, {
//         method: "POST",
//         body: formData,
//         mode: "cors"
//     })
//     .then(response => response.json())
//     .then(data => {
//         const num_cart = document.getElementById("num_cart");
//         num_cart.innerHTML = data;
//         // if (window.location.href.includes("/roberto-cotlear/app/views/cart/carts.php")) {
//         //     // Solo actualiza visualmente si estamos en la página de carrito
//         // }
//     })
//     .catch(error => console.log(error));
// }
