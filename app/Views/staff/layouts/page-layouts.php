<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= esc(isset($title) ? $title : 'Staff Panel') ?></title>

    <!-- Bootstrap 5 CSS -->
    <link href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link href="<?= base_url('assets/bootstrap-icons/bootstrap-icons.css') ?>" rel="stylesheet" />
    <!-- DataTables CSS -->
    <link href="<?= base_url('assets/datatables/css/dataTables.bootstrap5.min.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('assets/datatables/css/responsive.bootstrap5.min.css') ?>" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/styles.css" />
    <?= $this->renderSection('stylesheets') ?>
</head>

<body>
    <div class="wrapper">

        <!-- Sidebar Include -->
        <?= $this->include('staff/layouts/inc/sidebar') ?>

        <!-- Page Content -->
        <div id="content">
            <!-- Navbar Include -->
            <?= $this->include('staff/layouts/inc/navbar') ?>

            <div class="container-fluid p-4">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap 5 JS Bundle -->
    <script src="<?= base_url('assets/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- SweetAlert2 JS -->
    <script src="<?= base_url('assets/sweetalert2/sweetalert2@11.js') ?>"></script>
    <!-- chart JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- DataTables JS -->
    <script src="<?= base_url('assets/datatables/js/dataTables.min.js') ?>"></script>
    <script src="<?= base_url('assets/datatables/js/dataTables.bootstrap5.min.js') ?>"></script>
    <script src="<?= base_url('assets/datatables/js/dataTables.responsive.min.js') ?>"></script>
    <script src="<?= base_url('assets/datatables/js/responsive.bootstrap5.min.js') ?>"></script>
    <!-- custom JS -->
    <script src="/assets/js/main.js"></script>
    <?= $this->renderSection('scripts') ?>
</body>

</html>