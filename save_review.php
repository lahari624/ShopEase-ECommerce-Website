<?php
session_start();
include("includes/db.php");

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}

$product_id = intval($_POST['product_id']);
$rating = intval($_POST['rating']);
$review = mysqli_real_escape_string($conn,$_POST['review']);

$user_id = $_SESSION['user_id'];

mysqli_query($conn,
"INSERT INTO reviews
(user_id,product_id,rating,review)
VALUES
('$user_id','$product_id','$rating','$review')");

header("Location: product.php?id=".$product_id);
exit();
?>