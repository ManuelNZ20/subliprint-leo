$(document).ready(function() {
  $('#showPasswordToggle').click(function() {
    const passwordField = $('#password');
    const passwordFieldType = passwordField.attr('type');
    
    if (passwordFieldType === 'password') {
      passwordField.attr('type', 'text');
      $(this).html('<i class="bi bi-eye-slash"></i>');

    } else {
      passwordField.attr('type', 'password');
      $(this).html('<i class="bi bi-eye"></i>');
    }
  });
});
// $(document).ready(function() {
//   $('#showPasswordToggleLogin').click(function() {
//     const passwordField = $('#floatingPassword');
//     const passwordFieldType = passwordField.attr('type');
    
//     if (passwordFieldType === 'password') {
//       passwordField.attr('type', 'text');
//       $(this).html('<i class="bi bi-eye-slash"></i>');

//     } else {
//       passwordField.attr('type', 'password');
//       $(this).html('<i class="bi bi-eye"></i>');
//     }
//   });
// });

