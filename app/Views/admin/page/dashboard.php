<?= $this->extend('admin/layouts/page-layout') ?>
<?= $this->section('content') ?>


<!-- Page Header -->
<div class="page-header mb-2 p-4 rounded shadow-sm d-flex align-items-center">
    <div class="flex-grow-1">
        <h1 class="h2 fw-bold mb-1 page-header-title">Dashboard Overview</h1>
        <p class="mb-0 page-header-date">
            <i class="bi bi-calendar3 me-1"></i>
            Today: <span id="currentDate"></span>
        </p>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-primary-soft text-primary me-3">
                        <i class="bi bi-people"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block mb-1">Customers</small>
                        <h5 class="fw-bold mb-0" data-testid="stat-total-users">
                            <?= esc($stats['total_users'] ?? 0) ?>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-success-soft text-success me-3">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block mb-1">Products</small>
                        <h5 class="fw-bold mb-0" data-testid="stat-total-products">
                            <?= esc($stats['total_products'] ?? 0) ?>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-warning-soft text-warning me-3">
                        <i class="bi bi-cart"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block mb-1">Total Orders</small>
                        <h5 class="fw-bold mb-0" data-testid="stat-total-orders">0</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-info-soft text-info me-3">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block mb-1">Total Revenue</small>
                        <h5 class="fw-bold mb-0" data-testid="stat-revenue">₱0</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>