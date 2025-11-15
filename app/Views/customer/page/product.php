<?= $this->extend('customer/layouts/page-layout'); ?>
<?= $this->section('content'); ?>

<section class="products py-5">
    <div class="container">
        <!-- Breadcrumb Navigation -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb bg-transparent p-0">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Products</li>
            </ol>
        </nav>
        <div class="row g-4">
            <!-- Sidebar / Filters -->
            <aside class="col-lg-3">
                <div class="card mb-3 shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <h5 class="card-title">Filter</h5>
                        <form id="productFilterForm">
                            <div class="mb-3">
                                <label class="form-label">Category</label>
                                <select class="form-select" name="category_id" id="filterCategory">
                                    <option value="">All</option>
                                    <?php if (!empty($categories)): ?>
                                        <?php foreach ($categories as $cat): ?>
                                            <option value="<?= esc($cat['category_id']) ?>">
                                                <?= isset($cat['category_name']) ? esc($cat['category_name']) : 'Unknown' ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Price</label>
                                <select class="form-select" name="price_range" id="filterPrice">
                                    <option value="">All</option>
                                    <option value="under500">Under ₱500</option>
                                    <option value="500-1500">₱500 - ₱1,500</option>
                                    <option value="above1500">Above ₱1,500</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-outline-secondary w-100">Apply</button>
                        </form>
                    </div>
                </div>

                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Top Picks</h6>
                        <ul class="list-unstyled mb-0">
                            <li class="py-2 border-bottom"><a href="#" class="text-decoration-none">Best Seller
                                    Bouquet</a>
                            </li>
                            <li class="py-2 border-bottom"><a href="#" class="text-decoration-none">Romantic
                                    Roses</a>
                            </li>
                            <li class="py-2"><a href="#" class="text-decoration-none">Sympathy Arrangement</a></li>
                        </ul>
                    </div>
                </div>
            </aside>

            <!-- Product Grid -->
            <div class="col-lg-9">
                <div id="productGrid" class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4 product-grid-tight">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <div class="col">
                                <?php $isOutOfStock = isset($product['stock']) && $product['stock'] == 0; ?>
                                <div class="card h-100 shadow-sm border-0 rounded-4 text-dark position-relative <?= $isOutOfStock ? 'bg-light' : '' ?>" style="<?= $isOutOfStock ? 'pointer-events: none; opacity: 0.6;' : '' ?>">
                                    <a href="<?= $isOutOfStock ? 'javascript:void(0);' : (route_to('customer.product.details') . '?id=' . $product['product_id']) ?>" class="text-decoration-none text-dark" tabindex="<?= $isOutOfStock ? '-1' : '0' ?>">
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
                                            $imgSrc = base_url('uploads/products/default.png');
                                        }
                                        ?>
                                        <img src="<?= esc($imgSrc) ?>" class="card-img-top" alt="<?= esc($product['product_name']) ?>" onerror="this.onerror=null;this.src='<?= base_url('uploads/products/default.png') ?>';">
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title mb-1"><?= esc($product['product_name']) ?></h5>
                                            <small class="card-text text-muted mb-2"><?= esc($product['category_name']) ?></small>
                                            <?php if ($isOutOfStock): ?>
                                                <span class="badge bg-danger mb-2">Out of Stock</span>
                                            <?php endif; ?>
                                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                                <small class="product-price"><i class="fa-solid fa-money-bill-wave"></i> Php <?= esc($product['price']) ?></small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="alert alert-warning">No products found.</div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>
<?= $this->section('scripts'); ?>
<script>
    $(function() {
        $('#productFilterForm').on('submit', function(e) {
            e.preventDefault();
            var category_id = $('#filterCategory').val();
            var price_range = $('#filterPrice').val();
            $.ajax({
                url: "products/filter",
                method: "POST",
                data: {
                    category_id: category_id,
                    price_range: price_range
                },
                success: function(response) {
                    $('#productGrid').html(response);
                },
                error: function() {
                    $('#productGrid').html('<div class="col-12"><div class="alert alert-danger">Failed to load products.</div></div>');
                }
            });
        });
    });
</script>
<?= $this->endSection(); ?>