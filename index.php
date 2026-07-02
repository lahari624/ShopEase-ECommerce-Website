<?php
include("includes/header.php");
include("includes/db.php");
?>

<!-- Hero Banner -->

<div id="heroSlider" class="carousel slide mb-5" data-bs-ride="carousel">

<div class="carousel-indicators">

<button type="button"
data-bs-target="#heroSlider"
data-bs-slide-to="0"
class="active"></button>

<button type="button"
data-bs-target="#heroSlider"
data-bs-slide-to="1"></button>

<button type="button"
data-bs-target="#heroSlider"
data-bs-slide-to="2"></button>

</div>

<div class="carousel-inner">

<div class="carousel-item active">

<img src="images/banner1.jpg"
class="d-block w-100"
style="height:500px;object-fit:cover;">

<div class="carousel-caption d-none d-md-block">

<h2>Electronics Mega Sale</h2>

<p>Up to 50% OFF</p>

<a href="products.php?category=1"
class="btn btn-warning">

Shop Now

</a>

</div>

</div>

<div class="carousel-item">

<img src="images/banner2.jpg"
class="d-block w-100"
style="height:500px;object-fit:cover;">

<div class="carousel-caption d-none d-md-block">

<h2>Latest Fashion</h2>

<p>New Collection Available</p>

<a href="products.php?category=2"
class="btn btn-warning">

Explore

</a>

</div>

</div>

<div class="carousel-item">

<img src="images/banner3.jpg"
class="d-block w-100"
style="height:500px;object-fit:cover;">

<div class="carousel-caption d-none d-md-block">

<h2>Summer Special</h2>

<p>Best Deals This Week</p>

<a href="products.php"
class="btn btn-warning">

Shop Today

</a>

</div>

</div>

</div>

<button
class="carousel-control-prev"
type="button"
data-bs-target="#heroSlider"
data-bs-slide="prev">

<span class="carousel-control-prev-icon"></span>

</button>

<button
class="carousel-control-next"
type="button"
data-bs-target="#heroSlider"
data-bs-slide="next">

<span class="carousel-control-next-icon"></span>

</button>

</div>

<div class="container mt-5">

    <!-- Shop by Category -->

    <h2 class="text-center mb-5">Shop by Category</h2>

    <div class="row">

        <div class="col-md-3 mb-4">

            <a href="products.php?category=1" class="text-decoration-none text-dark">

                <div class="card category-card text-center p-4 h-100">

                    <h1>📱</h1>

                    <h4>Electronics</h4>

                </div>

            </a>

        </div>

        <div class="col-md-3 mb-4">

            <a href="products.php?category=2" class="text-decoration-none text-dark">

                <div class="card category-card text-center p-4 h-100">

                    <h1>👕</h1>

                    <h4>Fashion</h4>

                </div>

            </a>

        </div>

        <div class="col-md-3 mb-4">

            <a href="products.php?category=3" class="text-decoration-none text-dark">

                <div class="card category-card text-center p-4 h-100">

                    <h1>👟</h1>

                    <h4>Shoes</h4>

                </div>

            </a>

        </div>

        <div class="col-md-3 mb-4">

            <a href="products.php?category=4" class="text-decoration-none text-dark">

                <div class="card category-card text-center p-4 h-100">

                    <h1>⌚</h1>

                    <h4>Watches</h4>

                </div>

            </a>

        </div>

        <div class="col-md-3 mb-4">

            <a href="products.php?category=5" class="text-decoration-none text-dark">

                <div class="card category-card text-center p-4 h-100">

                    <h1>📚</h1>

                    <h4>Books</h4>

                </div>

            </a>

        </div>

        <div class="col-md-3 mb-4">

            <a href="products.php?category=6" class="text-decoration-none text-dark">

                <div class="card category-card text-center p-4 h-100">

                    <h1>🥣</h1>

                    <h4>Home Appliances</h4>

                </div>

            </a>

        </div>

    </div>

    <!-- Featured Products -->

    <h2 class="text-center mt-5 mb-4">

        Featured Products

    </h2>

    <div class="row">

<?php

$sql = "SELECT * FROM products LIMIT 8";

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result))
{

?>

<div class="col-lg-3 col-md-4 col-sm-6 mb-4">

<div class="card product-card h-100">

<div class="position-relative">

<img src="images/<?php echo $row['image']; ?>"
class="card-img-top">

<span class="badge-sale">

NEW

</span>

</div>

<div class="card-body">

<h5>

<?php echo htmlspecialchars($row['product_name']); ?>

</h5>

<div class="rating">

★★★★★

</div>

<h4>

₹<?php echo number_format($row['price']); ?>

</h4>

<div class="d-grid gap-2">

<a href="product.php?id=<?php echo $row['id']; ?>"
class="btn btn-primary">

View Details

</a>

<a href="wishlist.php?id=<?php echo $row['id']; ?>"
class="btn btn-outline-danger">

❤ Wishlist

</a>

</div>

</div>

</div>

</div>

<?php

}

?>

    </div>

    <!-- Offer Banner -->

    <div class="offer-banner shadow">

       <h2>🔥 Summer Sale</h2>

<p>Up to 50% OFF on selected products.</p>

<a href="products.php"
class="btn btn-dark btn-lg mt-3">

Start Shopping

</a>

    </div>

</div>

<div class="container mt-5 mb-5">

<h2 class="text-center mb-5">

Why Choose ShopEase?

</h2>

<div class="row text-center">

<div class="col-md-4">

<h1>🚚</h1>

<h4>Free Delivery</h4>

<p>Fast delivery on eligible orders.</p>

</div>

<div class="col-md-4">

<h1>🔒</h1>

<h4>Secure Payments</h4>

<p>Your transactions are protected with secure payment methods.</p>

</div>

<div class="col-md-4">

<h1>💬</h1>

<h4>24×7 Support</h4>

<p>Our support team is available whenever you need help.</p>

</div>

</div>

</div>

<?php
include("includes/footer.php");
?>