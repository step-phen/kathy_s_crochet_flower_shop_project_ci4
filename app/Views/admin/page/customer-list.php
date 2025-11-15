<?= $this->extend('admin/layouts/page-layout') ?>

<?= $this->section('content') ?>

<div class="mb-4 d-flex justify-content-between align-items-center">
	<div>
		<h1 class="h2 fw-bold mb-1">Customer Management</h1>
		<p class="text-muted mb-0">
			<i class="bi bi-people me-1"></i>
			View and manage your customers
		</p>
	</div>
</div>

<div class="row">
	<div class="col-12">
		<div class="card border-0 shadow-sm">
			<div class="card-header bg-white">
				<h5 class="mb-0 fw-semibold">Customer List</h5>
			</div>
			<div class="card-body p-0">
				<div class="table-responsive">
					<table id="customerTable" class="table table-striped mb-0">
						<thead class="table-light">
							<tr>
								<th class="text-start">ID</th>
								<th>Image</th>
								<th class="text-start">Name</th>
								<th>Email</th>
								<th>Role</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if (!empty($customers) && is_array($customers)):
								foreach ($customers as $c):
							?>
									<tr>
										<td class="text-start"><?= esc($c['user_id'] ?? $c['id'] ?? 'N/A') ?></td>
										<td>
											<?php
											$imgSrc = base_url('uploads/users/default-avatar.png');
											if (!empty($c['image'])) {
												if (strpos($c['image'], 'uploads/users/') === 0) {
													$imgSrc = base_url($c['image']);
												} else {
													$imgSrc = base_url('uploads/users/' . $c['image']);
												}
											}
											?>
											<img src="<?= esc($imgSrc) ?>" alt="Profile" class="rounded-circle" style="width:40px;height:40px;object-fit:cover;">
										</td>
										<td class="text-start"><?= esc($c['name'] ?? '') ?></td>
										<td><?= esc($c['email'] ?? '') ?></td>
										<td><?= esc($c['role'] ?? 'N/A') ?></td>
										<td>
											<?php if (($c['status'] ?? 0) == 1): ?>
												<span class="badge" style="background-color:#198754;color:#fff;">Active</span>
											<?php else: ?>
												<span class="badge" style="background-color:#6c757d;color:#fff;">Inactive</span>
											<?php endif; ?>
										</td>
									</tr>
							<?php
								endforeach;
							else:
							?>
								<tr>
									<td colspan="6" class="text-center">No customers found.</td>
								</tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
	function initCustomerTableDataTable() {
		if (window.jQuery && $.fn.dataTable) {
			if (window._customerDataTable) {
				try {
					window._customerDataTable.destroy();
				} catch (e) {}
			}
			window._customerDataTable = $('#customerTable').DataTable({
				pageLength: 10,
				lengthChange: true,
				responsive: true,
				searching: true,
				paging: true,
				info: true,
				order: [
					[0, 'desc']
				],
				columnDefs: [{
					orderable: false,
					targets: 5
				}]
			});
		}
	}
	// Initialize DataTable after DOM ready
	if (document.readyState === 'complete' || document.readyState === 'interactive') {
		initCustomerTableDataTable();
	} else {
		document.addEventListener('DOMContentLoaded', initCustomerTableDataTable);
	}
</script>
<?= $this->endSection() ?>
