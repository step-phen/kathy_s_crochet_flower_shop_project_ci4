<?= $this->extend('customer/layouts/page-layout') ?>
<?= $this->section('content') ?>
<main class="main-content">
    <div class="container py-5">
        <div class="row">
            <!-- Delivery Information -->
            <div class="col-lg-7 mb-4 mb-lg-0">
                <form id="checkoutForm" method="post" enctype="multipart/form-data" action="<?= site_url('kathys_crochet_flowers/place-order') ?>">
                    <h3 class="mb-4 fw-bold">Delivery Information</h3>
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" name="name" class="form-control checkout-input" id="floatingName" placeholder="Full Name" required>
                                <label for="floatingName" class="checkout-form-label">Full Name</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" name="mobile" class="form-control checkout-input" id="floatingMobile" placeholder="Mobile Number" pattern="09[0-9]{9}" title="Enter valid Philippine mobile number (09XXXXXXXXX)" required>
                                <label for="floatingMobile" class="checkout-form-label">Mobile Number (09XXXXXXXXX)</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="email" name="email" class="form-control checkout-input" id="floatingEmail" placeholder="Email" required>
                                <label for="floatingEmail" class="checkout-form-label">Email</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" name="city" class="form-control checkout-input" id="floatingCity" placeholder="City" required>
                                <label for="floatingCity" class="checkout-form-label">City</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select name="province" class="form-select checkout-select" id="floatingProvince" required>
                                    <option value="" disabled selected>Select Province</option>
                                    <option value="Abra">Abra</option>
                                    <option value="Agusan del Norte">Agusan del Norte</option>
                                    <option value="Agusan del Sur">Agusan del Sur</option>
                                    <option value="Aklan">Aklan</option>
                                    <option value="Albay">Albay</option>
                                    <option value="Antique">Antique</option>
                                    <option value="Apayao">Apayao</option>
                                    <option value="Aurora">Aurora</option>
                                    <option value="Basilan">Basilan</option>
                                    <option value="Bataan">Bataan</option>
                                    <option value="Batanes">Batanes</option>
                                    <option value="Batangas">Batangas</option>
                                    <option value="Benguet">Benguet</option>
                                    <option value="Biliran">Biliran</option>
                                    <option value="Bohol">Bohol</option>
                                    <option value="Bukidnon">Bukidnon</option>
                                    <option value="Bulacan">Bulacan</option>
                                    <option value="Cagayan">Cagayan</option>
                                    <option value="Camarines Norte">Camarines Norte</option>
                                    <option value="Camarines Sur">Camarines Sur</option>
                                    <option value="Camiguin">Camiguin</option>
                                    <option value="Capiz">Capiz</option>
                                    <option value="Catanduanes">Catanduanes</option>
                                    <option value="Cavite">Cavite</option>
                                    <option value="Cebu">Cebu</option>
                                    <option value="Cotabato">Cotabato</option>
                                    <option value="Davao de Oro">Davao de Oro</option>
                                    <option value="Davao del Norte">Davao del Norte</option>
                                    <option value="Davao del Sur">Davao del Sur</option>
                                    <option value="Davao Occidental">Davao Occidental</option>
                                    <option value="Davao Oriental">Davao Oriental</option>
                                    <option value="Dinagat Islands">Dinagat Islands</option>
                                    <option value="Eastern Samar">Eastern Samar</option>
                                    <option value="Guimaras">Guimaras</option>
                                    <option value="Ifugao">Ifugao</option>
                                    <option value="Ilocos Norte">Ilocos Norte</option>
                                    <option value="Ilocos Sur">Ilocos Sur</option>
                                    <option value="Iloilo">Iloilo</option>
                                    <option value="Isabela">Isabela</option>
                                    <option value="Kalinga">Kalinga</option>
                                    <option value="La Union">La Union</option>
                                    <option value="Laguna">Laguna</option>
                                    <option value="Lanao del Norte">Lanao del Norte</option>
                                    <option value="Lanao del Sur">Lanao del Sur</option>
                                    <option value="Leyte">Leyte</option>
                                    <option value="Maguindanao del Norte">Maguindanao del Norte</option>
                                    <option value="Maguindanao del Sur">Maguindanao del Sur</option>
                                    <option value="Marinduque">Marinduque</option>
                                    <option value="Masbate">Masbate</option>
                                    <option value="Metro Manila">Metro Manila</option>
                                    <option value="Misamis Occidental">Misamis Occidental</option>
                                    <option value="Misamis Oriental">Misamis Oriental</option>
                                    <option value="Mountain Province">Mountain Province</option>
                                    <option value="Negros Occidental">Negros Occidental</option>
                                    <option value="Negros Oriental">Negros Oriental</option>
                                    <option value="Northern Samar">Northern Samar</option>
                                    <option value="Nueva Ecija">Nueva Ecija</option>
                                    <option value="Nueva Vizcaya">Nueva Vizcaya</option>
                                    <option value="Occidental Mindoro">Occidental Mindoro</option>
                                    <option value="Oriental Mindoro">Oriental Mindoro</option>
                                    <option value="Palawan">Palawan</option>
                                    <option value="Pampanga">Pampanga</option>
                                    <option value="Pangasinan">Pangasinan</option>
                                    <option value="Quezon">Quezon</option>
                                    <option value="Quirino">Quirino</option>
                                    <option value="Rizal">Rizal</option>
                                    <option value="Romblon">Romblon</option>
                                    <option value="Samar">Samar</option>
                                    <option value="Sarangani">Sarangani</option>
                                    <option value="Siquijor">Siquijor</option>
                                    <option value="Sorsogon">Sorsogon</option>
                                    <option value="South Cotabato">South Cotabato</option>
                                    <option value="Southern Leyte">Southern Leyte</option>
                                    <option value="Sultan Kudarat">Sultan Kudarat</option>
                                    <option value="Sulu">Sulu</option>
                                    <option value="Surigao del Norte">Surigao del Norte</option>
                                    <option value="Surigao del Sur">Surigao del Sur</option>
                                    <option value="Tarlac">Tarlac</option>
                                    <option value="Tawi-Tawi">Tawi-Tawi</option>
                                    <option value="Zambales">Zambales</option>
                                    <option value="Zamboanga del Norte">Zamboanga del Norte</option>
                                    <option value="Zamboanga del Sur">Zamboanga del Sur</option>
                                    <option value="Zamboanga Sibugay">Zamboanga Sibugay</option>
                                </select>
                                <label for="floatingProvince" class="checkout-form-label">Province</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating mb-3">
                                <input type="text" name="zip" class="form-control checkout-input" id="floatingZip" placeholder="ZIP" pattern="[0-9]{4}" title="Enter 4-digit ZIP code" required>
                                <label for="floatingZip" class="checkout-form-label">ZIP (4 digits)</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating mb-3">
                                <input type="date" name="date" class="form-control checkout-input" id="floatingDate" placeholder="Date" required>
                                <label for="floatingDate" class="checkout-form-label">Delivery Date</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <div class="form-floating mb-3">
                            <input type="text" name="address" class="form-control checkout-input" id="floatingAddress" placeholder="Address" required>
                            <label for="floatingAddress" class="checkout-form-label">Complete Address</label>
                        </div>
                    </div>
                    <div class="mb-2">
                        <div class="form-floating mb-3">
                            <textarea name="notes" class="form-control checkout-input" id="floatingNotes" placeholder="Add any special instructions..." style="height: 60px"></textarea>
                            <label for="floatingNotes" class="checkout-form-label">Notes (optional)</label>
                        </div>
                    </div>

                    <!-- ENHANCED: Payment Method Section -->
                    <div class="mb-3">
                        <label class="checkout-form-label mb-2 fw-bold">Payment Method</label>
                        <div class="checkout-payment-methods">
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="gcash" class="checkout-payment-radio" id="gcashRadio">
                                <span><i class="fas fa-mobile-alt"></i> GCash (gcash Payment)</span>
                            </label>
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="cod" class="checkout-payment-radio" id="codRadio" checked>
                                <span><i class="fas fa-money-bill-wave"></i> Cash on Delivery</span>
                            </label>
                        </div>

                        <!-- ENHANCED: GCash Payment Fields -->
                        <div id="gcashFields" style="display:none; margin-top:1.5rem;">
                            <div class="alert alert-info mb-3">
                                <h6 class="alert-heading"><i class="fas fa-info-circle"></i> GCash Payment Instructions</h6>
                                <ol class="mb-0 ps-3">
                                    <li>Scan the QR code below or send to <strong>0917 123 4567</strong></li>
                                    <li>Enter the reference number from your GCash receipt</li>
                                    <li>Upload a screenshot of your payment confirmation</li>
                                    <li>Your order will be verified within 24 hours</li>
                                </ol>
                            </div>

                            <div class="text-center mb-3 p-3 border rounded bg-light">
                                <p class="mb-2 fw-bold">Scan to Pay:</p>
                                <img src="<?= base_url('assets/images/gcash-qr.png') ?>" alt="GCash QR Code" style="max-width:200px; border: 2px solid #007bff; border-radius: 8px;">
                                <p class="mt-2 mb-0"><strong>Account:</strong> 0917 123 4567</p>
                                <p class="mb-0 text-muted small">Kathy's Crochet Flowers</p>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" name="gcash_reference" class="form-control checkout-input" id="floatingGcashReference" placeholder="Reference Number" minlength="10">
                                <label for="floatingGcashReference" class="checkout-form-label">
                                    GCash Reference Number <span class="text-danger">*</span>
                                </label>
                                <small class="form-text text-muted">13-digit reference number from your GCash receipt</small>
                            </div>

                            <div class="mb-3">
                                <label class="checkout-form-label mb-2" for="floatingGcashImage">
                                    Payment Screenshot <span class="text-danger">*</span>
                                </label>
                                <input type="file" name="gcash_image" class="form-control checkout-input" id="floatingGcashImage" accept="image/jpeg,image/jpg,image/png,image/gif">
                                <small class="form-text text-muted">
                                    Upload screenshot of your GCash payment confirmation (JPG, PNG, GIF - Max 5MB)
                                </small>
                                <div id="imagePreview" class="mt-2" style="display:none;">
                                    <img id="previewImg" src="" alt="Preview" style="max-width: 200px; border: 1px solid #ddd; border-radius: 4px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-5 mb-4 mb-lg-0">
                <div class="checkout-summary-card">
                    <h4 class="mb-3 fw-bold">Order Summary</h4>
                    <ul class="checkout-order-list">
                        <?php if (!empty($cartItems)): ?>
                            <?php foreach ($cartItems as $item): ?>
                                <li>
                                    <img src="<?= base_url($item['image']) ?>" alt="<?= esc($item['product_name']) ?>" class="checkout-order-img">
                                    <div class="checkout-order-info">
                                        <div class="fw-semibold"><?= esc($item['product_name']) ?></div>
                                        <div class="text-muted small"><?= esc($item['category_name'] ?? '') ?></div>
                                        <div class="fw-bold">₱<?= number_format($item['price'], 2) ?></div>
                                    </div>
                                    <div class="checkout-order-qty ms-3">
                                        <button type="button" class="checkout-order-qty-btn" onclick="updateQty(<?= $item['product_id'] ?>, -1, this)">-</button>
                                        <span><?= esc($item['quantity']) ?></span>
                                        <button type="button" class="checkout-order-qty-btn" onclick="updateQty(<?= $item['product_id'] ?>, 1, this)">+</button>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="text-center text-muted">Your cart is empty.</li>
                        <?php endif; ?>
                    </ul>
                    <hr class="divider">
                    <div class="line">
                        <div class="label fw-bold">Subtotal</div>
                        <div class="value">₱<?= isset($cartTotal) ? number_format($cartTotal, 2) : '0.00' ?></div>
                    </div>
                    <div class="line">
                        <div class="label text-muted">Shipping</div>
                        <div class="value">₱<?= isset($shippingFee) ? number_format($shippingFee, 2) : '0.00' ?></div>
                    </div>
                    <hr class="divider">
                    <div class="d-flex justify-content-between align-items-center fw-bold fs-5 mt-4">
                        <span>Total (PHP):</span>
                        <span class="text-success">₱<?= isset($cartTotal, $shippingFee) ? number_format($cartTotal + $shippingFee, 2) : '0.00' ?></span>
                    </div>
                    <button type="submit" form="checkoutForm" class="checkout-confirm-btn" id="confirmOrderBtn">
                        <i class="fas fa-check-circle"></i> Confirm Order
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // FIXED: Quantity update with proper element reference
    function updateQty(productId, delta, element) {
        var $qtySpan = $(element).siblings('span');
        var currentQty = parseInt($qtySpan.text()) || 1;
        var newQty = currentQty + delta;

        if (newQty < 1) {
            alert('Quantity cannot be less than 1');
            return;
        }

        $.ajax({
            url: '<?= base_url('kathys_crochet_flowers/update-cart-quantity') ?>',
            type: 'POST',
            data: {
                product_id: productId,
                quantity: newQty
            },
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    $qtySpan.text(newQty);
                    // Update totals in summary
                    $('.checkout-summary-card .value').eq(0).text('₱' + (data.cart_total ? data.cart_total.toFixed(2) : '0.00'));
                    $('.checkout-summary-card .value').eq(1).text('₱' + (data.shipping_fee ? data.shipping_fee.toFixed(2) : '0.00'));
                    $('.checkout-summary-card .text-success').text('₱' + ((data.cart_total + data.shipping_fee).toFixed(2)));
                } else {
                    alert(data.message || 'Failed to update cart.');
                    if (data.max_quantity) {
                        $qtySpan.text(data.max_quantity);
                    }
                }
            },
            error: function() {
                alert('Error updating cart. Please try again.');
            }
        });
    }

    $(document).ready(function() {
        // Set minimum date to today for delivery date
        var today = new Date().toISOString().split('T')[0];
        $('#floatingDate').attr('min', today);

        // ENHANCED: Payment method change handler
        $('input[name="payment_method"]').on('change', function() {
            var $gcashFields = $('#gcashFields');
            var $confirmBtn = $('#confirmOrderBtn');

            if ($(this).val() === 'gcash') {
                $gcashFields.slideDown(300);

                // Make GCash fields required
                $('#floatingGcashReference, #floatingGcashImage').prop('required', true);

                // Update button text
                $confirmBtn.html('<i class="fas fa-mobile-alt"></i> Confirm & Pay via GCash');
            } else {
                $gcashFields.slideUp(300);

                // Remove required attribute from GCash fields
                $('#floatingGcashReference, #floatingGcashImage').prop('required', false);

                // Update button text
                $confirmBtn.html('<i class="fas fa-money-bill-wave"></i> Confirm Order (COD)');
            }
        });

        // Image preview for GCash screenshot
        $('#floatingGcashImage').on('change', function(e) {
            var file = e.target.files[0];
            if (file) {
                // Validate file size (5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('File size exceeds 5MB. Please upload a smaller image.');
                    $(this).val('');
                    $('#imagePreview').hide();
                    return;
                }

                // Validate file type
                var allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Invalid file type. Please upload JPG, PNG, or GIF image.');
                    $(this).val('');
                    $('#imagePreview').hide();
                    return;
                }

                // Show preview
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#previewImg').attr('src', e.target.result);
                    $('#imagePreview').fadeIn();
                };
                reader.readAsDataURL(file);
            } else {
                $('#imagePreview').hide();
            }
        });

        // Form validation before submit

        $('#checkoutForm').on('submit', function(e) {
            var paymentMethod = $('input[name="payment_method"]:checked').val();

            if (paymentMethod === 'gcash') {
                var gcashRef = $('#floatingGcashReference').val().trim();
                var gcashImage = $('#floatingGcashImage')[0].files.length;
                // Validate reference number
                if (gcashRef.length < 10) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Invalid Reference Number',
                        text: 'Please enter a valid GCash reference number (at least 10 characters)'
                    });
                    $('#floatingGcashReference').focus();
                    return false;
                }
                // Validate image upload
                if (gcashImage === 0) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'No Screenshot Uploaded',
                        text: 'Please upload a screenshot of your GCash payment'
                    });
                    $('#floatingGcashImage').focus();
                    return false;
                }
            }

            // Disable submit button to prevent double submission
            $('#confirmOrderBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');
        });

        // On page load, check if GCash is selected
        if ($('input[name="payment_method"]:checked').val() === 'gcash') {
            $('#gcashFields').show();
            $('#floatingGcashReference, #floatingGcashImage').prop('required', true);
        }
    });
</script>
<?= $this->endSection() ?>