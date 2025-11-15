<?= $this->extend('staff/layouts/page-layouts') ?>
<?= $this->section('content') ?>

<div class="card mb-4 staff-profile-card">
    <div class="card-header text-center staff-profile-header">
        <h5 class="mb-0 staff-profile-title">Staff Profile</h5>
    </div>
    <div class="card-body text-center">
        <div class="staff-profile-center">
            <img src="<?= base_url('uploads/staff/' . (!empty($staff['profile_image']) ? $staff['profile_image'] : 'default-avatar.png')) ?>" alt="Profile Image" class="staff-profile-avatar">
            <h6 class="fw-semibold mb-1 staff-profile-name"><?= esc($staff['name'] ?? '') ?></h6>
            <p class="text-muted mb-2 staff-profile-email"><?= esc($staff['email'] ?? '') ?></p>
            <?php if (!empty($staff['role'])): ?>
                <span class="staff-profile-role-badge">
                    <?= esc(ucfirst($staff['role'])) ?>
                </span>
            <?php else: ?>
                <span class="badge bg-secondary">Unknown</span>
            <?php endif; ?>
        </div>
        <hr class="staff-profile-divider">
        <div class="text-start staff-profile-details">
            <p class="mb-1"><strong>Name:</strong> <?= esc($staff['name'] ?? '') ?></p>
            <p class="mb-1"><strong>Phone:</strong> <?= esc($staff['phone'] ?? 'N/A') ?></p>
            <p class="mb-1"><strong>Address:</strong>
                <?php
                $addressParts = array_filter([
                    $staff['address'] ?? '',
                    $staff['city'] ?? '',
                    $staff['province'] ?? '',
                    $staff['postal_code'] ?? ''
                ]);
                echo esc(implode(', ', $addressParts)) ?: 'N/A';
                ?>
            </p>
        </div>
    </div>
</div>

<?= $this->endSection() ?>