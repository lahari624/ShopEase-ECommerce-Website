<?php
session_start();
include("../includes/db.php");

if(!isset($_SESSION['admin_id']))
{
    header("Location:login.php");
    exit();
}

$id = intval($_GET['id']);

$order = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM orders WHERE id='$id'"));

if(isset($_POST['update']))
{
    $status = mysqli_real_escape_string($conn,$_POST['status']);

    mysqli_query($conn,
    "UPDATE orders
     SET order_status='$status'
     WHERE id='$id'");

    header("Location:orders.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Update Order</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<?php include("sidebar.php"); ?>

<div style="margin-left:270px;padding:30px;max-width:700px;">

<h2 class="mb-4">

Update Order Status

</h2>

<form method="POST">

<div class="mb-3">

<label class="form-label">

Order Status

</label>

<select
name="status"
class="form-select">

<option value="Pending"
<?php if($order['order_status']=="Pending") echo "selected"; ?>>

Pending

</option>

<option value="Processing"
<?php if($order['order_status']=="Processing") echo "selected"; ?>>

Processing

</option>

<option value="Shipped"
<?php if($order['order_status']=="Shipped") echo "selected"; ?>>

Shipped

</option>

<option value="Delivered"
<?php if($order['order_status']=="Delivered") echo "selected"; ?>>

Delivered

</option>

<option value="Cancelled"
<?php if($order['order_status']=="Cancelled") echo "selected"; ?>>

Cancelled

</option>

</select>

</div>

<button
name="update"
class="btn btn-success">

Update Status

</button>

<a
href="orders.php"
class="btn btn-secondary">

Cancel

</a>

</form>

</div>

</body>

</html>