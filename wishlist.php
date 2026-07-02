<?php
include("includes/db.php");
include("includes/header.php");

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* Add to Wishlist */

if(isset($_GET['add']))
{
    $product_id = intval($_GET['add']);

    $check = mysqli_query($conn,
    "SELECT * FROM wishlist
    WHERE user_id='$user_id'
    AND product_id='$product_id'");

    if(mysqli_num_rows($check)==0)
    {
        mysqli_query($conn,
        "INSERT INTO wishlist(user_id,product_id)
        VALUES('$user_id','$product_id')");
    }

    header("Location: wishlist.php");
    exit();
}

/* Remove Wishlist */

if(isset($_GET['delete']))
{
    $id = intval($_GET['delete']);

    mysqli_query($conn,
    "DELETE FROM wishlist
    WHERE id='$id'
    AND user_id='$user_id'");

    header("Location: wishlist.php");
    exit();
}
?>

<h2 class="mb-4">My Wishlist</h2>

<div class="row">

<?php

$sql = "SELECT wishlist.id,
products.*

FROM wishlist

JOIN products
ON wishlist.product_id = products.id

WHERE wishlist.user_id='$user_id'";

$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result)>0)
{
    while($row=mysqli_fetch_assoc($result))
    {
?>

<div class="col-md-3 mb-4">

<div class="card h-100 shadow">

<img src="images/<?php echo $row['image']; ?>"
class="card-img-top"
style="height:220px;object-fit:cover;">

<div class="card-body">

<h5><?php echo $row['product_name']; ?></h5>

<h4 class="text-success">
₹<?php echo number_format($row['price']); ?>
</h4>

<a href="product.php?id=<?php echo $row['id']; ?>"
class="btn btn-primary w-100 mb-2">

View

</a>

<a href="wishlist.php?delete=<?php echo $row['id']; ?>"
class="btn btn-danger w-100">

Remove

</a>

</div>

</div>

</div>

<?php
    }
}
else
{
?>

<div class="alert alert-info">
Your wishlist is empty.
</div>

<?php
}
?>

</div>

<?php
include("includes/footer.php");
?>