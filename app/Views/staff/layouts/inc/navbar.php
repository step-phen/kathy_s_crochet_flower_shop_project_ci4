<!-- Top Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-light"
            data-testid="button-sidebar-toggle">
            <i class="bi bi-list"></i>
        </button>

        <div class="ms-auto d-flex align-items-center gap-3">
            <!-- Profile -->
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-2" type="button"
                    data-bs-toggle="dropdown">
                    <img src="<?= base_url('uploads/staff/' . (!empty($staff['profile_image']) ? $staff['profile_image'] : 'default-avatar.png')) ?>"
                        alt="Staff Profile"
                        class="rounded-circle"
                        width="32"
                        height="32"
                        style="object-fit: cover;">
                    <span class="d-none d-md-inline fw-semibold"><?= esc($staff['name'] ?? '') ?></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li class="px-3 py-2 border-bottom">
                        <div class="d-flex align-items-center gap-2">
                            <img src="<?= base_url('uploads/staff/' . (!empty($staff['profile_image']) ? $staff['profile_image'] : 'default-avatar.png')) ?>"
                                alt="Staff Profile"
                                class="rounded-circle"
                                width="40"
                                height="40"
                                style="object-fit: cover;">
                            <div>
                                <div class="fw-semibold"><?= esc($staff['name'] ?? '') ?></div>
                                <small class="text-muted"><?= esc($staff['email'] ?? '') ?></small>
                            </div>
                        </div>
                    </li>
                    <li>
            <a class="dropdown-item" href="<?= base_url('staff/profile') ?>"><i
                class="bi bi-person me-2"></i>Profile</a>
                    </li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li>
                        <a class="dropdown-item text-danger" href="<?= base_url('logout') ?>"><i
                                class="bi bi-box-arrow-right me-2"></i>Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>