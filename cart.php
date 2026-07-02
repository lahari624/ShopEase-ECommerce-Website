<?php
include("includes/db.php");
include("includes/header.php");

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Add Product to Cart
if(isset($_POST['add_cart']))
{
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    $check = mysqli_query($conn,
    "SELECT * FROM cart
     WHERE user_id='$user_id'
     AND product_id='$product_id'");

    if(mysqli_num_rows($check)>0)
    {
        mysqli_query($conn,
        "UPDATE cart
         SET quantity = quantity + $quantity
         WHERE user_id='$user_id'
         AND product_id='$product_id'");
    }
   else
    {
        $insert = mysqli_query($conn,
        "INSERT INTO cart(user_id,product_id,quantity)
        VALUES('$user_id','$product_id','$quantity')");

        if(!$insert)
        {
            die("Database Error: " . mysqli_error($conn));
        }
    }

    header("Location: cart.php");
    exit();
}

// Remove Product
if(isset($_GET['delete']))
{
    $cart_id = intval($_GET['delete']);

    mysqli_query($conn,
    "DELETE FROM cart
     WHERE id='$cart_id'
     AND user_id='$user_id'");

    header("Location: cart.php");
    exit();
}

?>

<div class="container mt-4">

<h2 class="mb-4">Shopping Cart</h2>

<table class="table table-bordered table-hover align-middle">

<thead class="table-dark">

<tr>

<th>Image</th>
<th>Product</th>
<th>Price</th>
<th>Quantity</th>
<th>Total</th>
<th>Action</th>

</tr>

</thead>

<tbody>

<?php

$total = 0;

$sql = "SELECT
cart.id,
products.product_name,
products.price,
products.image,
cart.quantity

FROM cart

INNER JOIN products
ON cart.product_id = products.id

WHERE cart.user_id='$user_id'";

$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result)>0)
{

while($row=mysqli_fetch_assoc($result))
{

$itemTotal = $row['price'] * $row['quantity'];

$total += $itemTotal;

?>

<tr>

<td width="120">
<img src="images/<?php echo $row['image']; ?>" width="80">
</td>

<td>
<?php echo $row['product_name']; ?>
</td>

<td>
₹<?php echo number_format($row['price']); ?>
</td>

<td>
<?php echo $row['quantity']; ?>
</td>

<td>
₹<?php echo number_format($itemTotal); ?>
</td>

<td>

<a href="cart.php?delete=<?php echo $row['id']; ?>"
class="btn btn-danger btn-sm">

Remove

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

Your cart is empty.

</td>

</tr>

<?php
}
?>

<tr>

<th colspan="4" class="text-end">

Grand Total

</th>

<th>

₹<?php echo number_format($total); ?>

</th>

<th></th>

</tr>

</tbody>

</table>

<?php if($total>0){ ?>

<a href="checkout.php" class="btn btn-success">

Proceed to Checkout

</a>

<?php } ?>

</div>

<?php
include("includes/footer.php");
?>