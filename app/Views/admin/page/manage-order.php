<?= $this->extend('admin/layouts/page-layout') ?>
<?= $this->section('content') ?>

<section class="orders py-5">
	<div class="container-fluid">
		<div class="d-flex justify-content-between align-items-center mb-4">
			<h2>Manage Orders</h2>
		</div>

		<?php if (!empty($orders)): ?>
			<div class="table-responsive">
				<table class="table table-hover table-striped table-bordered b table-sm align-middle">
					<thead class="table-light">
						<tr>
							<th>Order ID</th>
							<th>Customer</th>
							<th>Date</th>
							<th>Total</th>
							<th>Payment</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($orders as $order): ?>
							<tr data-order-id="<?= esc($order['order_id']) ?>">
								<td><?= esc($order['order_id']) ?></td>
								<td><?= esc($order['name']) ?><br><small><?= esc($order['email']) ?></small></td>
								<td><?= date('Y-m-d', strtotime($order['created_at'])) ?></td>
								<td>₱<?= number_format($order['total'], 2) ?></td>
								<td>
									<div>
										<?= strtoupper($order['payment_method']) ?>
										<?php if ($order['payment_method'] === 'gcash' && $order['status'] === 'pending_verification'): ?>
											<br><small class="text-warning"><i class="bi bi-exclamation-circle"></i> Needs Verification</small>
										<?php endif; ?>
									</div>

								</td>
								<td>
									<div class="d-flex align-items-center gap-2">
										<select class="form-select form-select-sm order-status-select" style="width:auto;min-width:140px;"
											data-order-id="<?= esc($order['order_id']) ?>"
											data-payment-method="<?= esc($order['payment_method']) ?>"
											<?php
											$disableSelect = ($order['status'] === 'cancelled' || $order['status'] === 'delivered');
											if ($order['payment_method'] === 'gcash' && $order['status'] === 'pending_verification') {
												$disableSelect = false;
											}
											echo $disableSelect ? 'disabled' : '';
											?>>
											<?php if ($order['payment_method'] === 'gcash'): ?>
												<option value="pending_verification" <?= $order['status'] === 'pending_verification' ? 'selected' : '' ?>>Pending Verification</option>
											<?php endif; ?>
											<option value="pending" <?= $order['status'] === 'pending' ? 'selected' : '' ?> <?= ($order['payment_method'] === 'gcash' && $order['status'] === 'pending_verification') ? '' : '' ?>>Pending</option>
											<option value="preparing" <?= $order['status'] === 'preparing' ? 'selected' : '' ?> <?= ($order['status'] === 'pending_verification') ? 'disabled' : '' ?>>Preparing</option>
											<option value="shipped" <?= $order['status'] === 'shipped' ? 'selected' : '' ?> <?= ($order['status'] === 'pending_verification') ? 'disabled' : '' ?>>Shipped</option>
											<option value="delivered" <?= $order['status'] === 'delivered' ? 'selected' : '' ?> <?= ($order['status'] === 'pending_verification') ? 'disabled' : '' ?>>Delivered</option>
											<option value="cancelled" <?= $order['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
										</select>
										<span class="badge order-status-badge">
											<?php if ($order['status'] === 'pending_verification'): ?>
												<span class="badge bg-warning text-dark">Pending Verification</span>
											<?php elseif ($order['status'] === 'pending'): ?>
												<span class="badge bg-secondary">Pending</span>
											<?php elseif ($order['status'] === 'preparing'): ?>
												<span class="badge bg-warning text-dark">Preparing</span>
											<?php elseif ($order['status'] === 'shipped'): ?>
												<span class="badge bg-info text-dark">Shipped</span>
											<?php elseif ($order['status'] === 'delivered'): ?>
												<span class="badge bg-success">Delivered</span>
											<?php elseif ($order['status'] === 'cancelled'): ?>
												<span class="badge bg-danger">Cancelled</span>
											<?php else: ?>
												<span class="badge bg-light text-dark">Other</span>
											<?php endif; ?>
										</span>
									</div>
								</td>
								<td>
									<button class="btn btn-sm btn-outline-primary view-order-btn" data-order-id="<?= esc($order['order_id']) ?>">
										<i class="bi bi-eye"></i> View
									</button>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		<?php else: ?>
			<div class="alert alert-info">No orders found.</div>
		<?php endif; ?>
	</div>
</section>

<!-- Order Details Modal -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="orderDetailsModalLabel">Order Details</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body" id="orderDetailsContent">
				<div class="text-center py-5">
					<div class="spinner-border text-primary" role="status">
						<span class="visually-hidden">Loading...</span>
					</div>
					<p class="mt-2">Loading order details...</p>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- Receipt Image Modal -->
<div class="modal fade" id="receiptImageModal" tabindex="-1" aria-labelledby="receiptImageModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="receiptImageModalLabel">GCash Receipt</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body text-center">
				<img id="receiptImagePreview" src="" alt="GCash Receipt" class="img-fluid" style="max-height: 70vh;">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
	document.addEventListener('DOMContentLoaded', function() {
		// Status update AJAX
		document.querySelectorAll('.order-status-select').forEach(function(select) {
			select.addEventListener('change', function() {
				var orderId = this.getAttribute('data-order-id');
				var newStatus = this.value;
				var paymentMethod = this.getAttribute('data-payment-method');
				var row = this.closest('tr');
				var badgeCell = row.querySelector('.order-status-badge');
				var paymentBadgeCell = row.querySelector('.payment-status-badge');
				var originalStatus = this.getAttribute('data-original-status') || this.value;

				if (!this.getAttribute('data-original-status')) {
					this.setAttribute('data-original-status', originalStatus);
				}

				this.disabled = true;

				fetch('<?= site_url('admin/updateOrderStatus') ?>', {
						method: 'POST',
						headers: {
							'Content-Type': 'application/x-www-form-urlencoded',
							'X-Requested-With': 'XMLHttpRequest'
						},
						body: 'order_id=' + orderId + '&status=' + newStatus
					})
					.then(response => response.json())
					.then(data => {
						if (data.status === 'success') {
							// Update order status badge
							var statusBadgeHtml = '';
							switch (data.order.status) {
								case 'pending_verification':
									statusBadgeHtml = '<span class="badge bg-warning text-dark">Pending Verification</span>';
									break;
								case 'pending':
									statusBadgeHtml = '<span class="badge bg-secondary">Pending</span>';
									break;
								case 'preparing':
									statusBadgeHtml = '<span class="badge bg-warning text-dark">Preparing</span>';
									break;
								case 'shipped':
									statusBadgeHtml = '<span class="badge bg-info text-dark">Shipped</span>';
									break;
								case 'delivered':
									statusBadgeHtml = '<span class="badge bg-success">Delivered</span>';
									break;
								case 'cancelled':
									statusBadgeHtml = '<span class="badge bg-danger">Cancelled</span>';
									break;
								default:
									statusBadgeHtml = '<span class="badge bg-light text-dark">Other</span>';
							}
							badgeCell.innerHTML = statusBadgeHtml;



							select.setAttribute('data-original-status', data.order.status);

							if (data.order.status === 'delivered' || data.order.status === 'cancelled') {
								select.disabled = true;
							} else {
								select.disabled = false;
							}

							// Show success message
							if (window.Swal) {
								Swal.fire({
									icon: 'success',
									title: 'Success!',
									text: 'Order status updated successfully!',
									timer: 2000,
									showConfirmButton: false
								});
							} else {
								alert('Order status updated successfully!');
							}
						} else {
							select.value = originalStatus;
							if (window.Swal) {
								Swal.fire({
									icon: 'error',
									title: 'Error',
									text: data.message || 'Failed to update status.'
								});
							} else {
								alert(data.message || 'Failed to update status.');
							}
							select.disabled = false;
						}
					})
					.catch(error => {
						console.error('Error:', error);
						select.value = originalStatus;
						if (window.Swal) {
							Swal.fire({
								icon: 'error',
								title: 'Error',
								text: 'Failed to update status. Please try again.'
							});
						} else {
							alert('Failed to update status. Please try again.');
						}
						select.disabled = false;
					});
			});
		});

		// View Order Details Modal
		document.querySelectorAll('.view-order-btn').forEach(function(btn) {
			btn.addEventListener('click', function() {
				var orderId = this.getAttribute('data-order-id');
				var modal = new bootstrap.Modal(document.getElementById('orderDetailsModal'));
				var modalContent = document.getElementById('orderDetailsContent');

				// Show loading state
				modalContent.innerHTML = `
					<div class="text-center py-5">
						<div class="spinner-border text-primary" role="status">
							<span class="visually-hidden">Loading...</span>
						</div>
						<p class="mt-2">Loading order details...</p>
					</div>
				`;

				modal.show();

				// Fetch order details
				fetch('<?= site_url('admin/getOrderDetails') ?>?order_id=' + orderId, {
						method: 'GET',
						headers: {
							'X-Requested-With': 'XMLHttpRequest'
						}
					})
					.then(response => response.json())
					.then(data => {
						if (data.status === 'success') {
							var order = data.order;
							var items = data.items;
							var address = data.address;

							// Build status badge
							var statusBadge = '';
							switch (order.status) {
								case 'pending_verification':
									statusBadge = '<span class="badge bg-warning text-dark">Pending Verification</span>';
									break;
								case 'pending':
									statusBadge = '<span class="badge bg-secondary">Pending</span>';
									break;
								case 'preparing':
									statusBadge = '<span class="badge bg-warning text-dark">Preparing</span>';
									break;
								case 'shipped':
									statusBadge = '<span class="badge bg-info text-dark">Shipped</span>';
									break;
								case 'delivered':
									statusBadge = '<span class="badge bg-success">Delivered</span>';
									break;
								case 'cancelled':
									statusBadge = '<span class="badge bg-danger">Cancelled</span>';
									break;
								default:
									statusBadge = '<span class="badge bg-light text-dark">Unknown</span>';
							}



							// Build items table
							var itemsHtml = '';
							var subtotal = 0;
							items.forEach(function(item) {
								var itemTotal = item.quantity * item.price;
								subtotal += itemTotal;
								var imgSrc = item.image ? '<?= base_url() ?>/' + item.image : '<?= base_url('uploads/products/default.png') ?>';
								itemsHtml += `
								<tr>
									<td>
										<div class="d-flex align-items-center gap-2">
											<img src="${imgSrc}" alt="${item.product_name}" style="width:50px;height:50px;object-fit:cover;" class="rounded">
											<span>${item.product_name}</span>
										</div>
									</td>
									<td>₱${parseFloat(item.price).toFixed(2)}</td>
									<td>${item.quantity}</td>
									<td>₱${itemTotal.toFixed(2)}</td>
								</tr>
							`;
							});

							// Build GCash payment verification section
							var gcashSection = '';
							if (order.payment_method === 'gcash') {
								var referenceNumber = order.gcash_reference || 'N/A';
								var receiptImg = order.gcash_image ? '<?= base_url() ?>/' + order.gcash_image : '';
								gcashSection = `
								<div class="mb-3">
									<h6 class="text-muted mb-2">
										<i class="bi bi-credit-card-2-front"></i> GCash Payment Verification
										${order.status === 'pending_verification' ? '<span class="badge bg-warning text-dark ms-2">Needs Verification</span>' : ''}
									</h6>
									<div class="card border-warning">
										<div class="card-body">
											<div class="row">
												<div class="col-md-6">
													<p class="mb-2"><strong>Reference Number:</strong></p>
													<p class="mb-3 fs-5 text-primary fw-bold">${referenceNumber}</p>

													<p class="mb-2"><strong>Order Date:</strong></p>
													<p class="mb-0">${order.created_at ? new Date(order.created_at).toLocaleString() : 'N/A'}</p>
												</div>
												<div class="col-md-6">
													<p class="mb-2"><strong>Receipt Image:</strong></p>
													${receiptImg ? `
														<div class="position-relative" style="max-width: 300px;">
															<img src="${receiptImg}" alt="GCash Receipt" class="img-fluid rounded border" style="cursor: pointer; max-height: 200px;" onclick="showReceiptImage('${receiptImg}')">
															<button class="btn btn-sm btn-primary position-absolute bottom-0 end-0 m-2" onclick="showReceiptImage('${receiptImg}')">
																<i class="bi bi-zoom-in"></i> View Full Size
															</button>
														</div>
													` : '<p class="text-muted">No receipt uploaded</p>'}
												</div>
											</div>
											${order.status === 'pending_verification' ? `
												<div class="mt-3 pt-3 border-top">
													<p class="mb-2 text-warning"><i class="bi bi-exclamation-triangle-fill"></i> <strong>Action Required:</strong></p>
													<p class="mb-0 small">Please verify the reference number and receipt image. Update the order status to "Pending" to approve or "Cancelled" to reject.</p>
												</div>
											` : ''}
										</div>
									</div>
								</div>
							`;
							}

							// Build modal content
							var content = `
							<div class="row">
								<div class="col-md-6 mb-3">
									<h6 class="text-muted mb-2">Order Information</h6>
									<div class="card">
										<div class="card-body">
											<p class="mb-2"><strong>Order ID:</strong> ${order.order_id}</p>
											<p class="mb-2"><strong>Date:</strong> ${new Date(order.created_at).toLocaleString()}</p>
											<p class="mb-2"><strong>Status:</strong> ${statusBadge}</p>
											<p class="mb-2"><strong>Payment Method:</strong> ${order.payment_method.toUpperCase()}</p>

										</div>
									</div>
								</div>
								<div class="col-md-6 mb-3">
									<h6 class="text-muted mb-2">Customer Information</h6>
									<div class="card">
										<div class="card-body">
											<p class="mb-2"><strong>Name:</strong> ${order.name}</p>
											<p class="mb-0"><strong>Email:</strong> ${order.email}</p>
										</div>
									</div>
								</div>
							</div>

							${address ? `
							<div class="mb-3">
								<h6 class="text-muted mb-2">Shipping Address</h6>
								<div class="card">
									<div class="card-body">
										<p class="mb-1">${address.address}</p>
										<p class="mb-0">${address.city}, ${address.province} ${address.postal_code}</p>
									</div>
								</div>
							</div>
							` : ''}

							${gcashSection}

							<div class="mb-3">
								<h6 class="text-muted mb-2">Order Items</h6>
								<div class="table-responsive">
									<table class="table table-sm">
										<thead class="table-light">
											<tr>
												<th>Product</th>
												<th>Price</th>
												<th>Quantity</th>
												<th>Total</th>
											</tr>
										</thead>
										<tbody>
											${itemsHtml}
										</tbody>
										<tfoot>
											<tr>
												<td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
												<td><strong>₱${subtotal.toFixed(2)}</strong></td>
											</tr>
											<tr>
												<td colspan="3" class="text-end"><strong>Shipping:</strong></td>
												<td><strong>₱${parseFloat(order.shipping_fee || 0).toFixed(2)}</strong></td>
											</tr>
											<tr class="table-active">
												<td colspan="3" class="text-end"><strong>Grand Total:</strong></td>
												<td><strong class="text-primary">₱${parseFloat(order.total).toFixed(2)}</strong></td>
											</tr>
										</tfoot>
									</table>
								</div>
							</div>
						`;

							modalContent.innerHTML = content;
						} else {
							modalContent.innerHTML = `
							<div class="alert alert-danger">
								<i class="bi bi-exclamation-triangle"></i> ${data.message || 'Failed to load order details'}
							</div>
						`;
						}
					})
					.catch(error => {
						console.error('Error:', error);
						modalContent.innerHTML = `
						<div class="alert alert-danger">
							<i class="bi bi-exclamation-triangle"></i> Failed to load order details. Please try again.
						</div>
					`;
					});
			});
		});
	});

	// Function to show receipt image in full size
	function showReceiptImage(imageSrc) {
		var receiptModal = new bootstrap.Modal(document.getElementById('receiptImageModal'));
		document.getElementById('receiptImagePreview').src = imageSrc;
		receiptModal.show();
	}
</script>

<?= $this->endSection() ?>