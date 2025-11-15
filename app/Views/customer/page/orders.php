<?= $this->extend('customer/layouts/page-layout'); ?>
<?= $this->section('content'); ?>

<section class="orders-section py-5 bg-light">
    <div class="container">
        <div class="orders-header text-center mb-4">
            <h2 class="fw-bold"><span class="me-2">🛍️</span>My Orders</h2>
            <p class="text-muted">Track and manage all your orders in one place</p>
        </div>

        <?php if (!empty($orders)): ?>
            <div class="card shadow-lg mb-5" style="max-width: 1200px; margin: 0 auto;">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table id="ordersTable" class="table table-striped align-middle table-bordered" style="font-size: 1.15rem;">
                            <thead class="table-dark">
                                <tr style="font-size: 1.2rem;">
                                    <th style="width: 120px;">Order #</th>
                                    <th style="width: 180px;">Date</th>
                                    <th style="width: 160px;">Total</th>
                                    <th style="width: 160px;">Payment</th>
                                    <th style="width: 180px;">Status</th>
                                    <th style="width: 200px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): ?>
                                    <tr style="height: 70px;">
                                        <td><span class="order-id fw-semibold" style="font-size: 1.15rem;">#<?= esc($order['order_id']) ?></span></td>
                                        <td style="font-size: 1.1rem;"><?= date('M d, Y', strtotime($order['created_at'])) ?></td>
                                        <td><span class="order-total text-success fw-bold" style="font-size: 1.15rem;">₱<?= number_format($order['total'], 2) ?></span></td>
                                        <td><span class="badge bg-primary" style="font-size: 1rem; padding: 0.6em 1em;"><?= strtoupper($order['payment_method']) ?></span></td>
                                        <td>
                                            <?php if ($order['status'] === 'pending_verification'): ?>
                                                <span class="badge bg-warning text-dark" style="font-size: 1rem; padding: 0.6em 1em;">Pending Verification</span>
                                            <?php elseif ($order['status'] === 'pending'): ?>
                                                <span class="badge bg-secondary" style="font-size: 1rem; padding: 0.6em 1em;">Pending</span>
                                            <?php elseif ($order['status'] === 'preparing'): ?>
                                                <span class="badge bg-warning text-dark" style="font-size: 1rem; padding: 0.6em 1em;">Preparing</span>
                                            <?php elseif ($order['status'] === 'shipped'): ?>
                                                <span class="badge bg-info text-dark" style="font-size: 1rem; padding: 0.6em 1em;">Shipped</span>
                                            <?php elseif ($order['status'] === 'delivered'): ?>
                                                <span class="badge bg-success" style="font-size: 1rem; padding: 0.6em 1em;">Delivered</span>
                                            <?php elseif ($order['status'] === 'cancelled'): ?>
                                                <span class="badge bg-danger" style="font-size: 1rem; padding: 0.6em 1em;">Cancelled</span>
                                            <?php else: ?>
                                                <span class="badge bg-light text-dark" style="font-size: 1rem; padding: 0.6em 1em;">Processing</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column gap-2">

                                                <?php
                                                // Show Cancel button only for orders that are not cancelled or delivered
                                                $canCancel = !in_array($order['status'], ['cancelled', 'delivered']);
                                                if ($canCancel): ?>
                                                    <button type="button"
                                                        class="btn btn-outline-danger btn-sm rounded-pill cancel-order-btn"
                                                        style="font-size: 1rem;"
                                                        data-order-id="<?= esc($order['order_id']) ?>"
                                                        data-status="<?= esc($order['status']) ?>">
                                                        <i class="bi bi-x-circle"></i> Cancel Order
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <div class="empty-state-icon display-4 mb-3">📦</div>
                    <h3 class="fw-bold mb-2">No Orders Yet</h3>
                    <p class="text-muted mb-4">You haven't placed any orders yet. Start shopping to see your orders here!</p>
                    <a href="<?= site_url('kathys_crochet_flowers/products') ?>" class="btn btn-success btn-lg rounded-pill">
                        <i class="bi bi-cart-plus"></i> Start Shopping
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>



<?= $this->endSection(); ?>

<?= $this->section('styles'); ?>
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<style>
    .modal-xl {
        max-width: 1140px;
    }
    .order-item-img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
    }
</style>
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize DataTable only if jQuery and table exist
        if (typeof jQuery !== 'undefined' && $('#ordersTable').length) {
            $('#ordersTable').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "order": [[1, "desc"]],
                "language": {
                    "search": "Search orders:",
                    "lengthMenu": "Show _MENU_ orders per page",
                    "info": "Showing _START_ to _END_ of _TOTAL_ orders",
                    "infoEmpty": "No orders to show",
                    "infoFiltered": "(filtered from _MAX_ total orders)",
                    "paginate": {
                        "first": "First",
                        "last": "Last",
                        "next": "Next",
                        "previous": "Previous"
                    }
                }
            });
        }



        // Cancel Order button handler
        document.querySelectorAll('.cancel-order-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var orderId = this.getAttribute('data-order-id');
                if (confirm('Are you sure you want to cancel this order? This action cannot be undone.')) {
                    // Disable button to prevent double submission
                    btn.disabled = true;
                    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Cancelling...';
                    
                    fetch('<?= site_url('kathys_crochet_flowers/cancel-order') ?>', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: 'order_id=' + encodeURIComponent(orderId)
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                alert(data.message || 'Order cancelled successfully!');
                                location.reload();
                            } else {
                                alert(data.message || 'Failed to cancel order.');
                                // Re-enable button on error
                                btn.disabled = false;
                                btn.innerHTML = '<i class="bi bi-x-circle"></i> Cancel Order';
                            }
                        })
                        .catch(function(error) {
                            console.error('Error:', error);
                            alert('Failed to cancel order. Please try again.');
                            // Re-enable button on error
                            btn.disabled = false;
                            btn.innerHTML = '<i class="bi bi-x-circle"></i> Cancel Order';
                        });
                }
            });
        });
    });
</script>
<?= $this->endSection(); ?>