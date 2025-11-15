<?= $this->extend('staff/layouts/page-layouts') ?>
<?= $this->section('content') ?>

<!-- Page Header -->
<div class="page-header mb-4 p-4 rounded shadow-sm d-flex align-items-center bg-light border">
    <div class="flex-grow-1">
        <h1 class="h2 fw-bold mb-1 page-header-title text-primary">Inventory Management</h1>
        <p class="mb-0 page-header-date text-muted">
            <i class="bi bi-flower1 me-1"></i>
            View current flower stocks, see available flowers, and add new stock.
        </p>
    </div>
</div>

<!-- Inventory Table -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Current Flower Stocks</h5>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="inventoryTable" class="table table-hover table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="align-middle">Flowers</th>
                        <th class="align-middle">Category</th>
                        <th class="align-middle text-center">Stock</th>
                        <th class="align-middle text-start">Price</th>
                        <th class="align-middle text-center">Status</th>
                        <th class="align-middle text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($flowers) && count($flowers) > 0): ?>
                        <?php foreach ($flowers as $flower): ?>
                            <tr>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <?php if (!empty($flower['image'])): ?>
                                            <img src="<?= base_url(esc($flower['image'])) ?>"
                                                alt="Product Image"
                                                style="width:70px;height:70px;object-fit:cover;"
                                                onerror="this.onerror=null;this.src='<?= base_url('assets/images/no-image.png') ?>';">
                                        <?php endif; ?>
                                        <span class="ms-2"><?= esc($flower['product_name']) ?></span>
                                    </div>
                                </td>
                                <td class="align-middle"><?= esc($flower['category']) ?></td>
                                <td class="align-middle text-center"><?= esc($flower['stock']) ?></td>
                                <td class="align-middle text-start">₱<?= esc(number_format($flower['price'], 2)) ?></td>
                                <td>
                                    <?php
                                    $stock = intval($flower['stock']);
                                    if ($stock > 20) {
                                        echo '<span class="badge bg-success">High Stock</span>';
                                    } elseif ($stock > 0) {
                                        echo '<span class="badge bg-warning text-dark">Low Stock</span>';
                                    } else {
                                        echo '<span class="badge bg-danger">Out of Stock</span>';
                                    }
                                    ?>
                                </td>
                                <td class="align-middle text-center">
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#updateStockModal" data-product-id="<?= esc($flower['product_id'] ?? '') ?>" data-product-name="<?= esc($flower['product_name']) ?>" data-current-stock="<?= esc($flower['stock']) ?>">
                                        <i class="bi bi-plus-circle"></i> Add Stock
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted align-middle">No flower items found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<!-- Update Stock Modal -->
<div class="modal fade" id="updateStockModal" tabindex="-1" aria-labelledby="updateStockModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateStockModalLabel">Update Flower Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateStockForm" action="<?= base_url('staff/inventory/update-stock') ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="product_id" id="modalProductId">
                    <div class="mb-3">
                        <label for="modalProductName" class="form-label">Flower Name</label>
                        <input type="text" class="form-control" id="modalProductName" name="product_name" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="modalCurrentStock" class="form-label">Current Stock</label>
                        <input type="number" class="form-control" id="modalCurrentStock" name="current_stock" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="modalAddStock" class="form-label">Add Stock</label>
                        <input type="number" class="form-control" id="modalAddStock" name="add_stock" min="1" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Stock</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        $('#inventoryTable').DataTable({
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50, 100],
            language: {
                search: "Search:",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                paginate: {
                    previous: "Prev",
                    next: "Next"
                }
            }
        });
        // Pass data to modal on button click (jQuery version)
        $('#updateStockModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var productId = button.data('product-id');
            var productName = button.data('product-name');
            var currentStock = button.data('current-stock');
            $('#modalProductId').val(productId);
            $('#modalProductName').val(productName);
            $('#modalCurrentStock').val(currentStock);
            $('#modalAddStock').val('');
        });

        // AJAX submit for update stock
        $('#updateStockForm').on('submit', function(e) {
            e.preventDefault();
            var $form = $(this);
            var productId = $('#modalProductId').val();
            var addStock = $('#modalAddStock').val();
            var $modal = $('#updateStockModal');
            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: $form.serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Find the table row and update stock cell
                        var $row = $('button[data-product-id="' + productId + '"]').closest('tr');
                        var $stockCell = $row.find('td').eq(2);
                        $stockCell.text(response.new_stock);

                        // Update badge
                        var $badgeCell = $row.find('td').eq(4);
                        var stock = parseInt(response.new_stock);
                        if (stock > 20) {
                            $badgeCell.html('<span class="badge bg-success">High Stock</span>');
                        } else if (stock > 0) {
                            $badgeCell.html('<span class="badge bg-warning text-dark">Low Stock</span>');
                        } else {
                            $badgeCell.html('<span class="badge bg-danger">Out of Stock</span>');
                        }

                        // Update modal current stock
                        $('#modalCurrentStock').val(response.new_stock);

                        // Hide modal
                        $modal.modal('hide');

                        // SweetAlert success
                        Swal.fire({
                            icon: 'success',
                            title: 'Stock Updated!',
                            text: 'Flower stock has been updated successfully.',
                            timer: 1800,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Update Failed',
                            text: response.message || 'Failed to update stock.'
                        });

                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error updating stock.'
                    });
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>