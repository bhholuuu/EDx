// forms.js

// Get all the forms
const loginForm = document.getElementById("loginForm");
const signupForm = document.getElementById("signupForm");
const forgotPasswordForm = document.getElementById("forgotPasswordForm");

// Get navigation links
const toSignup = document.getElementById("toSignup");
const toForgotPassword = document.getElementById("toForgotPassword");
const toLoginFromSignup = document.getElementById("toLoginFromSignup");
const toLoginFromForgot = document.getElementById("toLoginFromForgot");

// Navigation logic
toSignup.addEventListener("click", () => {
    loginForm.style.display = "none";
    signupForm.style.display = "flex";
});

toForgotPassword.addEventListener("click", () => {
    loginForm.style.display = "none";
    forgotPasswordForm.style.display = "flex";
});

toLoginFromSignup.addEventListener("click", () => {
    signupForm.style.display = "none";
    loginForm.style.display = "flex";
});

toLoginFromForgot.addEventListener("click", () => {
    forgotPasswordForm.style.display = "none";
    loginForm.style.display = "flex";
});