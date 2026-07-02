<?php
include("../includes/db.php");

session_start();

if(!isset($_SESSION['admin_id']))
{
    header("Location: login.php");
    exit();
}

$order_id = intval($_GET['id']);

$order = mysqli_fetch_assoc(

mysqli_query($conn,

"SELECT
orders.*,
users.fullname,
users.email,
users.phone

FROM orders

JOIN users
ON orders.user_id=users.id

WHERE orders.id='$order_id'")
);

$items = mysqli_query($conn,

"SELECT
order_items.*,
products.product_name

FROM order_items

JOIN products
ON order_items.product_id=products.id

WHERE order_items.order_id='$order_id'");
?>

<!DOCTYPE html>

<html>

<head>

<title>Order Details</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h2>Order Details</h2>

<div class="card mb-4">

<div class="card-body">

<h5><?php echo $order['fullname']; ?></h5>

<p>Email : <?php echo $order['email']; ?></p>

<p>Phone : <?php echo $order['phone']; ?></p>

<p>Address : <?php echo $order['shipping_address']; ?></p>

<p>Payment : <?php echo $order['payment_method']; ?></p>

<p>Status : <?php echo $order['order_status']; ?></p>

</div>

</div>

<table class="table table-bordered">

<tr>

<th>Product</th>
<th>Price</th>
<th>Qty</th>
<th>Total</th>

</tr>

<?php

$total=0;

while($item=mysqli_fetch_assoc($items))
{

$sub=$item['price']*$item['quantity'];

$total+=$sub;

?>

<tr>

<td><?php echo $item['product_name']; ?></td>

<td>₹<?php echo number_format($item['price']); ?></td>

<td><?php echo $item['quantity']; ?></td>

<td>₹<?php echo number_format($sub); ?></td>

</tr>

<?php
}
?>

<tr>

<th colspan="3">

Grand Total

</th>

<th>

₹<?php echo number_format($total); ?>

</th>

</tr>

</table>

<form method="POST" action="orders.php">

<input
type="hidden"
name="order_id"
value="<?php echo $order['id']; ?>">

<select
name="status"
class="form-control mb-3">

<option>Pending</option>
<option>Processing</option>
<option>Shipped</option>
<option>Delivered</option>
<option>Cancelled</option>

</select>

<button
name="update_status"
class="btn btn-success">

Update Status

</button>

</form>

</div>

</body>

</html>