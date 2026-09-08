const products = [
    {
        name: "RMA Jersey",
        price: 4999,
        image: "images/jerseys/realmadrid.jpg"
    },
    {
        name: "Arsenal Home Jersey",
        price: 4799,
        image: "images/jerseys/arsenal.jpg"
    },
    {
        name: "Juventus Home Jersey",
        price: 4699,
        image: "images/jerseys/juventus.jpg"
    },
    {
        name: "Manchester Jersey",
        price: 4899,
        image: "images/jerseys/manunited.jpg"
    },
    {
        name: "Bayern Munich Jersey",
        price: 4799,
        image: "images/jerseys/bayern.jpg"
    },
    {
        name: "AC Milan Jersey",
        price: 4699,
        image: "images/jerseys/acmilan.jpg"
    }
];

const container = document.getElementById("productContainer");

products.forEach((product, index) => {

    container.innerHTML += `
        <div class="card">
            <img src="${product.image}" alt="${product.name}">
            <h3>${product.name}</h3>
            <div class="rating">★★★★★</div>
            <div class="price">₹${product.price}</div>

            <button onclick="addToCart(products[${index}])">
                Add to Cart
            </button>
        </div>
    `;

});