document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("checkoutForm");

    if (form) {

        form.addEventListener("submit", function (e) {

            e.preventDefault();

            alert("🎉 Your order has been placed successfully!");

            localStorage.removeItem("cart");

            window.location.href = "index.html";

        });

    }

});