<?php
include("../includes/db.php");

session_start();

if(!isset($_SESSION['admin_id']))
{
    header("Location: login.php");
    exit();
}

if(isset($_POST['save']))
{

$name=$_POST['name'];

$price=$_POST['price'];

$stock=$_POST['stock'];

$description=$_POST['description'];

$category=$_POST['category'];

$image=$_FILES['image']['name'];

move_uploaded_file(
$_FILES['image']['tmp_name'],
"../images/".$image
);

mysqli_query($conn,

"INSERT INTO products
(category_id,product_name,description,price,stock,image)

VALUES

('$category','$name','$description','$price','$stock','$image')");

header("Location: products.php");

exit();

}
?>

<!DOCTYPE html>

<html>

<head>

<title>Add Product</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h2>Add Product</h2>

<form method="POST" enctype="multipart/form-data">

<div class="mb-3">

<label>Category</label>

<select name="category" class="form-control">

<?php

$c=mysqli_query($conn,"SELECT * FROM categories");

while($cat=mysqli_fetch_assoc($c))
{
?>

<option value="<?php echo $cat['id']; ?>">

<?php echo $cat['category_name']; ?>

</option>

<?php
}
?>

</select>

</div>

<div class="mb-3">
<label>Product Name</label>
<input type="text" name="name" class="form-control" required>
</div>

<div class="mb-3">
<label>Description</label>
<textarea name="description" class="form-control"></textarea>
</div>

<div class="mb-3">
<label>Price</label>
<input type="number" name="price" class="form-control" required>
</div>

<div class="mb-3">
<label>Stock</label>
<input type="number" name="stock" class="form-control" required>
</div>

<div class="mb-3">
<label>Image</label>
<input type="file" name="image" class="form-control" required>
</div>

<button class="btn btn-success" name="save">
Save Product
</button>

<a href="products.php" class="btn btn-secondary">
Cancel
</a>

</form>

</div>

</body>

</html>