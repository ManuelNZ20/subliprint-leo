paypal.Buttons(
    {
        style:{
            shape: 'pill',
            color: 'blue',
            label: 'pay',
        },
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: 100// Precio del producto
                    }
                }]
            });
        },
        // Los parametros que se van a enviar al servidor
        // para que se pueda realizar el pago, en este caso, el id del producto, el precio y el id del usuario
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                // window.location.href = '/payment/success/' + details.id + '/' + details.purchase_units[0].amount.value + '/' + details.payer.name.given_name + '/' + details.payer.name.surname + '/' + details.payer.email_address; // Redireccionar al usuario a la pagina de exito
                
                document.getElementById('result-message').innerHTML = '<h3>El pago fue realizado con exito</h3>';
                console.log(details);

                return fetch('/payment/paypal-transaction-complete', {
                    method: 'post',
                    headers: {
                        'content-type': 'application/json'
                    },
                    body: JSON.stringify({
                        orderID: details
                    })
                });
            });
        },
        onCancel: function (data) {
            document.getElementById('result-message').innerHTML = '<h3>El pago fue cancelado</h3>';
            console.log(data);
        },
    }
).render('#paypal-button-container');