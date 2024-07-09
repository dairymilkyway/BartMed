// cart.js

// Initialize the cart counter
let cartCount = 0;

// Function to update the cart counter
function updateCartCounter() {
    const counter = document.getElementById('cart-counter');
    counter.textContent = cartCount;
}

// Function to add an item to the cart
function addToCart() {
    cartCount++;
    updateCartCounter();
}

// Example usage: Simulate adding an item to the cart
// You can call this function whenever an item is added to the cart
document.addEventListener('DOMContentLoaded', function() {
    // Example: Add item to cart every 2 seconds
    setInterval(addToCart, 2000);
});
