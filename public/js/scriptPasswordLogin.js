// Función para mostrar u ocultar la contraseña
$(document).ready(function() {
    $('#showPasswordToggleBtn').click(function() {
        const passwordField = $('#floatingPassword');
        const passwordFieldType = passwordField.attr('type');
        // Si el tipo de campo de contraseña es un campo de contraseña, cambie a texto
        if (passwordFieldType === 'password') {
          passwordField.attr('type', 'text');
        //   limpiar showPasswordToggleIcon 
        $('#showPasswordToggleIcon').removeClass('bi bi-eye');
        $('#showPasswordToggleIcon').addClass('bi bi-eye-slash');
        
      } else {
        passwordField.attr('type', 'password');
        $('#showPasswordToggleIcon').addClass('bi bi-eye');
        $('#showPasswordToggleIcon').removeClass('bi bi-eye-slash');
        }
      });
    });
