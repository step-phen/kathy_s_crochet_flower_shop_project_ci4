<?= $this->extend('admin/layouts/page-layout') ?>
<?= $this->section('content') ?>

<div class="card mb-4" style="max-width: 500px; margin: 0 auto;">
    <div class="card-header text-center">
        <h5 class="mb-0">Admin Profile</h5>
    </div>
    <div class="card-body text-center">
        <img src="<?= base_url('uploads/staff/' . (!empty($admin['image']) ? $admin['image'] : 'default-avatar.png')) ?>" alt="Profile Image" class="rounded-circle mb-3" style="width: 90px; height: 90px; object-fit: cover; border: 2px solid #ffe4f0;">
        <h6 class="fw-semibold mb-1"><?= esc($admin['name'] ?? $user) ?></h6>
        <p class="text-muted mb-2"><?= esc($admin['email'] ?? $email) ?></p>
        <div class="mb-3">
            <?php if (!empty($admin['role'])): ?>
                <span class="badge bg-success"><?= esc(ucfirst($admin['role'])) ?></span>
            <?php else: ?>
                <span class="badge bg-secondary">Unknown</span>
            <?php endif; ?>
        </div>
        <hr>
        <div class="text-start">
            <p class="mb-1"><strong>Name:</strong> <?= esc($admin['name'] ?? $user) ?></p>
            <p class="mb-1"><strong>Phone:</strong> <?= esc($admin['phone'] ?? 'N/A') ?></p>
            <p class="mb-1"><strong>Address:</strong>
                <?php
                $address = $admin['address'] ?? '';
                $city = $admin['city'] ?? '';
                $province = $admin['province'] ?? '';
                $postal = $admin['postal_code'] ?? '';
                $addressParts = array_filter([
                    $address,
                    $city,
                    $province,
                    $postal
                ]);
                echo esc(implode(', ', $addressParts)) ?: 'N/A';
                ?>
            </p>
            <!-- Status removed -->
        </div>
        <button type="button" class="btn btn-outline-primary btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#editProfileModal">Update Profile</button>
    </div>
</div>

<!-- Update Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Update Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editProfileForm" enctype="multipart/form-data" method="post" action="<?= base_url('admin/profile/update') ?>">
                <div class="modal-body" style="max-height: 65vh; overflow-y: auto;">
                    <div class="mb-3 text-center">
                        <img src="<?= base_url('uploads/staff/' . (!empty($admin['image']) ? $admin['image'] : 'default-avatar.png')) ?>" alt="Profile Image" class="rounded-circle mb-2" style="width: 70px; height: 70px; object-fit: cover; border: 2px solid #ffe4f0;">
                        <input type="file" class="form-control mt-2" name="image" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label for="editName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="editName" name="name" value="<?= esc($admin['name'] ?? $user) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="email" value="<?= esc($admin['email'] ?? $email) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPhone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="editPhone" name="phone" value="<?= esc($admin['phone'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label for="editAddress" class="form-label">Address</label>
                        <input type="text" class="form-control mb-1" id="editAddress" name="address" value="<?= esc($admin['address'] ?? '') ?>">
                        <input type="text" class="form-control mb-1" id="editCity" name="city" placeholder="City" value="<?= esc($admin['city'] ?? '') ?>">
                        <input type="text" class="form-control mb-1" id="editProvince" name="province" placeholder="Province" value="<?= esc($admin['province'] ?? '') ?>">
                        <input type="text" class="form-control" id="editPostal" name="postal_code" placeholder="Postal Code" value="<?= esc($admin['postal_code'] ?? '') ?>">
                    </div>
                    <!-- Status edit removed -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if (session()->getFlashdata('success')): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Profile Updated',
            text: 'Your profile was updated successfully!',
            confirmButtonColor: '#ff4d8f',
            timer: 2000
        });
    });
</script>
<?php endif; ?>
<?= $this->endSection() ?>