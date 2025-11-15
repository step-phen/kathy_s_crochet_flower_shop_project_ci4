<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kathy's Crochet Flowers - Create Account</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:wght@300;400;500;600&display=swap"
        rel="stylesheet">

    <!-- Custom CSS (reuse login styles) -->
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
                Create your account to shop our handmade crochet flowers and get updates on new designs.
            </div>
        </div>

        <div class="login-side">
            <div class="logo">Kathy's Crochet Flowers</div>
            <div class="welcome-text">Create your account</div>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>
            <?php $errors = session('errors') ?? []; ?>
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $err): ?>
                            <li><?= esc($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Signup form -->
            <form action="<?= base_url('register/store') ?>" method="post" enctype="multipart/form-data" onsubmit="return validatePasswords()">
                <div class="form-floating mb-3">
                    <input type="text" name="name" class="form-control" id="floatingName" value="<?= set_value('name') ?>" required placeholder="Enter your name" autocomplete="off">
                    <label for="floatingName">Name</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="email" name="email" class="form-control" id="floatingEmail" value="<?= set_value('email') ?>" required placeholder="Enter your email" autocomplete="off">
                    <label for="floatingEmail">Email</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="password" name="password" class="form-control" id="floatingPassword" required placeholder="Enter your password" autocomplete="off">
                    <label for="floatingPassword">Password</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="password" name="confirm_password" class="form-control" id="floatingConfirmPassword" required placeholder="Confirm your password" autocomplete="off">
                    <label for="floatingConfirmPassword">Confirm Password</label>
                </div>

                <div class="mb-3">
                    <label for="floatingImage" class="form-label">Profile Image</label>
                    <input type="file" name="image" class="form-control" id="floatingImage" accept="image/*" required>
                </div>

                <button type="submit" class="btn btn-success w-100">Register</button>
            </form>

            <div class="divider">
                <span>or</span>
            </div>

            <div class="signup-link">
                Already have an account? <a href="<?= base_url('login') ?>">Sign in</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        function validatePasswords() {
            var password = document.getElementById("floatingPassword");
            var confirmPassword = document.getElementById("floatingConfirmPassword");
            if (password.value !== confirmPassword.value) {
                // Add red border
                password.style.border = "2px solid red";
                confirmPassword.style.border = "2px solid red";
                alert("Passwords do not match!");
                confirmPassword.focus();
                return false;
            } else {
                // Reset border if match
                password.style.border = "";
                confirmPassword.style.border = "";
                return true;
            }
        }

        document.getElementById("floatingConfirmPassword").addEventListener("input", function() {
            var password = document.getElementById("floatingPassword");
            var confirmPassword = document.getElementById("floatingConfirmPassword");
            if (password.value !== confirmPassword.value) {
                password.style.border = "2px solid red";
                confirmPassword.style.border = "2px solid red";
            } else {
                password.style.border = "";
                confirmPassword.style.border = "";
            }
        });
    </script>

</body>

</html>