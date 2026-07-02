<?php
session_start();
include("../includes/db.php");

// Optional: Protect admin page
/*
if(!isset($_SESSION['admin_id']))
{
    header("Location: login.php");
    exit();
}
*/
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Manage Products</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="d-flex justify-content-between mb-4">

<h2>Manage Products</h2>

<a href="add_product.php" class="btn btn-success">
+ Add Product
</a>

</div>

<table class="table table-bordered table-striped table-hover">

<thead class="table-dark">

<tr>

<th>ID</th>

<th>Image</th>

<th>Product</th>

<th>Category</th>

<th>Price</th>

<th>Stock</th>

<th width="180">Action</th>

</tr>

</thead>

<tbody>

<?php

$sql="SELECT products.*, categories.category_name

FROM products

JOIN categories

ON products.category_id=categories.id

ORDER BY products.id DESC";

$result=mysqli_query($conn,$sql);

while($row=mysqli_fetch_assoc($result))
{

?>

<tr>

<td>

<?php echo $row['id']; ?>

</td>

<td>

<img src="../images/<?php echo $row['image']; ?>"

width="70"

height="70"

style="object-fit:cover;">

</td>

<td>

<?php echo $row['product_name']; ?>

</td>

<td>

<?php echo $row['category_name']; ?>

</td>

<td>

₹<?php echo number_format($row['price']); ?>

</td>

<td>

<?php echo $row['stock']; ?>

</td>

<td>

<a href="edit_product.php?id=<?php echo $row['id']; ?>"

class="btn btn-primary btn-sm">

Edit

</a>

<a href="delete_product.php?id=<?php echo $row['id']; ?>"

class="btn btn-danger btn-sm"

onclick="return confirm('Delete this product?')">

Delete

</a>

</td>

</tr>

<?php

}

?>

</tbody>

</table>

<a href="dashboard.php" class="btn btn-secondary">
    ← Back to Dashboard
</a>

</div>

</body>

</html>