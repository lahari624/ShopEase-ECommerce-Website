<?php
session_start();
include("includes/db.php");

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM users WHERE id='$user_id'";
$result = mysqli_query($conn,$sql);

$user = mysqli_fetch_assoc($result);

include("includes/header.php");
?>

<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-md-8">

<div class="card shadow">

<div class="card-header bg-dark text-white">

<h3>My Profile</h3>

</div>

<div class="card-body">

<table class="table">

<tr>
<th>Name</th>
<td><?php echo $user['fullname']; ?></td>
</tr>

<tr>
<th>Email</th>
<td><?php echo $user['email']; ?></td>
</tr>

<tr>
<th>Phone</th>
<td><?php echo $user['phone']; ?></td>
</tr>

<tr>
<th>Address</th>
<td><?php echo $user['address']; ?></td>
</tr>

<tr>
<th>Registered On</th>
<td><?php echo $user['created_at']; ?></td>
</tr>

</table>

<a href="edit_profile.php" class="btn btn-primary">
Edit Profile
</a>

<a href="orders.php" class="btn btn-success">
My Orders
</a>

</div>

</div>

</div>

</div>

</div>

<?php
include("includes/footer.php");
?>