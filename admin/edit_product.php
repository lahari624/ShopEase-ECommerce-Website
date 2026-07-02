<?php
include("../includes/db.php");

session_start();

if(!isset($_SESSION['admin_id']))
{
    header("Location: login.php");
    exit();
}

$id = intval($_GET['id']);

$product = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT * FROM products WHERE id='$id'")
);

if(isset($_POST['update']))
{
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category = $_POST['category'];

    $image = $product['image'];

    if(!empty($_FILES['image']['name']))
    {
        $image = $_FILES['image']['name'];

        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            "../images/".$image
        );
    }

    mysqli_query($conn,
    "UPDATE products SET

    category_id='$category',
    product_name='$name',
    description='$description',
    price='$price',
    stock='$stock',
    image='$image'

    WHERE id='$id'");

    header("Location: products.php");
    exit();
}
?>

<!DOCTYPE html>

<html>

<head>

<title>Edit Product</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h2>Edit Product</h2>

<form method="POST" enctype="multipart/form-data">

<div class="mb-3">

<label>Category</label>

<select name="category" class="form-control">

<?php

$cats = mysqli_query($conn,"SELECT * FROM categories");

while($cat=mysqli_fetch_assoc($cats))
{

?>

<option
value="<?php echo $cat['id']; ?>"

<?php

if($cat['id']==$product['category_id'])
echo "selected";

?>

>

<?php echo $cat['category_name']; ?>

</option>

<?php
}
?>

</select>

</div>

<div class="mb-3">

<label>Product Name</label>

<input
type="text"
name="name"
class="form-control"
value="<?php echo $product['product_name']; ?>">

</div>

<div class="mb-3">

<label>Description</label>

<textarea
name="description"
class="form-control"><?php echo $product['description']; ?></textarea>

</div>

<div class="mb-3">

<label>Price</label>

<input
type="number"
name="price"
class="form-control"
value="<?php echo $product['price']; ?>">

</div>

<div class="mb-3">

<label>Stock</label>

<input
type="number"
name="stock"
class="form-control"
value="<?php echo $product['stock']; ?>">

</div>

<div class="mb-3">

<label>Current Image</label>

<br>

<img
src="../images/<?php echo $product['image']; ?>"
width="120">

</div>

<div class="mb-3">

<label>New Image (Optional)</label>

<input
type="file"
name="image"
class="form-control">

</div>

<button
class="btn btn-primary"
name="update">

Update Product

</button>

<a
href="products.php"
class="btn btn-secondary">

Cancel

</a>

</form>

</div>

</body>

</html>