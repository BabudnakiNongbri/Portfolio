let cart = JSON.parse(localStorage.getItem("cart")) || [];

function updateCartCount(){

    const badge=document.querySelector(".cart-count");

    if(badge){
        badge.textContent=cart.length;
    }

}

function addToCart(product){

    cart.push(product);

    localStorage.setItem("cart",JSON.stringify(cart));

    updateCartCount();

    alert(product.name + " added to cart!");

}

function displayCart(){

    const cartContainer=document.getElementById("cartItems");

    const total=document.getElementById("totalPrice");

    if(!cartContainer) return;

    cartContainer.innerHTML="";

    let grandTotal=0;

    cart.forEach((item,index)=>{

        grandTotal+=item.price;

        cartContainer.innerHTML+=`

        <div class="cart-item">

            <img src="${item.image}">

            <div class="cart-details">

                <h3>${item.name}</h3>

                <p>Price: ₹${item.price}</p>

            </div>

            <button class="remove-btn"
            onclick="removeItem(${index})">

            Remove

            </button>

        </div>

        `;

    });

    total.textContent="Total: ₹"+grandTotal;

}

function removeItem(index){

    cart.splice(index,1);

    localStorage.setItem("cart",JSON.stringify(cart));

    displayCart();

    updateCartCount();

}

updateCartCount();

displayCart();