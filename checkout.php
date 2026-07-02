<?php
include("includes/db.php");
include("includes/header.php");

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$total = 0;

$sql = "SELECT cart.*, products.product_name, products.price
        FROM cart
        INNER JOIN products
        ON cart.product_id = products.id
        WHERE cart.user_id='$user_id'";

$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result)==0)
{
    echo "<h3>Your cart is empty.</h3>";
    include("includes/footer.php");
    exit();
}

if(isset($_POST['place_order']))
{

    $address = mysqli_real_escape_string($conn,$_POST['address']);
    $payment = mysqli_real_escape_string($conn,$_POST['payment']);

    $cart = mysqli_query($conn,$sql);

    while($row=mysqli_fetch_assoc($cart))
    {
        $total += $row['price'] * $row['quantity'];
    }

    mysqli_query($conn,
    "INSERT INTO orders
    (user_id,total_amount,shipping_address,payment_method)
    VALUES
    ('$user_id','$total','$address','$payment')");

    $order_id = mysqli_insert_id($conn);

    $cart = mysqli_query($conn,$sql);

    while($row=mysqli_fetch_assoc($cart))
    {

        mysqli_query($conn,

        "INSERT INTO order_items
        (order_id,product_id,quantity,price)

        VALUES

        ('$order_id',
        '{$row['product_id']}',
        '{$row['quantity']}',
        '{$row['price']}')");

    }

    mysqli_query($conn,
    "DELETE FROM cart
    WHERE user_id='$user_id'");

    header("Location: order_success.php");
    exit();

}
?>

<div class="container mt-4">

<h2>Checkout</h2>

<form method="POST">

<div class="mb-3">

<label>Shipping Address</label>

<textarea
name="address"
class="form-control"
required></textarea>

</div>

<div class="mb-3">

<label>Payment Method</label>

<select
name="payment"
class="form-control">

<option>Cash on Delivery</option>
<option>UPI</option>
<option>Debit Card</option>
<option>Credit Card</option>

</select>

</div>

<h4 class="mt-4">Order Summary</h4>

<table class="table table-bordered">

<tr>

<th>Product</th>
<th>Price</th>
<th>Qty</th>
<th>Total</th>

</tr>

<?php

$total = 0;

$cart = mysqli_query($conn,$sql);

while($row=mysqli_fetch_assoc($cart))
{

$itemTotal = $row['price'] * $row['quantity'];

$total += $itemTotal;

?>

<tr>

<td><?php echo $row['product_name']; ?></td>

<td>
₹<?php echo number_format($row['price']); ?>
</td>

<td>
<?php echo $row['quantity']; ?>
</td>

<td>
₹<?php echo number_format($itemTotal); ?>
</td>

</tr>

<?php
}
?>

<tr>

<th colspan="3">

Grand Total

</th>

<th>

₹<?php echo number_format($total); ?>

</th>

</tr>

</table>

<button
class="btn btn-success btn-lg"
name="place_order">

Place Order

</button>

</form>

</div>

<?php
include("includes/footer.php");
?>