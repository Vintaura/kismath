<?php include 'includes/header.php'; ?>
<?php include 'includes/db_connect.php'; ?>

<!-- Hero Slider -->
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <?php
    // Fetch banners from DB
    $banners_res = $conn->query("SELECT * FROM banners WHERE active=1 ORDER BY id ASC");
    $banners = [];
    if($banners_res && $banners_res->num_rows > 0){
        while($b = $banners_res->fetch_assoc()) $banners[] = $b;
    } else {
        // Fallback default banners if DB is empty
        $banners = [
            ['image' => 'https://placehold.co/1920x600/D32F2F/FFF', 'title' => 'Welcome to Kismath', 'subtitle' => 'Taste of Tradition', 'link' => 'shop.php']
        ];
    }
    ?>
    <div class="carousel-indicators">
        <?php foreach($banners as $i => $ban): ?>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="<?php echo $i; ?>" class="<?php echo $i==0?'active':''; ?>" aria-current="true" aria-label="Slide <?php echo $i+1; ?>"></button>
        <?php endforeach; ?>
    </div>
    
    <div class="carousel-inner">
        <?php foreach($banners as $i => $ban): ?>
        <div class="carousel-item <?php echo $i==0?'active':''; ?>">
            <div style="height: 500px; background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url('<?php echo $ban['image']; ?>'); background-size: cover; background-position: center;">
                <div class="d-flex align-items-center justify-content-center h-100 text-center">
                    <div class="glass-panel p-5" style="max-width: 800px; background: rgba(255,255,255,0.2); backdrop-filter: blur(5px);">
                        <h1 class="display-3 fw-bold text-white" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);"><?php echo htmlspecialchars($ban['title']); ?></h1>
                        <p class="lead mb-4 text-white" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.5); font-weight: 500; font-size: 1.5rem;"><?php echo htmlspecialchars($ban['subtitle']); ?></p>
                        <a href="<?php echo $ban['link']; ?>" class="btn btn-primary-custom btn-lg shadow-lg">Explore</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<!-- Categories Section -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title">Shop by Category</h2>
        <div class="row g-4">
            <?php
            $cats = [
                ['name' => 'Pickles', 'img' => 'https://placehold.co/400x300/e53935/fff?text=Home+Made+Pickles'],
                ['name' => 'Spice Powders', 'img' => 'https://placehold.co/400x300/ffb300/000?text=Pure+Spices'],
                ['name' => 'Masalas', 'img' => 'https://placehold.co/400x300/795548/fff?text=Authentic+Masalas'],
                ['name' => 'Combos', 'img' => 'https://placehold.co/400x300/388e3c/fff?text=Gift+Combos']
            ];
            foreach ($cats as $cat): ?>
            <div class="col-md-6 col-lg-3">
                <a href="shop.php?category=<?php echo urlencode($cat['name']); ?>" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-sm overflow-hidden category-card">
                        <img src="<?php echo $cat['img']; ?>" class="card-img-top" alt="<?php echo $cat['name']; ?>" style="height: 200px; object-fit: cover;">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?php echo $cat['name']; ?></h5>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title">Featured Delights</h2>
        <div class="row g-4">
            <?php
            // Fetch featured products (limit 4)
            $sql = "SELECT * FROM products ORDER BY id DESC LIMIT 4";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    ?>
                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100 product-card">
                            <div class="product-img-wrapper">
                                <img src="<?php echo get_image_url($row['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['name']); ?>">
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title mb-1"><?php echo htmlspecialchars($row['name']); ?></h5>
                                <p class="text-muted small mb-2"><?php echo htmlspecialchars(substr($row['description'], 0, 50)) . '...'; ?></p>
                                <div class="price-tag mb-3">₹<?php echo number_format($row['price'], 2); ?></div>
                                <a href="product-details.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-custom btn-sm">View Details</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<div class="col-12 text-center"><p>No products found. Add some from the Admin Panel!</p></div>';
            }
            ?>
        </div>
        <div class="text-center mt-5">
            <a href="shop.php" class="btn btn-primary-custom">View All Products</a>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-5">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="glass-panel p-4 h-100">
                    <div class="mb-3"><i class="fas fa-leaf fa-3x text-success"></i></div>
                    <h4>100% Natural</h4>
                    <p>No preservatives or artificial colors. Just pure, natural ingredients.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="glass-panel p-4 h-100">
                    <div class="mb-3"><i class="fas fa-heart fa-3x text-danger"></i></div>
                    <h4>Made with Love</h4>
                    <p>Traditional recipes handed down through generations.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="glass-panel p-4 h-100">
                    <div class="mb-3"><i class="fas fa-shipping-fast fa-3x text-primary"></i></div>
                    <h4>Fast Delivery</h4>
                    <p>Quick and safe delivery to your doorstep anywhere in India.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
