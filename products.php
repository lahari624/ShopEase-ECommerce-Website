<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("includes/db.php");
include("includes/header.php");

$search = "";
$category = "";
$sort = "";

$sql = "SELECT products.*, categories.category_name
        FROM products
        JOIN categories
        ON products.category_id = categories.id
        WHERE 1=1";

if(isset($_GET['search']) && $_GET['search'] != "")
{
    $search = mysqli_real_escape_string($conn,$_GET['search']);
    $sql .= " AND products.product_name LIKE '%$search%'";
}

if(isset($_GET['category']) && $_GET['category'] != "")
{
    $category = intval($_GET['category']);
    $sql .= " AND products.category_id='$category'";
}

if(isset($_GET['sort']))
{
    $sort = $_GET['sort'];

    if($sort=="low")
    {
        $sql .= " ORDER BY products.price ASC";
    }
    elseif($sort=="high")
    {
        $sql .= " ORDER BY products.price DESC";
    }
}

$result = mysqli_query($conn,$sql);

if(!$result)
{
    die("SQL Error : ".mysqli_error($conn));
}
?>

<div class="container mt-4">

<?php

$pageTitle = "All Products";

if($category != "")
{
    $catResult = mysqli_query($conn,
    "SELECT category_name
     FROM categories
     WHERE id='$category'");

    if(mysqli_num_rows($catResult) > 0)
    {
        $cat = mysqli_fetch_assoc($catResult);
        $pageTitle = $cat['category_name'];
    }
}

?>

<h2 class="mb-4">

<?php echo $pageTitle; ?>

</h2>

<form method="GET">

<div class="row mb-4">

<div class="col-md-4">

<input
type="text"
name="search"
class="form-control"
placeholder="Search Products..."
value="<?php echo htmlspecialchars($search); ?>">

</div>

<div class="col-md-3">

<select
name="category"
class="form-select">

<option value="">All Categories</option>

<?php

$cats=mysqli_query($conn,"SELECT * FROM categories");

while($cat=mysqli_fetch_assoc($cats))
{
?>

<option
value="<?php echo $cat['id']; ?>"

<?php
if($category==$cat['id'])
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

<div class="col-md-3">

<select
name="sort"
class="form-select">

<option value="">Sort By</option>

<option
value="low"

<?php
if($sort=="low")
echo "selected";
?>

>

Price Low → High

</option>

<option
value="high"

<?php
if($sort=="high")
echo "selected";
?>

>

Price High → Low

</option>

</select>

</div>

<div class="col-md-2">

<button
class="btn btn-primary w-100">

Search

</button>

</div>

</div>

</form>

<div class="row">

<?php

if(mysqli_num_rows($result)>0)
{

while($row=mysqli_fetch_assoc($result))
{

?>

<div class="col-lg-3 col-md-4 col-sm-6 mb-4">

<div class="card shadow h-100">

<img
src="images/<?php echo $row['image']; ?>"
class="card-img-top"
style="height:220px;object-fit:cover;">

<div class="card-body d-flex flex-column">

<h5>

<?php echo $row['product_name']; ?>

</h5>

<p class="text-muted">

<?php echo $row['category_name']; ?>

</p>

<h4 class="text-success">

₹<?php echo number_format($row['price']); ?>

</h4>

<p>

Stock:
<strong>

<?php echo $row['stock']; ?>

</strong>

</p>

<a
href="product.php?id=<?php echo $row['id']; ?>"
class="btn btn-primary mt-auto">

View Details

</a>

</div>

</div>

</div>

<?php

}

}
else
{

?>

<div class="col-12">

<div class="alert alert-warning">

No products found.

</div>

</div>

<?php

}

?>

</div>

</div>

<?php
include("includes/footer.php");
?>