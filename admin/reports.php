<?php
session_start();
include("../includes/db.php");

if(!isset($_SESSION['admin_id']))
{
    header("Location:login.php");
    exit();
}

$totalSales = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT SUM(total_amount) AS total FROM orders"))['total'];

if($totalSales=="")
{
    $totalSales=0;
}

$totalCustomers = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM users"))['total'];

$totalProducts = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM products"))['total'];

$totalOrders = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM orders"))['total'];
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Reports</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<?php include("sidebar.php"); ?>

<div style="margin-left:270px;padding:30px;">

<h2 class="mb-4">

Reports

</h2>

<div class="row">

<div class="col-md-3 mb-4">

<div class="card bg-primary text-white">

<div class="card-body text-center">

<h5>Total Sales</h5>

<h3>₹<?php echo number_format($totalSales); ?></h3>

</div>

</div>

</div>

<div class="col-md-3 mb-4">

<div class="card bg-success text-white">

<div class="card-body text-center">

<h5>Customers</h5>

<h3><?php echo $totalCustomers; ?></h3>

</div>

</div>

</div>

<div class="col-md-3 mb-4">

<div class="card bg-warning">

<div class="card-body text-center">

<h5>Products</h5>

<h3><?php echo $totalProducts; ?></h3>

</div>

</div>

</div>

<div class="col-md-3 mb-4">

<div class="card bg-danger text-white">

<div class="card-body text-center">

<h5>Orders</h5>

<h3><?php echo $totalOrders; ?></h3>

</div>

</div>

</div>

</div>

<h4 class="mt-5 mb-3">

Top Selling Products

</h4>

<table class="table table-bordered table-hover">

<thead class="table-dark">

<tr>

<th>Product</th>

<th>Total Sold</th>

</tr>

</thead>

<tbody>

<?php

$query=mysqli_query($conn,
"SELECT
products.product_name,
SUM(order_items.quantity) AS sold

FROM order_items

JOIN products
ON order_items.product_id=products.id

GROUP BY order_items.product_id

ORDER BY sold DESC

LIMIT 10");

while($row=mysqli_fetch_assoc($query))
{

?>

<tr>

<td><?php echo $row['product_name']; ?></td>

<td><?php echo $row['sold']; ?></td>

</tr>

<?php
}
?>

</tbody>

</table>

</div>

</body>

</html>