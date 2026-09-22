document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("registerForm");

    if (form) {

        form.addEventListener("submit", function (event) {

            const password =
                document.getElementById("password").value;

            const confirmPassword =
                document.getElementById("confirmPassword").value;

            if (password.length < 6) {

                alert(
                    "Password must contain at least 6 characters."
                );

                event.preventDefault();

                return;
            }

            if (password !== confirmPassword) {

                alert(
                    "Passwords do not match."
                );

                event.preventDefault();

                return;
            }

        });

    }

});