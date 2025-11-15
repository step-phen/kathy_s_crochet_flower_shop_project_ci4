$(document).ready(function() {
    // Get base URL from a data attribute on <body>
    var baseUrl = $('body').data('base-url') || '';
    
    // Use event delegation for dynamically updated cart dropdown
    $(document).on('click', '.cart-remove-btn', function(e) {
        e.preventDefault();
        e.stopPropagation(); // Prevent dropdown from closing
        
        var $itemElem = $(this).closest('.cart-dropdown-item');
        var productId = $itemElem.data('product-id');
        if (!productId) return;
        
        // AJAX request to remove from cart
        $.ajax({
            url: baseUrl + 'remove-from-cart',
            type: 'POST',
            data: { product_id: productId },
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    // Remove item from dropdown with animation
                    $itemElem.fadeOut(200, function() {
                        $(this).remove();
                        
                        // Update cart count badge
                        var $cartCountElem = $('.cart-count');
                        if ($cartCountElem.length && typeof data.cart_count !== 'undefined') {
                            $cartCountElem.text(data.cart_count);
                        }
                        
                        // If cart is empty, show empty message
                        if (data.cart_count === 0 || data.is_empty) {
                            $('.cart-dropdown-menu').html(
                                '<li id="cart-count" class="small text-muted text-center py-3">Your cart is empty.</li>'
                            );
                        } else {
                            // Update subtotal if provided
                            if (typeof data.cart_total !== 'undefined') {
                                $('.cart-subtotal .fw-bold.text').text('Php ' + parseFloat(data.cart_total).toFixed(2));
                            } else if (typeof data.subtotal !== 'undefined') {
                                $('.cart-subtotal .fw-bold.text').text('Php ' + parseFloat(data.subtotal).toFixed(2));
                            }
                        }
                        
                        // If on cart page, update it too
                        if ($('#cartTableBody').length) {
                            var $cartRow = $('#cartTableBody').find('[data-product-id="' + productId + '"]').closest('tr');
                            if ($cartRow.length) {
                                $cartRow.fadeOut(300, function() {
                                    $(this).remove();
                                    
                                    // Check if cart is now empty
                                    if (data.is_empty || data.cart_count === 0) {
                                        $('#cartTableBody').html(`
                                            <tr>
                                                <td colspan="4" class="cart-empty">
                                                    <img src="${baseUrl}assets/images/empty-cart.png" alt="Empty Cart" style="width:80px; margin-bottom:12px;">
                                                    <div>Your cart is empty.<br><span style="font-size:0.95em;">Add products to see them here.</span></div>
                                                </td>
                                            </tr>
                                        `);
                                        $('#continueBtn').addClass('disabled')
                                            .attr('aria-disabled', 'true')
                                            .attr('tabindex', '-1');
                                        $('#products-amount').text('₱0.00');
                                        $('#shipping-fee').text('₱0.00');
                                        $('#cartSubtotal').text('₱0.00');
                                    } else {
                                        // Update totals
                                        if (typeof data.cart_total !== 'undefined') {
                                            $('#products-amount').text('₱' + parseFloat(data.cart_total).toFixed(2));
                                        }
                                        if (typeof data.shipping_fee !== 'undefined') {
                                            $('#shipping-fee').text('₱' + parseFloat(data.shipping_fee).toFixed(2));
                                        }
                                        if (typeof data.grand_total !== 'undefined') {
                                            $('#cartSubtotal').text('₱' + parseFloat(data.grand_total).toFixed(2));
                                        }
                                    }
                                });
                            }
                        }
                    });
                } else {
                    alert(data.message || 'Failed to remove item.');
                }
            },
            error: function() {
                alert('Error removing item.');
            }
        });
    });

    // Listen for custom event to update cart dropdown after add-to-cart
    window.addEventListener('cartUpdated', function(e) {
        var detail = e.detail || {};
        if (detail.cart_html) {
            $('.cart-dropdown-menu').html(detail.cart_html);
        }
        if (typeof detail.cart_count !== 'undefined') {
            $('.cart-count').text(detail.cart_count);
        }
    });

    // Helper: update cart dropdown and count (call this after add-to-cart AJAX success)
    window.updateCartDropdown = function(cartHtml, cartCount) {
        var event = new CustomEvent('cartUpdated', {
            detail: {
                cart_html: cartHtml,
                cart_count: cartCount
            }
        });
        window.dispatchEvent(event);
    };
});