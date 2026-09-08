function validateRegister() {

    let password =
        document.getElementById("password").value;

    let confirmPassword =
        document.getElementById("confirmPassword").value;

    if (password !== confirmPassword) {

        alert("Passwords do not match.");

        return false;

    }

    if (password.length < 6) {

        alert("Password must contain at least 6 characters.");

        return false;

    }

    return true;
}