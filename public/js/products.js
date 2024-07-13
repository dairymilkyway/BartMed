// products.js

document.addEventListener('DOMContentLoaded', function () {
    
    fetch('/api/products') // Adjust the API endpoint based on your Laravel routes
      .then(response => response.json())
      .then(data => {
        const productList = document.getElementById('productList');
  
        data.forEach(product => {
          const li = document.createElement('li');
          li.innerHTML = `
            <a href="#" class="group block overflow-hidden" onclick="openModal('${product.product_name}', '£${product.price.toFixed(2)} GBP')">
              <img
                src="${product.img_path}"
                alt="${product.product_name}"
                class="h-[350px] w-full object-cover transition duration-500 group-hover:scale-105 sm:h-[450px]"
              />
              <div class="relative bg-white pt-3">
                <h3 class="text-xs text-gray-700 group-hover:underline group-hover:underline-offset-4">
                  ${product.product_name}
                </h3>
                <p class="mt-2">
                  <span class="sr-only">Regular Price</span>
                  <span class="tracking-wider text-gray-900">£${product.price.toFixed(2)} GBP</span>
                </p>
              </div>
            </a>
          `;
          productList.appendChild(li);
        });
      })
      .catch(error => {
        console.error('Error fetching products:', error);
      });
  });
  
  function openModal(productName, productPrice) {
    document.getElementById('productName').textContent = productName;
    document.getElementById('productPrice').textContent = productPrice;
    document.getElementById('productModal').classList.remove('hidden');
  }
  
  function closeModal() {
    document.getElementById('productModal').classList.add('hidden');
  }
  
  function decreaseQuantity() {
    let quantity = document.getElementById('Quantity').value;
    if (quantity > 1) {
      document.getElementById('Quantity').value = --quantity;
    }
  }
  
  function increaseQuantity() {
    let quantity = document.getElementById('Quantity').value;
    document.getElementById('Quantity').value = ++quantity;
  }
  