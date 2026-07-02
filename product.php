<?php
include("includes/db.php");
include("includes/header.php");

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = intval($_GET['id']);

$sql = "SELECT * FROM products WHERE id='$id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    echo "<h3>Product not found.</h3>";
    include("includes/footer.php");
    exit();
}

$product = mysqli_fetch_assoc($result);
?>

<div class="row mt-4">

    <div class="col-md-5">
        <img src="images/<?php echo $product['image']; ?>" class="img-fluid rounded shadow">
    </div>

    <div class="col-md-7">

        <h2><?php echo $product['product_name']; ?></h2>

        <h3 class="text-success mt-3">
            ₹<?php echo number_format($product['price']); ?>
        </h3>

        <p class="mt-4">
            <?php echo $product['description']; ?>
        </p>

        <p>
            <strong>Available Stock:</strong>
            <?php echo $product['stock']; ?>
        </p>

        <?php if($product['stock'] > 0){ ?>

        <form action="cart.php" method="POST">

            <input
                type="hidden"
                name="product_id"
                value="<?php echo $product['id']; ?>">

            <div class="mb-3">

                <label class="form-label">Quantity</label>

                <input
                    type="number"
                    name="quantity"
                    class="form-control"
                    value="1"
                    min="1"
                    max="<?php echo $product['stock']; ?>">

            </div>

            <button
                type="submit"
                name="add_cart"
                class="btn btn-success btn-lg">

                Add to Cart

            </button>

        </form>

                    <a href="wishlist.php?add=<?php echo $product['id']; ?>"
            class="btn btn-outline-danger btn-lg mt-3">

            ❤ Add to Wishlist

            </a>

            <hr>

                    <h3>Customer Reviews</h3>

                    <?php
                    if(isset($_SESSION['user_id']))
                    {
                    ?>

                    <form action="save_review.php" method="POST">

                    <input
                    type="hidden"
                    name="product_id"
                    value="<?php echo $product['id']; ?>">

                    <div class="mb-3">

                    <label>Rating</label>

                    <select name="rating" class="form-select">

                    <option value="5">⭐⭐⭐⭐⭐</option>
                    <option value="4">⭐⭐⭐⭐</option>
                    <option value="3">⭐⭐⭐</option>
                    <option value="2">⭐⭐</option>
                    <option value="1">⭐</option>

                    </select>

                    </div>

                    <div class="mb-3">

                    <label>Review</label>

                    <textarea
                    name="review"
                    class="form-control"
                    rows="4"
                    required></textarea>

                    </div>

                    <button
                    type="submit"
                    class="btn btn-success">

                    Submit Review

                    </button>

                    </form>

                    <?php
                    }
                    else
                    {
                    ?>

                    <div class="alert alert-info">

                    Login to write a review.

                    </div>

                    <?php
                    }
                    ?>

        <hr>

<?php

$sql = "SELECT reviews.*, users.fullname

FROM reviews

JOIN users
ON reviews.user_id = users.id

WHERE product_id='".$product['id']."'

ORDER BY created_at DESC";

$result = mysqli_query($conn,$sql);

while($review=mysqli_fetch_assoc($result))
{
?>

<div class="card mb-3">

<div class="card-body">

<h5>

<?php echo htmlspecialchars($review['fullname']); ?>

</h5>

<p>

Rating:

<?php
for($i=1;$i<=$review['rating'];$i++)
echo "⭐";
?>

</p>

<p>

<?php echo htmlspecialchars($review['review']); ?>

</p>

</div>

</div>

<?php
}
?>

        <?php } else { ?>

            <button
                class="btn btn-danger btn-lg"
                disabled>

                Out of Stock

            </button>

        <?php } ?>

    </div>

</div>

<?php
include("includes/footer.php");
?>