// console.log('cartProducts.js')
// require_once('../../../app/controller/ProductController.php');
const addProduct = (id) => {
    //
    const amountProduct = document.getElementById("contador");// cantidad de productos
    const url = `../../../app/controller/CartController.php`;
    const formData = new FormData(); // objeto para enviar datos
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