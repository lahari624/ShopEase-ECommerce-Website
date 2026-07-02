<?php
session_start();
include("../includes/db.php");

if(!isset($_SESSION['admin_id']))
{
    header("Location:login.php");
    exit();
}

$id = intval($_GET['id']);

$result = mysqli_query($conn,
"SELECT * FROM categories WHERE id='$id'");

$category = mysqli_fetch_assoc($result);

if(isset($_POST['update']))
{
    $name = mysqli_real_escape_string($conn,$_POST['category']);

    mysqli_query($conn,
    "UPDATE categories
     SET category_name='$name'
     WHERE id='$id'");

    header("Location:categories.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Edit Category</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<?php include("sidebar.php"); ?>

<div style="margin-left:270px;padding:30px;max-width:700px;">

<h2 class="mb-4">

Edit Category

</h2>

<form method="POST">

<div class="mb-3">

<label class="form-label">

Category Name

</label>

<input
type="text"
name="category"
class="form-control"
value="<?php echo htmlspecialchars($category['category_name']); ?>"
required>

</div>

<button
name="update"
class="btn btn-success">

Update Category

</button>

<a
href="categories.php"
class="btn btn-secondary">

Cancel

</a>

</form>

</div>

</body>

</html>