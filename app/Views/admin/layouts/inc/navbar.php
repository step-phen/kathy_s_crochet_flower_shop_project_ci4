<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container-fluid py-1">
        <button type="button" id="sidebarCollapse" class="btn btn-light px-2 py-1"
            data-testid="button-sidebar-toggle">
            <i class="bi bi-list"></i>
        </button>

        <div class="ms-auto d-flex align-items-center gap-2">
            <!-- Profile -->
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-1 px-2 py-1" type="button" data-bs-toggle="dropdown">
                    <img
                        src="<?= base_url('uploads/staff/' . (!empty($admin['image']) ? $admin['image'] : 'default-avatar.png')) ?>"
                        alt="Admin Profile"
                        class="rounded-circle"
                        width="26"
                        height="26">
                    <span class="d-none d-md-inline fw-semibold">
                        <?= esc($user) ?>
                    </span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li class="px-2 py-2 border-bottom">
                        <div class="d-flex align-items-center gap-2">
                            <img
                                src="<?= base_url('uploads/staff/' . (!empty($admin['image']) ? $admin['image'] : 'default-avatar.png')) ?>"
                                alt="Admin Profile"
                                class="rounded-circle"
                                width="32"
                                height="32">
                            <div>
                                <div class="fw-semibold">
                                    <?= esc($user) ?>
                                </div>
                                <small class="text-muted">
                                    <?= esc($email) ?>
                                </small>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="<?= route_to('admin.profile') ?>"><i
                                class="bi bi-person me-2"></i>Profile</a>
                    </li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li>
                        <a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>