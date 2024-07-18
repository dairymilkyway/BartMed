// $(document).ready(function() {
//     // Add to Cart function
//     function addToCart() {
//         const productId = $('#productModal').data('product-id');
//         const quantity = $('#Quantity').val();

//         $.ajax({
//             url: '/api/carts',
//             type: 'POST',
//             data: {
//                 product_id: productId,
//                 quantity: quantity
//             },
//             headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             },
//             success: function(response) {
//                 alert('Item added to cart!');
//                 closeModal(); // Close the modal after adding to cart
//                 updateCartCounter(); // Update cart counter (assuming this function exists)
//             },
//             error: function(xhr) {
//                 alert('Error adding item to cart');
//                 console.error(xhr);
//             }
//         });
//     }

//     // Attach addToCart function to the Add to Cart button
//     $('.add-to-cart-button').on('click', function() {
//         addToCart();
//     });
// });
