<?= $this->extend('customer/layouts/page-layout'); ?>
<?= $this->section('content'); ?>

<div class="hero-section">
    <div class="container">
        <h1 class="display-3 playfair-display">Welcome to Kathy's Crochet Flowers</h1>
        <p class="lead">Handmade with love. Fresh flowers delivered same-day in Cagayan de Oro City.</p>
        <a href="<?= route_to('customer.products') ?>" class="btn btn-light btn-lg mt-3">Shop All Flowers</a>
    </div>
</div>

<main class="container my-5">
    <section class="text-center my-5 py-5">
        <div class="row">
            <div class="col-md-4">
                <h3 class="playfair-display">Farm Fresh</h3>
                <p>We source our flowers daily to ensure the freshest, most vibrant bouquets.</p>
            </div>
            <div class="col-md-4">
                <h3 class="playfair-display">Local Florist</h3>
                <p>Proudly serving Cagayan de Oro with handcrafted arrangements and personal service.</p>
            </div>
            <div class="col-md-4">
                <h3 class="playfair-display">Same-Day Delivery</h3>
                <p>Order before 2 PM for guaranteed same-day delivery right to your doorstep.</p>
            </div>
        </div>
    </section>


    <!-- best seller section -->
    <section class="best-seller-section my-5">
        <h2 class="section-title">Our Best Sellers</h2>
        <div class="row">
            <?php if (!empty($bestSellers) && is_array($bestSellers)): ?>
                <?php foreach ($bestSellers as $product): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="<?= esc($product['image']) ?>" class="card-img-top" alt="<?= esc($product['name']) ?>"
                                style="height: 450px;">
                            <div class="card-body text-center">
                                <h5 class="card-title playfair-display"><?= esc($product['name']) ?></h5>
                                <p class="card-text"><?= esc($product['description']) ?></p>
                                <p class="card-text fw-bold">₱<?= number_format($product['price'], 0) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-center">No best sellers available at the moment.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <!-- end best seller section -->

    <!-- about us section -->
    <section id="about-us" class="about-section py-5 my-5">
        <div class="container">
            <h2 class="section-title">Our Story</h2>
            <div class="row align-items-center">
                <div class="col-md-6">
                    <img src="/assets/images/img2.jpg" alt="Florist at work" class="img-fluid"
                        style="width: 100%; height: 460px;">
                </div>
                <div class="col-md-6">
                    <h3 class="playfair-display">From Passion to Petals</h3>
                    <p>Welcome to Kathy's Crochet Flowers, your friendly neighborhood florist in Cagayan de Oro. Our
                        journey began with a simple love for flowers and a passion for bringing joy to our
                        community. We believe every bouquet tells a story, and we are dedicated to crafting
                        beautiful, fresh arrangements for all of life's special moments.</p>
                    <p>We source our flowers from the best local growers to ensure unparalleled freshness and
                        quality. Thank you for letting us be a part of your celebrations.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- end about us section -->

    <!-- contact us section -->
    <section id="contact-us" class="contact-section py-5 my-5">
        <div class="container">
            <h2 class="section-title">Get In Touch</h2>
            <div class="row">
                <div class="col-md-5 contact-info">
                    <h4 class="playfair-display mb-4">Visit Our Shop</h4>
                    <div class="d-flex mb-3">
                        <i class="fas fa-map-marker-alt fa-fw me-3 mt-1"></i>
                        <div><strong>Address:</strong><br>123 Blossom St., Brgy. Nazareth,<br>Cagayan de Oro City,
                            9000</div>
                    </div>
                    <div class="d-flex mb-3">
                        <i class="fas fa-phone fa-fw me-3 mt-1"></i>
                        <div><strong>Phone:</strong><br>(088) 123-4567</div>
                    </div>
                    <div class="d-flex mb-3">
                        <i class="fas fa-envelope fa-fw me-3 mt-1"></i>
                        <div><strong>Email:</strong><br>hello@bloomandpetal.ph</div>
                    </div>
                    <div class="d-flex mb-3">
                        <i class="fas fa-clock fa-fw me-3 mt-1"></i>
                        <div><strong>Hours:</strong><br>Mon - Sat: 9:00 AM - 6:00 PM<br>Sunday: Closed</div>
                    </div>
                </div>

                <div class=" col-md-7">
                    <h4 class="playfair-display mb-4">Send Us a Message</h4>
                    <form>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="Your Name"
                                required>
                            <label for="floatingInput">Your Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="floatingEmail" placeholder="Your Email"
                                required>
                            <label for="floatingEmail">Your Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="floatingMessage" rows="6" placeholder="Your Message"
                                style="height: 100px" required></textarea>
                            <label for="floatingMessage">Your Message</label>
                        </div>
                        <button type="submit" class="btn btn-dark w-100">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>


<?= $this->endSection(); ?>
<?= $this->section('scripts'); ?>



<?= $this->endSection(); ?>