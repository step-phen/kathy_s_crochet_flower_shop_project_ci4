<header class="header-navbar">
    <div class="header-top-bar d-none d-md-block">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <span>⭐ 0.0/0.0 Based on 0+ Reviews</span>
            </div>
            <div>
                <a href="#" class="text-dark text-decoration-none me-3">FAQ</a>
                <a href="#" class="text-dark text-decoration-none">Track Order</a>
            </div>
        </div>
    </div>

    <div class="header-main">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3 col-md-4">
                    <a href="<?= route_to('customer.home') ?>" class="logo">Kathy's Crochet Flowers Shop</a>
                </div>
                <div class="col-lg-6 col-md-8">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search Flowers, Cakes, Gifts & More">
                        <button class="btn btn-search" type="button">Search</button>
                    </div>
                </div>
                <div class="col-lg-3 d-none d-lg-flex justify-content-end">
                    <!-- User Icons Section: Cart dropdown and user profile link -->
                    <div class="user-icons d-flex align-items-center">
                        <!-- Cart Dropdown: Toggle button with icon and count badge -->
                        <div class="dropdown me-3">
                            <button class="btn btn-link text-dark p-0 position-relative" type="button"
                                id="cartDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                                aria-label="Shopping Cart">
                                <i class="fa-solid fa-cart-shopping fa-lg"></i>
                                <?php
                                $cart = session()->get('cart') ?? [];
                                $cartCount = array_sum(array_column($cart, 'quantity'));
                                ?>
                                <span id="cartCount"
                                    class="badge bg-danger position-absolute top-0 start-100 translate-middle cart-count"
                                    style="font-size: 0.7rem;">
                                    <?= $cartCount ?>
                                </span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end p-3 shadow cart-dropdown-menu" aria-labelledby="cartDropdown">
                                <?php if (!empty($cart)): ?>
                                    <?php $subtotal = 0; ?>
                                    <?php foreach ($cart as $item): ?>
                                        <?php
                                        // Fix image fallback
                                        if (!empty($item['image'])) {
                                            if (strpos($item['image'], 'http') === 0) {
                                                $imgSrc = $item['image'];
                                            } elseif (strpos($item['image'], 'uploads/products/') === 0) {
                                                $imgSrc = base_url($item['image']);
                                            } else {
                                                $imgSrc = base_url('uploads/products/' . $item['image']);
                                            }
                                        } else {
                                            $imgSrc = base_url('uploads/products/no-image.png');
                                        }
                                        $itemTotal = $item['price'] * $item['quantity'];
                                        $subtotal += $itemTotal;
                                        // Example: show stock badge if stock is low (assume $item['stock'] exists)
                                        $lowStock = isset($item['stock']) && $item['stock'] <= 20 && $item['stock'] > 0;
                                        $outOfStock = isset($item['stock']) && $item['stock'] == 0;
                                        ?>
                                        <li class="cart-dropdown-item d-flex align-items-center mb-3 position-relative" data-product-id="<?= esc($item['product_id']) ?>">
                                            <div class="cart-img-box">
                                                <img src="<?= esc($imgSrc) ?>" alt="<?= esc($item['product_name']) ?>" class="cart-img">
                                            </div>
                                            <div class="cart-item-info flex-grow-1 ms-2">
                                                <div class="cart-item-name fw-semibold text-truncate mb-1">
                                                    <?= esc($item['product_name']) ?>
                                                    <?php if ($lowStock): ?>
                                                        <span class="cart-stock-badge badge bg-warning ms-1"><?= esc($item['stock']) ?> Low stock</span>
                                                    <?php endif; ?>
                                                    <?php if ($outOfStock): ?>
                                                        <span class="cart-stock-badge badge bg-danger ms-1">Out of stock</span>
                                                    <?php endif; ?>
                                                </div>
                                                <?php if (!empty($item['description'])): ?>
                                                    <div class="cart-item-desc text-muted">
                                                        <?= esc($item['description']) ?>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="cart-item-meta">
                                                    Qty: <?= esc($item['quantity']) ?>
                                                </div>
                                                <div class="cart-item-total fw-bold mt-1">
                                                    Php <?= esc(number_format($itemTotal, 2)) ?>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-link btn-sm text-danger cart-remove-btn position-absolute top-0 end-0" title="Remove">&times;</button>
                                        </li>
                                    <?php endforeach; ?>
                                    <li class="cart-subtotal border-top pt-3 mt-3 d-flex justify-content-between align-items-center">
                                        <span class="fw-semibold">Sub-total:</span>
                                        <span class="fw-bold text">Php <?= esc(number_format($subtotal, 2)) ?></span>
                                    </li>
                                    <li class="cart-view-row mt-3"><a href="<?= route_to('customer.cart') ?>" class="btn btn-sm btn-primary btn-view-cart">View Cart</a></li>
                                <?php else: ?>
                                    <li id="cart-count" class="small text-muted">Your cart is empty.</li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <!-- User Profile Link -->
                        <div class="dropdown user-dropdown">
                            <a href="#" class="text-dark text-decoration-none" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="fas fa-user fa-lg"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="/profile">
                                        <i class="fas fa-user me-2"></i> Profile
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="<?= route_to('customer.orders') ?>">
                                        <i class="fas fa-shopping-cart me-2"></i> Orders
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="<?= base_url('logout'); ?>">
                                        <i class="fas fa-sign-out-alt me-2"></i> Log Out
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg bg-white main-navbar">
        <div class="container justify-content-center">
            <div class="collapse navbar-collapse flex-grow-0" id="mainNav">
                <ul class="navbar-nav">

                    <li class="nav-item">
                        <a class="nav-link <?= (url_is(base_url('customer/home'))) ? 'active' : '' ?>" href="<?= route_to('customer.home') ?>">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?= (url_is(base_url('customer/products'))) ? 'active' : '' ?>" href="<?= route_to('customer.products') ?>">Products</a>
                    </li>

                    <li class="nav-item"><a class="nav-link" href="#about-us">About Us</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>
    