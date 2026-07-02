<?php
session_start();
include("../includes/db.php");

if(!isset($_SESSION['admin_id']))
{
    header("Location:login.php");
    exit();
}

/* Delete User */

if(isset($_GET['delete']))
{
    $id = intval($_GET['delete']);

    mysqli_query($conn,
    "DELETE FROM users WHERE id='$id'");

    header("Location:users.php");
    exit();
}

$search="";

$sql="SELECT * FROM users";

if(isset($_GET['search']) && $_GET['search']!="")
{
    $search=mysqli_real_escape_string($conn,$_GET['search']);

    $sql.=" WHERE fullname LIKE '%$search%'
          OR email LIKE '%$search%'
          OR phone LIKE '%$search%'";
}

$sql.=" ORDER BY id DESC";

$result=mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Manage Users</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<?php include("sidebar.php"); ?>

<div style="margin-left:270px;padding:30px;">

<h2 class="mb-4">

Manage Users

</h2>

<form method="GET" class="row mb-4">

<div class="col-md-10">

<input
type="text"
name="search"
class="form-control"
placeholder="Search by Name, Email or Phone"
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

<th>ID</th>

<th>Name</th>

<th>Email</th>

<th>Phone</th>

<th>Registered</th>

<th>Action</th>

</tr>

</thead>

<tbody>

<?php

while($row=mysqli_fetch_assoc($result))
{

?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['fullname']; ?></td>

<td><?php echo $row['email']; ?></td>

<td><?php echo $row['phone']; ?></td>

<td><?php echo $row['created_at']; ?></td>

<td>

<a
href="users.php?delete=<?php echo $row['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this user?')">

Delete

</a>

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

</body>

</html>