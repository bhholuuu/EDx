function validatePasswords() {
    const password = document.getElementById("signupPassword").value;
    const confirmPassword = document.getElementById("signupcPassword").value;
    const errorElement = document.getElementById("passwordError");

    if (password !== confirmPassword) {
        errorElement.style.display = "block"; // Show the error message
        return false; // Prevent form submission
    }
    errorElement.style.display = "none"; // Hide the error message
    return true; // Allow form submission
}