<?= $this->extend('customer/layouts/page-layout') ?>
<?= $this->section('content') ?>
<main class="main-content">
    <div class="container py-4">
        <div class="row">
            <!-- Cart -->
            <div class="col-lg-7 mb-4 mb-lg-0">
                <h2 class="mb-4 fw-bold">Shopping Cart</h2>
                <table class="table cart-table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Flower</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody id="cartTableBody">
                        <?php if (empty($cartItems)): ?>
                            <tr>
                                <td colspan="4" class="cart-empty">
                                    <img src="<?= base_url('/assets/images/empty-cart.png') ?>" alt="Empty Cart" style="width:80px; margin-bottom:12px;">
                                    <div>Your cart is empty.<br><span style="font-size:0.95em;">Add products to see them here.</span></div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($cartItems as $item): ?>
                                <tr>
                                    <td class="d-flex align-items-center">
                                        <img src="<?= base_url($item['image']) ?>" alt="<?= esc($item['product_name']) ?>" class="cart-product-img">
                                        <div class="ms-2">
                                            <span class="fw-semibold"><?= esc($item['product_name']) ?></span><br>
                                            <span class="text-muted small"><?= esc($item['category_name'] ?? '') ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary px-3 py-2 fs-6"><?= esc($item['quantity']) ?></span>
                                    </td>
                                    <td>
                                        <span class="fw-bold">₱<?= number_format($item['price'], 2) ?></span>
                                    </td>
                                    <td>
                                        <form class="cart-remove-form" data-product-id="<?= $item['product_id'] ?>" action="<?= base_url('kathys_crochet_flowers/cart/remove/' . $item['product_id']) ?>" method="post">
                                            <button type="submit" class="btn text-danger px-3">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <!-- Delivery Info & Summary -->
            <div class="col-lg-5 mb-4 mb-lg-0">
                <div class="cart-summary-card">
                    <h4 class="mb-3 fw-bold">Summary</h4>
                    <hr class="divider">
                    <div class="line">
                        <div class="label fw-bold">Subtotal</div>
                        <div class="value" id="products-amount">
                            ₱<?= isset($cartTotal) ? number_format($cartTotal, 2) : '0.00' ?>
                        </div>
                    </div>
                    <div class="line">
                        <div class="label text-muted">Shipping Fee</div>
                        <div class="value" id="shipping-fee">
                            ₱<?= isset($shippingFee) ? number_format($shippingFee, 2) : '0.00' ?>
                        </div>
                    </div>
                    <hr class="divider">
                    <div class="d-flex justify-content-between align-items-center fw-bold fs-5 mt-4">
                        <span>Total Amount:</span>
                        <span class="text-danger" id="cartSubtotal">
                            ₱<?= isset($cartTotal, $shippingFee) ? number_format($cartTotal + $shippingFee, 2) : '0.00' ?>
                        </span>
                    </div>
                    <a href="<?= route_to('customer.checkout') ?>" class="btn btn-success w-100 mt-3 fw-bold py-2 rounded-pill <?= empty($cartItems) ? 'disabled' : '' ?>" id="continueBtn" <?= empty($cartItems) ? 'aria-disabled="true" tabindex="-1"' : '' ?>>Checkout</a>
                    <div id="deliveryError" class="text-danger mt-2" style="display:none;"></div>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
    $(function() {
        $('.cart-remove-form').on('submit', function(e) {
            e.preventDefault();
            var $form = $(this);
            var productId = $form.data('product-id');
            var $row = $form.closest('tr');

            $.ajax({
                url: "<?= base_url('kathys_crochet_flowers/remove-from-cart') ?>",
                type: 'POST',
                dataType: 'json',
                data: {
                    product_id: productId,
                    <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                },
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    if (response.success) {
                        // Remove the row with animation
                        $row.fadeOut(300, function() {
                            $(this).remove();

                            // Check if cart is now empty
                            if ($('#cartTableBody tr:visible').length === 0) {
                                $('#cartTableBody').html(`
                                <tr>
                                    <td colspan="4" class="cart-empty">
                                        <img src="<?= base_url('/assets/images/empty-cart.png') ?>" alt="Empty Cart" style="width:80px; margin-bottom:12px;">
                                        <div>Your cart is empty.<br><span style="font-size:0.95em;">Add products to see them here.</span></div>
                                    </td>
                                </tr>
                            `);
                                $('#continueBtn').addClass('disabled').attr('aria-disabled', 'true').attr('tabindex', '-1');
                            }
                        });

                        // Update cart count in navbar
                        if ($('.cart-count').length) {
                            $('.cart-count').text(response.cart_count);
                        }

                        // Reload page to update totals (simpler approach)
                        setTimeout(function() {
                            location.reload();
                        }, 400);
                    } else {
                        alert(response.message || 'Failed to remove item.');
                    }
                },
                error: function(xhr) {
                    console.error('AJAX Error:', xhr);
                    alert('Failed to remove item. Please try again.');
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>