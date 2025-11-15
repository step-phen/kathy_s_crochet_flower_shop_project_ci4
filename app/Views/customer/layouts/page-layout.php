<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title); ?></title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <!-- Font Awesome & Google Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/product-details.css">
    <link rel="stylesheet" href="/assets/css/cart-dropdown.css">
    <link rel="stylesheet" href="/assets/css/cart-view.css">
    <link rel="stylesheet" href="/assets/css/checkout.css">



    <?= $this->renderSection('styles'); ?>
</head>

<body>
    <!-- Header Navbar -->
    <?= $this->include('customer/layouts/inc/header-navbar'); ?>


    <!-- Main Content -->
    <?= $this->renderSection('content'); ?>


    <!-- Footer -->
    <?= $this->include('customer/layouts/inc/footer'); ?>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Custom JS -->
    <script src="<?= base_url('assets/js/cart-dropdown.js') ?>"></script>
    
    <script>
    $(document).ready(function() {
        // SweetAlert for order confirmation (success message)
        <?php if (session()->getFlashdata('success')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Order Confirmed!',
            text: "<?= esc(session()->getFlashdata('success'), 'js') ?>",
            confirmButtonText: 'OK'
        });
        <?php endif; ?>

        // SweetAlert for order error (error message)
        <?php if (session()->getFlashdata('error')): ?>
        Swal.fire({
            icon: 'error',
            title: 'Order Failed',
            text: "<?= esc(session()->getFlashdata('error'), 'js') ?>",
            confirmButtonText: 'OK'
        });
        <?php endif; ?>
    });
    </script>
    <?= $this->renderSection('scripts'); ?>
</body>

</html>