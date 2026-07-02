<?php
session_start();
include("../includes/db.php");

if(!isset($_SESSION['admin_id']))
{
    header("Location:login.php");
    exit();
}

/* Add Category */

if(isset($_POST['add']))
{
    $category=mysqli_real_escape_string($conn,$_POST['category']);

    mysqli_query($conn,
    "INSERT INTO categories(category_name)
    VALUES('$category')");

    header("Location:categories.php");
    exit();
}

/* Delete Category */

if(isset($_GET['delete']))
{
    $id=intval($_GET['delete']);

    mysqli_query($conn,
    "DELETE FROM categories
    WHERE id='$id'");

    header("Location:categories.php");
    exit();
}

?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>Manage Categories</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<?php include("sidebar.php"); ?>

<div style="margin-left:270px;padding:30px;">

<h2 class="mb-4">

Manage Categories

</h2>

<div class="card shadow">

<div class="card-body">

<form method="POST">

<div class="row mb-4">

<div class="col-md-9">

<input
type="text"
name="category"
class="form-control"
placeholder="Enter Category Name"
required>

</div>

<div class="col-md-3">

<button
name="add"
class="btn btn-success w-100">

Add Category

</button>

</div>

</div>

</form>

<table class="table table-bordered table-hover">

<thead class="table-dark">

<tr>

<th>ID</th>

<th>Category Name</th>

<th width="200">

Actions

</th>

</tr>

</thead>

<tbody>

<?php

$result=mysqli_query($conn,
"SELECT * FROM categories
ORDER BY id");

while($row=mysqli_fetch_assoc($result))
{

?>

<tr>

<td>

<?php echo $row['id']; ?>

</td>

<td>

<?php echo $row['category_name']; ?>

</td>

<td>

<a
href="edit_category.php?id=<?php echo $row['id']; ?>"
class="btn btn-primary btn-sm">

Edit

</a>

<a
href="categories.php?delete=<?php echo $row['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Are you sure you want to delete this category?')">

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