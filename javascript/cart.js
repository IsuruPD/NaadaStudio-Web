//Confirmation
function confirmCart() {
  var cartContent = document.getElementsByClassName("cart-content")[0];
  var cartBoxes = cartContent.getElementsByClassName("cart-box");
  var items = [];

  for (var i = 0; i < cartBoxes.length; i++) {
    var cartBox = cartBoxes[i];
    var title = cartBox.getElementsByClassName("cart-product-title")[0].innerText;
    var priceElement = cartBox.getElementsByClassName("cart-price")[0];
    var quantityElemet = cartBox.getElementsByClassName("cart-quantity")[0];
    var price = parseFloat(priceElement.innerText.replace("Rs.", ""));
    var quantity = quantityElemet.value;

    var item = {
      title: title,
      price: price,
      quantity: quantity
    };

    items.push(item);
  }

  // Redirect to placereservations.php and pass the cart items as a query parameter
  var url = "placereservations.php?items=" + encodeURIComponent(JSON.stringify(items));
  window.location.href = url;
}

document.addEventListener("DOMContentLoaded", function() {
    let cartIcon = document.querySelector("#cart-icon");
    let cart = document.querySelector(".cart");
    let closeCart = document.querySelector("#close-cart");
  
    cartIcon.onclick = () => {
      cart.classList.toggle("slide");
    };
  
    closeCart.onclick = () => {
      cart.classList.remove("slide");
    };
  
    function ready() {
        //Remove
        var removeCartBtn = document.getElementsByClassName("cart-remove");
        console.log(removeCartBtn);
        for (var i = 0; i < removeCartBtn.length; i++) {
            var button = removeCartBtn[i];
            button.addEventListener("click", removeCartItem);
        }
        //Quantity change
        let quantityInputs = document.getElementsByClassName("cart-quantity");
        console.log(quantityInputs);
        for(let i = 0; i < quantityInputs.length; i++ ){
            let input = quantityInputs[i];
            input.addEventListener("change", quantityChanged);
        }
        //Add item
        let addCart = document.getElementsByClassName('add-cart');
        console.log(addCart);

        for(let i = 0; i < addCart.length; i++ ){
            let button =  addCart[i];
            button.addEventListener('click', addCartClicked);
        }
        updatetotal();
    }

    if (document.readyState == "loading") {
      document.addEventListener("DOMContentLoaded", ready);
    } else {
      ready();
    }

});
    
let cartIcon = document.querySelector("#cart-icon");
let cart = document.querySelector(".cart");
let closeCart = document.querySelector("#close-cart");

//Add to cart
function addProductToCart(title, price, productImg, availableQuantity) {
  let cartItemNames = document.getElementsByClassName('cart-product-title');

  for (let i = 0; i < cartItemNames.length; i++) {
    if (cartItemNames[i].innerText === title) {
      // Item already exists in the cart, update quantity and total
      let quantityInput = cartItemNames[i].closest(".cart-box").getElementsByClassName("cart-quantity")[0];
      let currentQuantity = parseInt(quantityInput.value);
      let newQuantity = currentQuantity + 1;
      if (newQuantity <= parseInt(quantityInput.max)) {
        quantityInput.value = newQuantity;
      } else {
        alert("Maximum quantity limit "+"("+availableQuantity+")"+" reached. 3");
      }

      // Update the total price in the cart
      updatetotal();
      return;
    }
  }

  // If the item does not exist in the cart, add it as a new item
  let cartItems = document.getElementsByClassName('cart-content')[0];
  let cartShopBox = document.createElement('div');
  cartShopBox.classList.add('cart-box');

  let cartBoxContent =  `
      <img class="cart-img" src="${productImg}" alt="">
      <div class="detail-box">
          <div class="cart-product-title">${title}</div>
          <div class="cart-price">${price}</div>
          <input type="number" value="1" max="${availableQuantity}" class="cart-quantity">
      </div>
      <svg class="cart-remove" xmlns="http://www.w3.org/2000/svg" height="1.2em" viewBox="0 0 448 512">
          <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
          <style>svg{fill:#000000}</style>
          <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/>
      </svg>
  `;
  cartShopBox.innerHTML = cartBoxContent;
  cartItems.appendChild(cartShopBox);

  cartShopBox.getElementsByClassName('cart-remove')[0].addEventListener('click', removeCartItem);
  cartShopBox.getElementsByClassName('cart-quantity')[0].addEventListener('change', quantityChanged);

  // Update the total price in the cart
  updatetotal();
}

function updatetotal(){
    var cartContent=document.getElementsByClassName("cart-content")[0];
    var cartBoxes=cartContent.getElementsByClassName("cart-box");
    var total = 0;

    for (var i = 0; i < cartBoxes.length; i++){
        var cartBox=cartBoxes[i];
        var priceElement=cartBox.getElementsByClassName("cart-price")[0];
        var quantityElemet=cartBox.getElementsByClassName("cart-quantity")[0];
        var price=parseFloat(priceElement.innerText.replace("Rs.",""));
        var quantity=quantityElemet.value;
        total=total+price*quantity;

        total = Math.round(total * 100 ) / 100;  
    }
    document.getElementsByClassName("total-price")[0].innerText="Rs. "+total;
}

function quantityChanged(event) {
    let input = event.target;
    if(isNaN(input.value) || input.value <= 0 ){
       input.value = 1;
    };
    updatetotal();
}

function addCartClicked(event) {
  // Get the item details
  let button = event.target;
  let shopProducts = button.closest(".product-box");
  let title = shopProducts.getElementsByClassName("product-title")[0].innerText;
  let price = shopProducts.getElementsByClassName("price")[0].innerText;
  let productImg = shopProducts.getElementsByClassName("product-img")[0].src;

  // Get the available quantity for the selected item
  let availableQuantity = parseInt(shopProducts.getElementsByClassName("item-quantity")[0].value);

  // Check if the item is already in the cart and get its current quantity
  let currentQuantity = 0;
  let cartItemNames = document.getElementsByClassName("cart-product-title");
  for (let i = 0; i < cartItemNames.length; i++) {
    if (cartItemNames[i].innerText === title) {
      currentQuantity = parseInt(cartItemNames[i].closest(".cart-box").getElementsByClassName("cart-quantity")[0].value);
      break;
    }
  }

  // If the current quantity is less than the available quantity, add to cart
  if (currentQuantity < availableQuantity) {
    addProductToCart(title, price, productImg, availableQuantity);

    // Update the total price in the cart
    updatetotal();
  } else {
    alert("Maximum quantity limit "+"("+availableQuantity+")"+" reached.");
  }
}

function addToCart() {
  // Get the item details
  let itemName = document.getElementById("itemModalBodyR").getElementsByClassName("product-title")[0].innerText;
  let itemPrice = document.getElementById("itemModalBodyR").getElementsByClassName("item-price")[0].innerText;
  let itemImage = document.getElementById("itemModalBodyL").getElementsByTagName("img")[0].src;

  // Get the available quantity for the selected item
  let availableQuantity = parseInt(document.getElementById("itemModalBodyR").getElementsByClassName("item-quantity-value")[0].value);
  
  // Check if the item is already in the cart and get its current quantity
  let currentQuantity = 0;
  let cartItemNames = document.getElementsByClassName("cart-product-title");
  for (let i = 0; i < cartItemNames.length; i++) {
    if (cartItemNames[i].innerText === itemName) {
      currentQuantity = parseInt(cartItemNames[i].closest(".cart-box").getElementsByClassName("cart-quantity")[0].value);
      break;
    }
  }

  // If the current quantity is less than the available quantity, add to cart
  if (currentQuantity < availableQuantity) {
    addProductToCart(itemName, itemPrice, itemImage, availableQuantity);

    // Hide the modal after adding the item to the cart
    const itemModal = new bootstrap.Modal(document.getElementById("itemModal"));
    itemModal.hide();

    // Update the total price in the cart
    updatetotal();
  } else {
    alert("Maximum quantity limit "+"("+availableQuantity+")"+" reached.");
  }
}

function removeCartItem(event) {
    var buttonClicked = event.target;
    var cartItem = buttonClicked.closest(".cart-box");
    cartItem.remove();
    updatetotal();
}