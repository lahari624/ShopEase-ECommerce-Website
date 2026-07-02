<?php
include("includes/db.php");
include("includes/header.php");

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}

if(!isset($_GET['id']))
{
    header("Location: orders.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$order_id = intval($_GET['id']);

$order = mysqli_query($conn,
"SELECT * FROM orders
WHERE id='$order_id'
AND user_id='$user_id'");

if(mysqli_num_rows($order)==0)
{
    echo "<div class='container mt-5'><div class='alert alert-danger'>Order not found.</div></div>";
    include("includes/footer.php");
    exit();
}

$order = mysqli_fetch_assoc($order);
?>

<div class="container mt-5">

<h2 class="mb-4">

Order Details

</h2>

<div class="card shadow mb-4">

<div class="card-body">

<div class="row">

<div class="col-md-6">

<p><strong>Order ID :</strong> #<?php echo $order['id']; ?></p>

<p><strong>Order Date :</strong>

<?php echo date("d-m-Y H:i",strtotime($order['order_date'])); ?>

</p>

</div>

<div class="col-md-6">

<p><strong>Payment :</strong>

<?php echo $order['payment_method']; ?>

</p>

<p>

<strong>Status :</strong>

<span class="badge bg-success">

<?php echo $order['order_status']; ?>

</span>

</p>

</div>

</div>

</div>

</div>

<h4 class="mb-3">

Products Ordered

</h4>

<table class="table table-bordered table-hover">

<thead class="table-dark">

<tr>

<th>Image</th>

<th>Product</th>

<th>Price</th>

<th>Quantity</th>

<th>Total</th>

</tr>

</thead>

<tbody>

<?php

$grandTotal=0;

$sql="SELECT
order_items.*,
products.product_name,
products.image

FROM order_items

INNER JOIN products

ON order_items.product_id=products.id

WHERE order_items.order_id='$order_id'";

$result=mysqli_query($conn,$sql);

while($row=mysqli_fetch_assoc($result))
{

$itemTotal=$row['price']*$row['quantity'];

$grandTotal+=$itemTotal;

?>

<tr>

<td width="120">

<img src="images/<?php echo $row['image']; ?>"
class="img-fluid rounded"
style="height:80px;">

</td>

<td>

<?php echo $row['product_name']; ?>

</td>

<td>

₹<?php echo number_format($row['price']); ?>

</td>

<td>

<?php echo $row['quantity']; ?>

</td>

<td>

₹<?php echo number_format($itemTotal); ?>

</td>

</tr>

<?php
}
?>

<tr class="table-success">

<th colspan="4" class="text-end">

Grand Total

</th>

<th>

₹<?php echo number_format($grandTotal); ?>

</th>

</tr>

</tbody>

</table>

<a href="orders.php" class="btn btn-secondary">

← Back to Orders

</a>

</div>

<?php
include("includes/footer.php");
?>