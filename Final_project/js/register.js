document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("signup");
    const firstNameInput = document.getElementById("firstName");
    const lastNameInput = document.getElementById("lastName");
    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("password");
    const profilePictureInput = document.getElementById("profile-picture");
    const bioInput = document.getElementById("bio");

    form.addEventListener("submit", function(event) {
        let isValid = true;

        if (!firstNameInput.value.trim()) {
            isValid = false;
            alert("Please enter your first name.");
        }

        if (!lastNameInput.value.trim()) {
            isValid = false;
            alert("Please enter your last name.");
        }

        if (!emailInput.value.trim()) {
            isValid = false;
            alert("Please enter your email.");
        }

        if (!passwordInput.value.trim()) {
            isValid = false;
            alert("Please enter your password.");
        }

        if (!profilePictureInput.files[0]) {
            isValid = false;
            alert("Please choose a profile picture.");
        }

        if (!bioInput.value.trim()) {
            isValid = false;
            alert("Please write your bio.");
        }

        if (!isValid) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });
});
