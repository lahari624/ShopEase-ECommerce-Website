<?php
include("includes/db.php");
include("includes/header.php");

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM orders
        WHERE user_id='$user_id'
        ORDER BY id DESC";

$result = mysqli_query($conn,$sql);
?>

<div class="container mt-4">

<h2 class="mb-4">My Orders</h2>

<div class="card shadow">

<div class="card-body">

<table class="table table-bordered table-hover align-middle">

<thead class="table-dark">

<tr>

<th>Order ID</th>

<th>Total Amount</th>

<th>Status</th>

<th>Payment</th>

<th>Date</th>

<th>Action</th>

</tr>

</thead>

<tbody>

<?php

if(mysqli_num_rows($result)>0)
{
    while($row=mysqli_fetch_assoc($result))
    {

        if($row['order_status']=="Pending")
        {
            $badge="warning";
        }
        elseif($row['order_status']=="Processing")
        {
            $badge="primary";
        }
        elseif($row['order_status']=="Shipped")
        {
            $badge="info";
        }
        elseif($row['order_status']=="Delivered")
        {
            $badge="success";
        }
        else
        {
            $badge="danger";
        }

?>

<tr>

<td>

#<?php echo $row['id']; ?>

</td>

<td>

₹<?php echo number_format($row['total_amount']); ?>

</td>

<td>

<span class="badge bg-<?php echo $badge; ?>">

<?php echo $row['order_status']; ?>

</span>

</td>

<td>

<?php echo $row['payment_method']; ?>

</td>

<td>

<?php echo date("d-m-Y",strtotime($row['order_date'])); ?>

</td>

<td>

<a
href="order_details.php?id=<?php echo $row['id']; ?>"
class="btn btn-primary btn-sm">

View Details

</a>

</td>

</tr>

<?php

    }
}
else
{

?>

<tr>

<td colspan="6" class="text-center">

No Orders Found

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

<?php
include("includes/footer.php");
?>