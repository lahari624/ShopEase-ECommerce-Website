<?php
include("../includes/db.php");

session_start();

if(!isset($_SESSION['admin_id']))
{
    header("Location: login.php");
    exit();
}

if(isset($_GET['delete']))
{
    $id = intval($_GET['delete']);

    mysqli_query($conn,"DELETE FROM users WHERE id='$id'");

    header("Location: customers.php");
    exit();
}

$result = mysqli_query($conn,"SELECT * FROM users ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>

<head>

<title>Customers</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h2>Customers</h2>

<a href="dashboard.php" class="btn btn-secondary mb-3">
Dashboard
</a>

<table class="table table-bordered table-hover">

<thead class="table-dark">

<tr>

<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>Registered</th>
<th>Action</th>

</tr>

</thead>

<tbody>

<?php while($user=mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?php echo $user['id']; ?></td>

<td><?php echo $user['fullname']; ?></td>

<td><?php echo $user['email']; ?></td>

<td><?php echo $user['phone']; ?></td>

<td><?php echo date("d-m-Y",strtotime($user['created_at'])); ?></td>

<td>

<a href="customers.php?delete=<?php echo $user['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this customer?')">

Delete

</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</body>

</html>