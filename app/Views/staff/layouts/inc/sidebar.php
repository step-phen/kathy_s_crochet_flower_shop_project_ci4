<!-- Sidebar -->
<nav id="sidebar" class="sidebar">
    <div class="sidebar-header">
        <div class="d-flex align-items-center gap-2">
            <div class="logo-icon">
                <img src="/assets/images/logo.png" alt="Kathy's Crochet Flower Shop Logo" width="36" height="36"
                    style="object-fit: contain;">
            </div>
            <div>
                <h5 class="mb-0">Kathy's Crochet Flower Shop</h5>
                <small class="text-muted">Staff Dashboard</small>
            </div>
        </div>
    </div>
    <ul class="list-unstyled components">
        <li class="<?= (url_is(route_to('staff.dashboard'))) ? 'active' : '' ?> ">
            <a href="<?= route_to('staff.dashboard') ?>" data-testid="link-dashboard">
            <i class="bi bi-speedometer"></i>
            <span>Dashboard</span>
            </a>
        </li>
        <li class="<?= (url_is(route_to('staff.inventory'))) ? 'active' : '' ?> ">
            <a href="<?= route_to('staff.inventory') ?>" data-testid="link-products">
            <i class="bi bi-basket-fill"></i>
            <span>Manage Inventory</span>
            </a>
        </li>
        <li class="<?= (url_is(route_to('staff.reports'))) ? 'active' : '' ?> ">
            <a href="<?= route_to('staff.reports') ?>" data-testid="link-sales-report">
            <i class="bi bi-file-earmark-bar-graph"></i>
            <span>Reports</span>
            </a>
        </li>
    </ul>
</nav>