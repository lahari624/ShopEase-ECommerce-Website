<?php
session_start();
include("../includes/db.php");

if(!isset($_SESSION['admin_id']))
{
    header("Location:login.php");
    exit();
}

/* Dashboard Statistics */

$totalProducts=mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM products"))['total'];

$totalUsers=mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM users"))['total'];

$totalOrders=mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM orders"))['total'];

$totalRevenue=mysqli_fetch_assoc(mysqli_query($conn,
"SELECT SUM(total_amount) AS total FROM orders"))['total'];

if($totalRevenue=="")
{
    $totalRevenue=0;
}

/* Monthly Sales */

$months=[];
$sales=[];

$q=mysqli_query($conn,"
SELECT
DATE_FORMAT(order_date,'%b') AS month,
SUM(total_amount) AS total

FROM orders

GROUP BY MONTH(order_date)

ORDER BY MONTH(order_date)
");

while($row=mysqli_fetch_assoc($q))
{
    $months[]=$row['month'];
    $sales[]=$row['total'];
}
?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>Admin Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

body{

background:#f4f6f9;

}

.main{

margin-left:260px;

padding:30px;

}

.card{

border:none;

border-radius:12px;

}

.card-body{

padding:25px;

}

.table{

margin-bottom:0;

}

</style>

</head>

<body>

<?php include("sidebar.php"); ?>

<div class="main">

<h2 class="mb-4">

Admin Dashboard

</h2>

<div class="row">

<div class="col-md-3 mb-4">

<div class="card bg-primary text-white shadow">

<div class="card-body text-center">

<h5>Total Products</h5>

<h2>

<?php echo $totalProducts; ?>

</h2>

</div>

</div>

</div>

<div class="col-md-3 mb-4">

<div class="card bg-success text-white shadow">

<div class="card-body text-center">

<h5>Total Users</h5>

<h2>

<?php echo $totalUsers; ?>

</h2>

</div>

</div>

</div>

<div class="col-md-3 mb-4">

<div class="card bg-warning shadow">

<div class="card-body text-center">

<h5>Total Orders</h5>

<h2>

<?php echo $totalOrders; ?>

</h2>

</div>

</div>

</div>

<div class="col-md-3 mb-4">

<div class="card bg-danger text-white shadow">

<div class="card-body text-center">

<h5>Total Revenue</h5>

<h3>

₹<?php echo number_format($totalRevenue); ?>

</h3>

</div>

</div>

</div>

</div>

<!-- Monthly Sales Chart -->

<div class="card shadow mb-5">

<div class="card-header bg-dark text-white">

<h5 class="mb-0">Monthly Sales Report</h5>

</div>

<div class="card-body">

<canvas id="salesChart" height="100"></canvas>

</div>

</div>

<div class="row">

<!-- Recent Orders -->

<div class="col-lg-6 mb-4">

<div class="card shadow">

<div class="card-header bg-primary text-white">

Recent Orders

</div>

<div class="card-body">

<table class="table table-striped table-hover">

<thead>

<tr>

<th>ID</th>

<th>Amount</th>

<th>Status</th>

</tr>

</thead>

<tbody>

<?php

$orders=mysqli_query($conn,
"SELECT * FROM orders
ORDER BY id DESC
LIMIT 5");

while($o=mysqli_fetch_assoc($orders))
{

?>

<tr>

<td>

#<?php echo $o['id']; ?>

</td>

<td>

₹<?php echo number_format($o['total_amount']); ?>

</td>

<td>

<span class="badge bg-success">

<?php echo $o['order_status']; ?>

</span>

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

</div>

</div>

<!-- Low Stock Products -->

<div class="col-lg-6 mb-4">

<div class="card shadow">

<div class="card-header bg-danger text-white">

Low Stock Products

</div>

<div class="card-body">

<table class="table table-striped table-hover">

<thead>

<tr>

<th>Product</th>

<th>Stock</th>

</tr>

</thead>

<tbody>

<?php

$low=mysqli_query($conn,
"SELECT * FROM products
WHERE stock<=5");

while($p=mysqli_fetch_assoc($low))
{

?>

<tr>

<td>

<?php echo $p['product_name']; ?>

</td>

<td>

<span class="badge bg-danger">

<?php echo $p['stock']; ?>

</span>

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

</div>

</div>

</div>

<script>

const ctx = document.getElementById('salesChart');

new Chart(ctx,{

type:'line',

data:{

labels:[
<?php
foreach($months as $month)
{
    echo "'".$month."',";
}
?>
],

datasets:[{

label:'Monthly Sales',

data:[
<?php
foreach($sales as $sale)
{
    echo $sale.",";
}
?>
],

borderColor:'#0d6efd',

backgroundColor:'rgba(13,110,253,0.20)',

borderWidth:3,

fill:true,

tension:0.4,

pointBackgroundColor:'#0d6efd',

pointRadius:5

}]

},

options:{

responsive:true,

maintainAspectRatio:false,

plugins:{

legend:{

display:true

}

},

scales:{

y:{

beginAtZero:true

}

}

}

});

</script>

</div>

</body>

</html>