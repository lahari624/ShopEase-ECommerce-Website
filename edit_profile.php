<?php
session_start();
include("includes/db.php");

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if(isset($_POST['update']))
{
    $fullname = mysqli_real_escape_string($conn,$_POST['fullname']);
    $phone = mysqli_real_escape_string($conn,$_POST['phone']);
    $address = mysqli_real_escape_string($conn,$_POST['address']);

    $sql = "UPDATE users
            SET fullname='$fullname',
                phone='$phone',
                address='$address'
            WHERE id='$user_id'";

    mysqli_query($conn,$sql);

    $_SESSION['user_name'] = $fullname;

    header("Location: profile.php");
    exit();
}

$sql = "SELECT * FROM users WHERE id='$user_id'";
$result = mysqli_query($conn,$sql);
$user = mysqli_fetch_assoc($result);

include("includes/header.php");
?>

<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-md-8">

<div class="card shadow">

<div class="card-header bg-dark text-white">

<h3>Edit Profile</h3>

</div>

<div class="card-body">

<form method="POST">

<div class="mb-3">

<label class="form-label">Full Name</label>

<input
type="text"
name="fullname"
class="form-control"
value="<?php echo htmlspecialchars($user['fullname']); ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">Email</label>

<input
type="email"
class="form-control"
value="<?php echo htmlspecialchars($user['email']); ?>"
readonly>

</div>

<div class="mb-3">

<label class="form-label">Phone</label>

<input
type="text"
name="phone"
class="form-control"
value="<?php echo htmlspecialchars($user['phone']); ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">Address</label>

<textarea
name="address"
class="form-control"
rows="4"><?php echo htmlspecialchars($user['address']); ?></textarea>

</div>

<button
type="submit"
name="update"
class="btn btn-success">

Update Profile

</button>

<a
href="profile.php"
class="btn btn-secondary">

Cancel

</a>

</form>

</div>

</div>

</div>

</div>

</div>

<?php
include("includes/footer.php");
?>