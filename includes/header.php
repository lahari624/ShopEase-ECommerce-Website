<?php
if(session_status() == PHP_SESSION_NONE)
{
    session_start();
}

$cartCount = 0;
$wishlistCount = 0;

if(isset($_SESSION['user_id']))
{
    include("db.php");

    $user_id = $_SESSION['user_id'];

    $cartResult = mysqli_query($conn,
    "SELECT COUNT(*) AS total
     FROM cart
     WHERE user_id='$user_id'");

    $cartCount = mysqli_fetch_assoc($cartResult)['total'];

    $wishResult = mysqli_query($conn,
    "SELECT COUNT(*) AS total
     FROM wishlist
     WHERE user_id='$user_id'");

    $wishlistCount = mysqli_fetch_assoc($wishResult)['total'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>ShopEase - E-Commerce Store</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="css/style.css">

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

<div class="container">

<a class="navbar-brand fw-bold" href="index.php">

ShopEase

</a>

<button
class="navbar-toggler"
type="button"
data-bs-toggle="collapse"
data-bs-target="#navbarNav">

<span class="navbar-toggler-icon"></span>

</button>

<div class="collapse navbar-collapse" id="navbarNav">

<!-- Search -->

<form
class="d-flex ms-auto me-3"
action="products.php"
method="GET">

<input
class="form-control me-2"
type="search"
name="search"
placeholder="Search products...">

<button
class="btn btn-warning">

Search

</button>

</form>

<ul class="navbar-nav">

<li class="nav-item">

<a class="nav-link" href="index.php">

Home

</a>

</li>

<li class="nav-item">

<a class="nav-link" href="products.php">

Products

</a>

</li>

<li class="nav-item">

<a class="nav-link" href="cart.php">

🛒 Cart

<span class="badge bg-danger">

<?php echo $cartCount; ?>

</span>

</a>

</li>

<li class="nav-item">

<a class="nav-link" href="wishlist.php">

❤ Wishlist

<span class="badge bg-warning text-dark">

<?php echo $wishlistCount; ?>

</span>

</a>

</li>

<?php

if(isset($_SESSION['user_id']))
{

?>

<li class="nav-item">

<a class="nav-link" href="profile.php">

Welcome,
<?php echo $_SESSION['user_name']; ?>

</a>

</li>

<li class="nav-item">

<a class="nav-link" href="logout.php">

Logout

</a>

</li>

<?php

}
else
{

?>

<li class="nav-item">

<a class="nav-link" href="login.php">

Login

</a>

</li>

<li class="nav-item">

<a class="nav-link" href="register.php">

Register

</a>

</li>

<?php

}

?>

</ul>

</div>

</div>

</nav>

<div class="container mt-4">