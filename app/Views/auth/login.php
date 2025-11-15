<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kathy's Crochet Flowers - Login</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:wght@300;400;500;600&display=swap"
        rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/login.css">
</head>


<body>
    <div class="login-container">
        <div class="illustration-side">
            <div class="flower-illustration">
                <img src="/assets/images/flower.png" alt="Colorful flower illustration"
                    style="width: 100%; height: 100%; object-fit: contain;">
            </div>

            <div class="illustration-text">Kathy's Crochet Flowers</div>
            <div class="illustration-subtext">
                Handmade with love. Fresh flowers delivered same-day in Cagayan de Oro City. Brighten your day with our vibrant blooms!
            </div>
        </div>

        <div class="login-side">
            <div class="logo">Kathy's Crochet Flowers</div>
            <div class="welcome-text">Welcome to Kathy's Crochet Flowers</div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>
            <?= csrf_field() ?>
            <!-- Login form -->
            <form action="<?= base_url('auth') ?>" method="post">
                <div class="form-floating mb-3">
                    <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@gmail.com" autocomplete="off" 
                    required>
                    <label for="floatingInput">Enter your Email address</label>
                </div>

                <div class="form-floating">
                    <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" autocomplete="off" required>
                    <label for="floatingPassword">Enter your Password</label>
                </div>

                <div class="forgot-password">
                    <a href="#">Forgot password?</a>
                </div>

                <button type="submit" class="btn-signin">Sign in</button>
            </form>

            <div class="divider">
                <span>or</span>
            </div>

            <div class="signup-link">
                New to Kathy's Crochet Flowers? <a href="<?= base_url('register') ?>">Create Account</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>