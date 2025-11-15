<?= $this->extend('staff/layouts/page-layouts') ?>
<?= $this->section('content') ?>

<!-- Page Header -->
<div class="page-header mb-2 p-4 rounded shadow-sm d-flex align-items-center bg-light">
  <div class="flex-grow-1">
    <h1 class="h2 fw-bold mb-1 page-header-title text-primary">Staff Dashboard Overview</h1>
    <p class="mb-0 page-header-date text-muted">
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
            <i class="bi bi-flower1"></i>
          </div>
          <div>
            <small class="text-muted d-block mb-1">Flower Stock</small>
            <h5 class="fw-bold mb-0" data-testid="stat-total-flower-stock">
              <?= esc($stats['total_flower_stock'] ?? 0) ?>
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
            <i class="bi bi-exclamation-triangle"></i>
          </div>
          <div>
            <small class="text-muted d-block mb-1">Low Stock</small>
            <h5 class="fw-bold mb-0" data-testid="stat-low-stock">
              <?= esc($stats['low_stock'] ?? 0) ?>
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
          <div class="stat-icon bg-danger-soft text-danger me-3">
            <i class="bi bi-x-circle"></i>
          </div>
          <div>
            <small class="text-muted d-block mb-1">Out of Stock</small>
            <h5 class="fw-bold mb-0" data-testid="stat-out-of-stock">
              <?= esc($stats['out_of_stock'] ?? 0) ?>
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
          <div class="stat-icon bg-info-soft text-info me-3">
            <i class="bi bi-box-seam"></i>
          </div>
          <div>
            <small class="text-muted d-block mb-1">Inventory</small>
            <h5 class="fw-bold mb-0" data-testid="stat-inventory-items">
              <?= esc($stats['inventory_items'] ?? 0) ?>
            </h5>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>