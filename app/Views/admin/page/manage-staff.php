<?= $this->extend('admin/layouts/page-layout') ?>
<?= $this->section('content') ?>

<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h1 class="h2 fw-bold mb-1">Staff Management</h1>
        <p class="text-muted mb-0">
            <i class="bi bi-people me-1"></i>
            View, add, and update your staff members
        </p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStaffModal">
        <i class="bi bi-plus-circle me-2"></i>Add New Staff
    </button>
</div>

<!-- Staff Table -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-semibold">Staff List</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="staffTable" class="table table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-start">ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th class="text-start">Phone</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($staff) && is_array($staff)):
                                // Ensure newest staff at top (ID descending)
                                usort($staff, function ($a, $b) {
                                    return ($b['user_id'] ?? 0) - ($a['user_id'] ?? 0);
                                });
                                foreach ($staff as $s):
                                    // Prepare image path
                                    $imgSrc = base_url('uploads/staff/default-avatar.png');
                                    if (!empty($s['image'])) {
                                        $imgSrc = base_url($s['image']);
                                    }
                            ?>
                                    <tr
                                        data-user-id="<?= esc($s['user_id']) ?>"
                                        data-email="<?= esc($s['email']) ?>"
                                        data-address="<?= esc($s['address'] ?? '') ?>"
                                        data-city="<?= esc($s['city'] ?? '') ?>"
                                        data-province="<?= esc($s['province'] ?? '') ?>"
                                        data-postal="<?= esc($s['postal_code'] ?? '') ?>"
                                        data-image="<?= esc($imgSrc) ?>">

                                        <td class="text-start"><?= esc($s['user_id']) ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="<?= esc($imgSrc) ?>"
                                                    alt="Profile"
                                                    class="rounded-circle me-2"
                                                    style="width:40px;height:40px;object-fit:cover;">
                                                <div>
                                                    <div class="fw-semibold"><?= esc($s['name']) ?></div>
                                                    <div class="text-muted small"><?= esc($s['role'] ?? 'Staff') ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= esc($s['email']) ?></td>
                                        <td class="text-start"><?= esc($s['phone_number'] ?? '') ?></td>
                                        <td>
                                            <button type="button"
                                                class="btn btn-sm toggle-status-btn <?= ($s['status'] ?? 0) == 1 ? 'btn-success' : 'btn-secondary' ?>"
                                                data-user-id="<?= esc($s['user_id']) ?>"
                                                data-status="<?= ($s['status'] ?? 0) == 1 ? '1' : '0' ?>">
                                                <?= ($s['status'] ?? 0) == 1 ? 'Active' : 'Inactive' ?>
                                            </button>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-primary view-staff-btn">
                                                <i class="bi bi-eye me-1"></i>View
                                            </a>
                                        </td>
                                    </tr>
                                <?php
                                endforeach;
                            else:
                                ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        No staff members found.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Staff Modal -->
<div class="modal fade" id="addStaffModal" tabindex="-1" aria-labelledby="addStaffModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <h5 class="modal-title fw-bold text-white" id="addStaffModalLabel">
                    <i class="bi bi-person-plus-fill me-2"></i>Create New Staff Account
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body px-4 py-4">
                <form id="addStaffForm">
                    <!-- Profile Image Upload Section -->
                    <div class="text-center mb-4 pb-3 border-bottom">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-camera-fill me-1"></i>Profile Picture
                            </label>
                            <div class="d-flex justify-content-center align-items-center flex-column">
                                <div class="position-relative mb-3">
                                    <img id="imagePreview"
                                        src="<?= base_url('uploads/staff/default-avatar.png') ?>"
                                        alt="Preview"
                                        class="rounded-circle border border-3 border-primary shadow-sm"
                                        style="width: 120px; height: 120px; object-fit: cover;">
                                    <label for="image" class="position-absolute bottom-0 end-0 btn btn-primary btn-sm rounded-circle p-2" style="cursor: pointer;">
                                        <i class="bi bi-camera-fill"></i>
                                    </label>
                                </div>
                                <input type="file"
                                    class="form-control d-none"
                                    id="image"
                                    name="image"
                                    accept="image/*">
                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>Click camera icon to upload image (Optional)
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Personal Information Section -->
                    <h6 class="text-uppercase text-muted fw-bold mb-3 small">
                        <i class="bi bi-person-fill me-2"></i>Personal Information
                    </h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="name" class="form-label">
                                Name <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input type="text"
                                    class="form-control"
                                    id="name"
                                    name="name"
                                    placeholder="Enter full name"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">
                                Email Address <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    placeholder="staff@example.com"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="phone_number" class="form-label">
                                Phone Number <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-telephone"></i>
                                </span>
                                <input type="tel"
                                    class="form-control"
                                    id="phone_number"
                                    name="phone_number"
                                    placeholder="+63 XXX XXX XXXX"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="status" class="form-label">
                                Account Status <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-toggle-on"></i>
                                </span>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="Active" selected>Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Address Information Section -->
                    <h6 class="text-uppercase text-muted fw-bold mb-3 small">
                        <i class="bi bi-geo-alt-fill me-2"></i>Address Information
                    </h6>
                    <div class="row g-3 mb-4">
                        <div class="col-12">
                            <label for="address" class="form-label">
                                Street Address <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-house-door"></i>
                                </span>
                                <input type="text"
                                    class="form-control"
                                    id="address"
                                    name="address"
                                    placeholder="House/Unit No., Street Name"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="city" class="form-label">
                                City <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-building"></i>
                                </span>
                                <input type="text"
                                    class="form-control"
                                    id="city"
                                    name="city"
                                    placeholder="Enter city"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="province" class="form-label">
                                Province <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-map"></i>
                                </span>
                                <select class="form-select" id="province" name="province" required>
                                    <option value="">Select Province</option>
                                    <option value="Misamis Oriental">Misamis Oriental</option>
                                    <option value="Cebu">Cebu</option>
                                    <option value="Davao del Sur">Davao del Sur</option>
                                    <option value="Pampanga">Pampanga</option>
                                    <option value="Batangas">Batangas</option>
                                    <option value="Laguna">Laguna</option>
                                    <option value="Bulacan">Bulacan</option>
                                    <option value="Iloilo">Iloilo</option>
                                    <option value="Negros Occidental">Negros Occidental</option>
                                    <option value="Palawan">Palawan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="postal_code" class="form-label">
                                Postal Code <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-mailbox"></i>
                                </span>
                                <input type="text"
                                    class="form-control"
                                    id="postal_code"
                                    name="postal_code"
                                    placeholder="XXXX"
                                    maxlength="4"
                                    required>
                            </div>
                        </div>
                    </div>

                    <!-- Account Settings Section -->
                    <h6 class="text-uppercase text-muted fw-bold mb-3 small">
                        <i class="bi bi-gear-fill me-2"></i>Account Settings
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="role" class="form-label">
                                Role <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-briefcase"></i>
                                </span>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="">Select Role</option>
                                    <option value="Staff" selected>Staff</option>
                                </select>
                            </div>
                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>Default password will be set as: <code>staff123</code>
                            </small>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer bg-light border-top">
                <button type="button" class="btn btn-light border" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Cancel
                </button>
                <button type="button" class="btn btn-primary" id="saveStaffBtn">
                    <i class="bi bi-check-circle me-1"></i>Create Staff Account
                </button>
            </div>
        </div>
    </div>
</div>


<!-- View Staff Modal -->
<div class="modal fade" id="viewStaffModal" tabindex="-1" aria-labelledby="viewStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <h5 class="modal-title fw-bold text-white" id="viewStaffModalLabel">
                    <i class="bi bi-person-badge-fill me-2"></i>Staff Profile
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-0">
                <!-- Profile Header Section -->
                <div class="bg-light py-4 px-4 text-center border-bottom">
                    <div class="position-relative d-inline-block mb-3">
                        <img id="viewStaffImage"
                            src="<?= base_url('uploads/staff/default-avatar.png') ?>"
                            alt="Staff Image"
                            class="rounded-circle border border-4 border-white shadow-sm"
                            style="width: 120px; height: 120px; object-fit: cover;">
                        <span class="position-absolute bottom-0 end-0 p-2 bg-success border border-3 border-white rounded-circle"
                            id="viewStaffStatusBadge"
                            style="width: 25px; height: 25px;">
                        </span>
                    </div>
                    <h4 id="viewStaffName" class="fw-bold mb-1 text-dark"></h4>
                    <p id="viewStaffRole" class="text-muted mb-2">
                        <i class="bi bi-briefcase-fill me-1"></i>Staff Member
                    </p>
                    <div id="viewStaffStatusText" class="badge bg-success px-3 py-2">Active</div>
                </div>

                <!-- Contact Information Section -->
                <div class="px-4 py-3">
                    <h6 class="text-uppercase text-muted fw-bold mb-3 small">
                        <i class="bi bi-telephone-fill me-2"></i>Contact Information
                    </h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="bg-primary bg-opacity-10 rounded p-2 me-3">
                                    <i class="bi bi-envelope-fill text-primary fs-5"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="text-muted small mb-1">Email Address</div>
                                    <div id="viewStaffEmail" class="fw-semibold text-break"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="bg-success bg-opacity-10 rounded p-2 me-3">
                                    <i class="bi bi-phone-fill text-success fs-5"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="text-muted small mb-1">Phone Number</div>
                                    <div id="viewStaffPhone" class="fw-semibold"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Address Information Section -->
                    <h6 class="text-uppercase text-muted fw-bold mb-3 small">
                        <i class="bi bi-geo-alt-fill me-2"></i>Address Details
                    </h6>
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="card border-0" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
                                <div class="card-body">
                                    <div class="d-flex align-items-start">
                                        <i class="bi bi-house-door-fill text-primary fs-4 me-3"></i>
                                        <div class="flex-grow-1">
                                            <div class="text-muted small mb-1">Street Address</div>
                                            <div id="viewStaffFullAddress" class="fw-semibold"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body">
                                    <div class="text-muted small mb-1">
                                        <i class="bi bi-building me-1"></i>City
                                    </div>
                                    <div id="viewStaffCity" class="fw-semibold"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body">
                                    <div class="text-muted small mb-1">
                                        <i class="bi bi-map me-1"></i>Province
                                    </div>
                                    <div id="viewStaffProvince" class="fw-semibold"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body">
                                    <div class="text-muted small mb-1">
                                        <i class="bi bi-mailbox me-1"></i>Postal Code
                                    </div>
                                    <div id="viewStaffPostal" class="fw-semibold"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Account Information Section -->
                    <div class="mt-4">
                        <h6 class="text-uppercase text-muted fw-bold mb-3 small">
                            <i class="bi bi-info-circle-fill me-2"></i>Account Information
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card border-0 bg-light">
                                    <div class="card-body">
                                        <div class="text-muted small mb-1">
                                            <i class="bi bi-person-badge me-1"></i>User ID
                                        </div>
                                        <div id="viewStaffUserId" class="fw-semibold">#0000</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-0 bg-light">
                                    <div class="card-body">
                                        <div class="text-muted small mb-1">
                                            <i class="bi bi-calendar-check me-1"></i>Date Added
                                        </div>
                                        <div id="viewStaffCreatedAt" class="fw-semibold">N/A</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-light border-top">
                <button type="button" class="btn btn-light border" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Close
                </button>
                <button type="button" class="btn btn-primary" id="editStaffBtn">
                    <i class="bi bi-pencil-square me-1"></i>Edit Staff
                </button>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script>
    // Initialize DataTable for staff table
    function initStaffTableDataTable() {
        if (window.jQuery && $.fn.dataTable) {
            if (window._staffDataTable) {
                try {
                    window._staffDataTable.destroy();
                } catch (e) {}
            }
            window._staffDataTable = $('#staffTable').DataTable({
                pageLength: 10,
                lengthChange: true,
                responsive: true,
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

    // Helper: Show SweetAlert or fallback to alert
    function showSuccess(message) {
        if (window.Swal) {
            Swal.fire({
                icon: 'success',
                title: message,
                showConfirmButton: false,
                timer: 1800
            });
        } else {
            alert(message);
        }
    }

    // Refresh staff table after add/update
    function refreshStaffTable() {
        fetch("<?= base_url('admin/staff/list') ?>")
            .then(r => r.json())
            .then(payload => {
                if (payload.status === 'success') {
                    const tbody = document.querySelector('#staffTable tbody');

                    // Destroy existing DataTable
                    if (window._staffDataTable) {
                        try {
                            window._staffDataTable.destroy();
                        } catch (e) {}
                        window._staffDataTable = null;
                    }

                    // Update table body
                    tbody.innerHTML = payload.html;

                    // Re-initialize DataTable
                    initStaffTableDataTable();

                    // Re-attach event listeners to new rows
                    attachTableEventListeners();

                    showSuccess('Staff list updated successfully');
                } else {
                    alert('Failed to refresh staff list.');
                }
            })
            .catch(() => alert('Failed to refresh staff list.'));
    }

    // Save New Staff
    function handleSaveStaff() {
        const form = document.getElementById('addStaffForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const formData = new FormData(form);
        const imageInput = document.querySelector('#image');
        if (imageInput && imageInput.files.length > 0) {
            formData.set('image', imageInput.files[0]);
        }

        fetch("<?= base_url('admin/staff/save') ?>", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Reset and close modal FIRST
                    form.reset();
                    const modalEl = document.getElementById('addStaffModal');
                    const modalInstance = bootstrap.Modal.getInstance(modalEl);
                    if (modalInstance) {
                        modalInstance.hide();
                    }

                    // Then refresh table
                    refreshStaffTable();
                } else {
                    let errorMsg = 'Error: ';
                    if (data.errors) {
                        errorMsg += Object.values(data.errors).join(', ');
                    } else {
                        errorMsg += 'Unknown error occurred.';
                    }
                    alert(errorMsg);
                }
            })
            .catch(() => alert('Failed to save staff. Please try again.'));
    }

    // Toggle staff status (active/inactive)
    function handleToggleStatusClick(e) {
        const btn = e.target.closest('.toggle-status-btn');
        if (!btn) return;

        e.preventDefault();

        const userId = btn.getAttribute('data-user-id');
        const currentStatus = btn.getAttribute('data-status');
        const newStatus = currentStatus === '1' ? '0' : '1';
        const statusText = newStatus === '1' ? 'Active' : 'Inactive';

        // Confirm with user
        if (window.Swal) {
            Swal.fire({
                title: 'Confirm Status Change',
                text: `Change status to ${statusText}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, change it',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    updateStaffStatus(userId, newStatus);
                }
            });
        } else {
            if (confirm(`Change status to ${statusText}?`)) {
                updateStaffStatus(userId, newStatus);
            }
        }
    }

    // Update staff status via AJAX
    function updateStaffStatus(userId, newStatus) {
        fetch(`<?= base_url('admin/staff/toggle-status') ?>`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: new URLSearchParams({
                    user_id: userId,
                    status: newStatus
                })
            })
            .then(r => r.json())
            .then(data => {
                if (data.status === 'success') {
                    refreshStaffTable();
                } else {
                    alert(data.message || 'Failed to update status.');
                }
            })
            .catch(() => alert('Failed to update status.'));
    }

    // Handle view staff button click
    function handleViewStaffClick(e) {
        const btn = e.target.closest('.view-staff-btn');
        if (!btn) return;

        e.preventDefault();

        const tr = btn.closest('tr');
        if (!tr) return;

        // Get staff info from row data attributes and cells
        const userId = tr.querySelector('td:first-child')?.textContent.trim() || '';
        const name = tr.querySelector('.fw-semibold')?.textContent.trim() || '';
        const email = tr.querySelectorAll('td')[2]?.textContent.trim() || '';
        const phone = tr.querySelectorAll('td')[3]?.textContent.trim() || '';
        const statusBtn = tr.querySelector('.toggle-status-btn');
        const isActive = statusBtn?.getAttribute('data-status') === '1';

        // Get address data from data attributes
        const address = tr.getAttribute('data-address') || '';
        const city = tr.getAttribute('data-city') || '';
        const province = tr.getAttribute('data-province') || '';
        const postal = tr.getAttribute('data-postal') || '';
        let image = tr.getAttribute('data-image') || '<?= base_url('uploads/staff/default-avatar.png') ?>';

        // Add cache-busting to force reload
        image += (image.includes('?') ? '&' : '?') + 't=' + new Date().getTime();

        // Compose full address
        const fullAddress = address || 'Not available';

        // Populate basic info
        document.getElementById('viewStaffName').textContent = name;
        document.getElementById('viewStaffEmail').textContent = email;
        document.getElementById('viewStaffPhone').textContent = phone || 'N/A';
        document.getElementById('viewStaffUserId').textContent = '#' + userId;
        document.getElementById('viewStaffImage').setAttribute('src', image);

        // Populate address details
        document.getElementById('viewStaffFullAddress').textContent = fullAddress;
        document.getElementById('viewStaffCity').textContent = city || 'N/A';
        document.getElementById('viewStaffProvince').textContent = province || 'N/A';
        document.getElementById('viewStaffPostal').textContent = postal || 'N/A';

        // Update status indicator
        const statusBadge = document.getElementById('viewStaffStatusBadge');
        const statusText = document.getElementById('viewStaffStatusText');

        if (isActive) {
            statusBadge.className = 'position-absolute bottom-0 end-0 p-2 bg-success border border-3 border-white rounded-circle';
            statusText.className = 'badge bg-success px-3 py-2';
            statusText.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i>Active';
        } else {
            statusBadge.className = 'position-absolute bottom-0 end-0 p-2 bg-secondary border border-3 border-white rounded-circle';
            statusText.className = 'badge bg-secondary px-3 py-2';
            statusText.innerHTML = '<i class="bi bi-x-circle-fill me-1"></i>Inactive';
        }

        // Store user ID for edit button (if needed later)
        document.getElementById('editStaffBtn').setAttribute('data-user-id', userId);

        // Show modal
        const modalEl = document.getElementById('viewStaffModal');
        const modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
        modalInstance.show();
    }

    // Optional: Handle Edit Staff button (placeholder for future implementation)
    document.addEventListener('DOMContentLoaded', function() {
        const editStaffBtn = document.getElementById('editStaffBtn');
        if (editStaffBtn) {
            editStaffBtn.addEventListener('click', function() {
                const userId = this.getAttribute('data-user-id');
                // Close view modal
                const viewModal = bootstrap.Modal.getInstance(document.getElementById('viewStaffModal'));
                if (viewModal) {
                    viewModal.hide();
                }

                // TODO: Open edit modal or redirect to edit page
                console.log('Edit staff with ID:', userId);

                // Example: You can open an edit modal here
                // const editModal = new bootstrap.Modal(document.getElementById('editStaffModal'));
                // editModal.show();

                // Or show a message
                if (window.Swal) {
                    Swal.fire({
                        title: 'Edit Staff',
                        text: 'Edit functionality will be implemented soon.',
                        icon: 'info'
                    });
                }
            });
        }
    });

    // Attach event listeners to table rows (used after AJAX refresh)
    function attachTableEventListeners() {
        const tbody = document.querySelector('#staffTable tbody');
        if (!tbody) return;

        // Remove old listeners to prevent duplicates
        tbody.removeEventListener('click', handleTableClick);

        // Add new listener
        tbody.addEventListener('click', handleTableClick);
    }

    // Unified click handler for table
    function handleTableClick(e) {
        handleViewStaffClick(e);
        handleToggleStatusClick(e);
    }

    // Initialize everything when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize DataTable
        initStaffTableDataTable();

        // Attach table event listeners
        attachTableEventListeners();

        // Attach save staff button listener
        const saveStaffBtn = document.getElementById('saveStaffBtn');
        if (saveStaffBtn) {
            saveStaffBtn.addEventListener('click', handleSaveStaff);
        }

        // Reset form when modal is hidden
        const addStaffModal = document.getElementById('addStaffModal');
        if (addStaffModal) {
            addStaffModal.addEventListener('hidden.bs.modal', function() {
                document.getElementById('addStaffForm').reset();
            });
        }
    });

    // Image preview functionality for Add Staff Modal
    document.addEventListener('DOMContentLoaded', function() {
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');
        const addStaffModal = document.getElementById('addStaffModal');

        // Image preview on file select
        if (imageInput && imagePreview) {
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];

                if (file) {
                    // Validate file type
                    const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
                    if (!validTypes.includes(file.type)) {
                        if (window.Swal) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Invalid File Type',
                                text: 'Please upload a valid image file (JPG, PNG, GIF, or WebP)',
                            });
                        } else {
                            alert('Please upload a valid image file (JPG, PNG, GIF, or WebP)');
                        }
                        imageInput.value = '';
                        return;
                    }

                    // Validate file size (max 5MB)
                    const maxSize = 5 * 1024 * 1024; // 5MB in bytes
                    if (file.size > maxSize) {
                        if (window.Swal) {
                            Swal.fire({
                                icon: 'error',
                                title: 'File Too Large',
                                text: 'Image size must be less than 5MB',
                            });
                        } else {
                            alert('Image size must be less than 5MB');
                        }
                        imageInput.value = '';
                        return;
                    }

                    // Create preview
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        imagePreview.src = event.target.result;

                        // Add a subtle animation
                        imagePreview.style.opacity = '0';
                        setTimeout(() => {
                            imagePreview.style.transition = 'opacity 0.3s ease-in-out';
                            imagePreview.style.opacity = '1';
                        }, 50);
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        // Reset preview when modal is closed
        if (addStaffModal) {
            addStaffModal.addEventListener('hidden.bs.modal', function() {
                // Reset form
                const form = document.getElementById('addStaffForm');
                if (form) {
                    form.reset();
                }

                // Reset image preview to default
                if (imagePreview) {
                    imagePreview.src = '<?= base_url('uploads/staff/default-avatar.png') ?>';
                }

                // Clear file input
                if (imageInput) {
                    imageInput.value = '';
                }
            });
        }

        // Add subtle validation feedback
        const form = document.getElementById('addStaffForm');
        if (form) {
            const inputs = form.querySelectorAll('input[required], select[required]');
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.value.trim() === '') {
                        this.classList.add('is-invalid');
                    } else {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    }
                });

                input.addEventListener('input', function() {
                    if (this.value.trim() !== '') {
                        this.classList.remove('is-invalid');
                    }
                });
            });
        }

        // Postal code validation (Philippines format)
        const postalCodeInput = document.getElementById('postal_code');
        if (postalCodeInput) {
            postalCodeInput.addEventListener('input', function(e) {
                // Only allow numbers
                this.value = this.value.replace(/[^0-9]/g, '');

                // Limit to 4 digits
                if (this.value.length > 4) {
                    this.value = this.value.slice(0, 4);
                }
            });
        }

        // Phone number formatting
        const phoneInput = document.getElementById('phone_number');
        if (phoneInput) {
            phoneInput.addEventListener('input', function(e) {
                // Remove non-numeric characters except + and spaces
                let value = this.value.replace(/[^\d\s+]/g, '');
                this.value = value;
            });
        }
    });
</script>
<?= $this->endSection() ?>