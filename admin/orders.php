<?php
include("../includes/db.php");
session_start();

if(!isset($_SESSION['admin_id']))
{
    header("Location: login.php");
    exit();
}

/* Update Status */

if(isset($_POST['update_status']))
{
    $order_id = intval($_POST['order_id']);
    $status = mysqli_real_escape_string($conn,$_POST['status']);

    mysqli_query($conn,
    "UPDATE orders
     SET order_status='$status'
     WHERE id='$order_id'");
}

/* Search */

$search="";

$sql="SELECT
orders.*,
users.fullname,
users.email

FROM orders

INNER JOIN users
ON orders.user_id=users.id

WHERE 1=1";

if(isset($_GET['search']) && $_GET['search']!="")
{
    $search=mysqli_real_escape_string($conn,$_GET['search']);

    $sql.=" AND
    (
    users.fullname LIKE '%$search%'
    OR users.email LIKE '%$search%'
    OR orders.id LIKE '%$search%'
    )";
}

$sql.=" ORDER BY orders.order_date DESC";

$result=mysqli_query($conn,$sql);
?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>Manage Orders</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<?php include("sidebar.php"); ?>

<div style="margin-left:270px;padding:30px;">

<h2 class="mb-4">

Manage Orders

</h2>

<form method="GET" class="row mb-4">

<div class="col-md-10">

<input
type="text"
name="search"
class="form-control"
placeholder="Search by Order ID, Name or Email"
value="<?php echo htmlspecialchars($search); ?>">

</div>

<div class="col-md-2">

<button class="btn btn-primary w-100">

Search

</button>

</div>

</form>

<div class="card shadow">

<div class="card-body">

<table class="table table-bordered table-hover">

<thead class="table-dark">

<tr>

<th>Order ID</th>

<th>Customer</th>

<th>Email</th>

<th>Total</th>

<th>Payment</th>

<th>Status</th>

<th>Date</th>

<th width="260">

Actions

</th>

</tr>

</thead>

<tbody>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>

<td>

#<?php echo $row['id']; ?>

</td>

<td>

<?php echo $row['fullname']; ?>

</td>

<td>

<?php echo $row['email']; ?>

</td>

<td>

₹<?php echo number_format($row['total_amount']); ?>

</td>

<td>

<?php echo $row['payment_method']; ?>

</td>

<td>

<form method="POST" class="d-flex">

<input
type="hidden"
name="order_id"
value="<?php echo $row['id']; ?>">

<select
name="status"
class="form-select form-select-sm">

<option value="Pending"
<?php if($row['order_status']=="Pending") echo "selected"; ?>>

Pending

</option>

<option value="Processing"
<?php if($row['order_status']=="Processing") echo "selected"; ?>>

Processing

</option>

<option value="Shipped"
<?php if($row['order_status']=="Shipped") echo "selected"; ?>>

Shipped

</option>

<option value="Delivered"
<?php if($row['order_status']=="Delivered") echo "selected"; ?>>

Delivered

</option>

<option value="Cancelled"
<?php if($row['order_status']=="Cancelled") echo "selected"; ?>>

Cancelled

</option>

</select>

<button
type="submit"
name="update_status"
class="btn btn-success btn-sm ms-2">

Save

</button>

</form>

</td>

<td>

<?php echo date("d-m-Y",strtotime($row['order_date'])); ?>

</td>

<td>

<a
href="view_order.php?id=<?php echo $row['id']; ?>"
class="btn btn-info btn-sm">

View

</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</body>

</html>