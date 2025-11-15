<?= $this->extend('customer/layouts/page-layout'); ?>
<?= $this->section('content'); ?>

<section class="product-details py-5">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= route_to('customer.home') ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= route_to('customer.products') ?>">Products</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= esc($product['product_name'] ?? 'Product') ?></li>
            </ol>
        </nav>
        <div class="bg-white rounded-1 shadow-lg p-4 d-flex flex-column flex-md-row align-items-start product-details-combined mx-auto">
            <div class="product-image-wrapper d-flex flex-column align-items-center me-md-5 mb-4 mb-md-0">
                <?php
                if (!empty($product['image'])) {
                    if (strpos($product['image'], 'http') === 0) {
                        $imgSrc = $product['image'];
                    } elseif (strpos($product['image'], 'uploads/products/') === 0) {
                        $imgSrc = base_url($product['image']);
                    } else {
                        $imgSrc = base_url('uploads/products/' . $product['image']);
                    }
                } else {
                    $imgSrc = base_url('uploads/products/no-image.png');
                }
                ?>
                <img id="product-image" src="<?= esc($imgSrc) ?>" alt="Product Image"
                    class="img-fluid rounded-4 product-detail-img mb-3">
                <div class="d-flex gap-2 mt-2">
                    <!-- Thumbnail gallery, can be extended for more images -->
                    <img src="<?= esc($imgSrc) ?>" class="img-thumbnail product-detail-thumb"
                        onclick="document.getElementById('product-image').src=this.src">
                </div>
                <div class="mt-3">
                    <span class="me-2">Share:</span>
                    <a href="https://www.facebook.com/" class="me-1"><i class="fab fa-facebook fa-lg"></i></a>
                    <a href="https://www.instagram.com/" class="me-1"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="https://www.twitter.com/" class="me-1"><i class="fab fa-x-twitter fa-lg"></i></a>
                </div>
            </div>
            <div class="flex-grow-1 d-flex flex-column justify-content-center product-detail-info">
                <h2 class="mb-2 fw-bold playfair-display product-detail-title">
                    <?= esc($product['product_name'] ?? 'Product Name') ?>
                </h2>
                <small class="mb-1 text-muted">Category:</small>
                <div class="mb-2 fw-semibold product-detail-category">
                    <?= esc($product['category_name'] ?? '') ?>
                </div>
                <div class="product-price mb-3 product-detail-price">
                    <i class="fa-solid fa-money-bill-wave"></i> Php <?= esc($product['price'] ?? '') ?>
                </div>
                <div class="mb-1 fw-normal text-muted">Description:</div>
                <p class="mb-4 fw-bold product-detail-desc">
                    <?= esc($product['description'] ?? '') ?>
                </p>
                <div class="d-flex align-items-center mb-3">
                    <span class="me-2">Quantity:</span>
                    <button class="btn btn-outline-secondary btn-sm me-1" id="qty-minus">-</button>
                    <input type="text" id="qty-input" value="1" class="form-control form-control-sm text-center product-detail-qty-input">
                    <button class="btn btn-outline-secondary btn-sm ms-1" id="qty-plus">+</button>
                </div>
                <?php if (isset($product['stock'])): ?>
                    <div class="mb-4">
                        <?php if ($product['stock'] == 0): ?>
                            <span class="text-danger px-0 py-2 fs-7">
                                Out of stock
                            </span>
                        <?php elseif ($product['stock'] <= 20): ?>
                            <span class="text-danger fw-bold px-0 py-2 fs-7">
                                Hurry! Only <?= esc($product['stock']) ?> item<?= $product['stock'] == 1 ? '' : 's' ?> left
                            </span>
                        <?php else: ?>
                            <span class="text-success fw-bold px-0 py-2 fs-7">Available Stock: <?= esc($product['stock']) ?></span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <div class="d-flex gap-3">
                    <button class="btn btn-sm px-3 py-2 product-detail-cart-btn btn-success"
                        id="addToCartBtn"
                        <?php if (isset($product['stock']) && $product['stock'] == 0): ?>disabled aria-disabled="true"<?php endif; ?>>
                        <i class="fa fa-cart-plus me-2"></i>Add to Cart
                    </button>
                    <button class="btn btn-sm px-3 py-2 btn-warning"
                        id="buyNowBtn"
                        <?php if (isset($product['stock']) && $product['stock'] == 0): ?>disabled aria-disabled="true"<?php endif; ?>>
                        <i class="fa fa-credit-card me-2"></i>Buy Now
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="related-products py-5">
    <div class="container">
        <h3 class="mb-4">Related Products</h3>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
            <?php if (!empty($relatedProducts)): ?>
                <?php foreach ($relatedProducts as $rp): ?>
                    <?php
                    if (!empty($rp['image'])) {
                        if (strpos($rp['image'], 'http') === 0) {
                            $rpImg = $rp['image'];
                        } elseif (strpos($rp['image'], 'uploads/products/') === 0) {
                            $rpImg = base_url($rp['image']);
                        } else {
                            $rpImg = base_url('uploads/products/' . $rp['image']);
                        }
                    } else {
                        $rpImg = base_url('uploads/products/no-image.png');
                    }
                    ?>
                    <div class="col">
                        <a href="<?= route_to('customer.product.details') . '?id=' . $rp['product_id'] ?>" class="card h-100 shadow-sm border-0 rounded-4 text-decoration-none text-dark">
                            <img src="<?= esc($rpImg) ?>" class="card-img-top" alt="<?= esc($rp['product_name']) ?>" onerror="this.onerror=null;this.src='<?= base_url('uploads/products/no-image.png') ?>';">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= esc($rp['product_name']) ?></h5>
                                <small class="card-text text-muted mb-2"><?= esc($rp['category_name']) ?></small>
                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <small class="product-price"><i class="fa-solid fa-money-bill-wave"></i> Php <?= esc($rp['price']) ?></small>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info">No related products found.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>
<?= $this->section('scripts'); ?>
<script>
    $(function() {
        // Quantity controls
        var $qtyInput = $('#qty-input');
        $('#qty-minus').on('click', function() {
            var val = parseInt($qtyInput.val()) || 1;
            if (val > 1) $qtyInput.val(val - 1);
        });
        $('#qty-plus').on('click', function() {
            var val = parseInt($qtyInput.val()) || 1;
            $qtyInput.val(val + 1);
        });

        // Add to Cart AJAX (jQuery)
        $('#addToCartBtn').on('click', function() {
            var productId = <?= json_encode($product['product_id'] ?? '') ?>;
            var quantity = parseInt($qtyInput.val()) || 1;
            var $btn = $(this);
            $.ajax({
                url: '<?= base_url('kathys_crochet_flowers/add-to-cart') ?>',
                type: 'POST',
                data: {
                    product_id: productId,
                    quantity: quantity
                },
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        // Update cart count in header if element exists
                        var $cartCountElem = $('.cart-count');
                        if ($cartCountElem.length) {
                            $cartCountElem.text(data.cart_count);
                        }
                        // Update cart dropdown menu in header if backend returns cart_html
                        if (data.cart_html) {
                            window.dispatchEvent(new CustomEvent('cartUpdated', { detail: { cart_html: data.cart_html, cart_count: data.cart_count } }));
                        }
                        // Show a temporary success message without reload
                        var origText = $btn.html();
                        $btn.html('<i class="fa fa-check me-2"></i>Added!').prop('disabled', true);
                        setTimeout(function() {
                            $btn.html(origText).prop('disabled', false);
                        }, 1500);
                    } else {
                        alert(data.message || 'Failed to add to cart.');
                    }
                },
                error: function() {
                    alert('Error adding to cart.');
                }
            });
        });
        // Buy Now AJAX
        $('#buyNowBtn').on('click', function() {
            var productId = <?= json_encode($product['product_id'] ?? '') ?>;
            var quantity = parseInt($('#qty-input').val()) || 1;
            var $btn = $(this);
            $btn.prop('disabled', true);
            $.ajax({
                url: '<?= base_url('kathys_crochet_flowers/buy-now') ?>',
                type: 'POST',
                data: {
                    product_id: productId,
                    quantity: quantity
                },
                dataType: 'json',
                success: function(data) {
                    if (data.success && data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        alert(data.message || 'Failed to proceed to checkout.');
                        $btn.prop('disabled', false);
                    }
                },
                error: function() {
                    alert('Error processing Buy Now.');
                    $btn.prop('disabled', false);
                }
            });
        });
    });
</script>
<?= $this->endSection(); ?>