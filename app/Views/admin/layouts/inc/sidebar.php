<nav id="sidebar" class="sidebar">
    <div class="sidebar-header">
        <div class="d-flex align-items-center gap-2">
            <div class="logo-icon">
                <img src="/assets/images/logo.png" alt="Kathy's Crochet Flower Shop Logo" width="36" height="36"
                    style="object-fit: contain;">
            </div>
            <div>
                <h5 class="mb-0">Kathy's Crochet Flower Shop</h5>
                <small class="text-muted">Admin Dashboard</small>
            </div>
        </div>
    </div>
    <ul class="list-unstyled components">
        <li class="<?= (url_is(route_to('admin.dashboard'))) ? 'active' : '' ?>">
            <a href="<?= route_to('admin.dashboard') ?>" data-testid="link-dashboard" title="Dashboard">
            <i class="bi bi-grid-fill"></i>
            <span>Dashboard</span>
            </a>
        </li>
        <li class="menu-section">User Management</li>
        <li class="<?= (url_is(route_to('admin.manage'))) ? 'active' : '' ?>">
            <a href="<?= route_to('admin.manage') ?>" data-testid="link-users">
            <i class="bi bi-person-badge-fill"></i>
            <span>Manage Staff</span>
            </a>
        </li>
        <li class="<?= (url_is(route_to('admin.customer.list'))) ? 'active' : '' ?>">
            <a href="<?= route_to('admin.customer.list') ?>" data-testid="link-users">
                <i class="bi bi-person-lines-fill"></i>
                <span>Customer List</span>
            </a>
        </li>
        <li class="menu-divider"></li>
        <li class="<?= (url_is(route_to('admin.product'))) ? 'active' : '' ?>">
            <a href="<?= route_to('admin.product') ?>" data-testid="link-products">
                <i class="bi bi-box-seam-fill"></i>
                <span>Product Management</span>
            </a>
        </li>

        <li class="<?= (url_is(route_to('admin.orders'))) ? 'active' : '' ?>">
            <a href="<?= route_to('admin.orders') ?>" data-testid="link-orders">
                <i class="bi bi-cart-fill"></i>
                <span>Manage Orders</span>
            </a>
        </li>
        <li class="<?= (url_is(route_to('admin.sales.reports'))) ? 'active' : '' ?>">
            <a href="<?= route_to('admin.sales.reports') ?>" data-testid="link-sales-report">
                <i class="bi bi-graph-up"></i>
                <span>Sales Report</span>
            </a>
        </li>
    </ul>
</nav>