document.addEventListener('DOMContentLoaded', function() {
  const togglePassword = document.getElementById('togglePassword');
  const passwordField = document.getElementById('passwordlogin');

  togglePassword.addEventListener('click', function() {
      const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordField.setAttribute('type', type);

      // Toggle between eye and eye-slash icons
      if (type === 'text') {
          togglePassword.classList.remove('fa-eye');
          togglePassword.classList.add('fa-eye-slash');
      } else {
          togglePassword.classList.remove('fa-eye-slash');
          togglePassword.classList.add('fa-eye');
      }
  });

});

function calculateAgeforadd() {
  var today = new Date();
  var birthDate = new Date(document.getElementById("addbirthday").value);
  var age = today.getFullYear() - birthDate.getFullYear();
  var monthDiff = today.getMonth() - birthDate.getMonth();
  if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
      age--;
  }
  document.getElementById("addage").value = age;
}

function validateForm() {
  var password = document.getElementById("passwordreg").value;
  var confirmPassword = document.getElementById("passwordconfirm").value;

  console.log('Password:', password);
  console.log('Confirm Password:', confirmPassword);

  if (password !== confirmPassword) {
      document.getElementById("passwordError").style.display = "block";
      return false;
  } else {
      document.getElementById("passwordError").style.display = "none";
      return true;
  }
}

function previewImage(event) {
  var reader = new FileReader();
  reader.onload = function(){
      var output = document.getElementById('imagePreview');
      output.src = reader.result;
      output.style.display = 'block';
  };
  reader.readAsDataURL(event.target.files[0]);
}



$(document).ready(function() {
  var message = $("#sessionMessage").val();

  if (message === "Add Successfully!") {
      $("#successAdd").modal("show");
  } else if (message === "Full name already exists!") {
      $("#fullNameRegisteredModal").modal("show");
  } else if (message === "Username already exists!") {
      $("#usernameErrorModal").modal("show");
  }
});
document.addEventListener('DOMContentLoaded', function() {
  console.log("DOM Content Loaded");

  var registerButton = document.querySelector('[value="Register"]');

  if (registerButton) {
      console.log("Register button found");
      registerButton.addEventListener('click', openRegisterModal);
  } else {
      console.log("Register button not found");
  }
});

function openRegisterModal() {
  console.log("Opening register modal");
  $('#register').modal('show');
}