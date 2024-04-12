const emailField = document.getElementById('email');
const passwordField = document.getElementById('password');
const form = document.getElementById('loginForm');

form.addEventListener("submit", function(e) {
    e.preventDefault(); // Prevent form submission by default
    const regEmail = /^[\w\-\.]+@([\w-]+\.)+[\w-]{2,}$/;

    // Validate password
    if (passwordField.value === "") {
        alert("Please enter a password");
        passwordField.style.borderColor = "red";
        return;
    } else {
        passwordField.style.borderColor = "green";
    }

    // Validate email
    if (emailField.value === "" || !regEmail.test(emailField.value)) {
        alert("Please enter a valid email address");
        emailField.style.borderColor = "red";
        return;
    } else {
        emailField.style.borderColor = "green";
    }

    // If validation passes, submit the form
    form.submit();
});
