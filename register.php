<?php
include("includes/db.php");

$message = "";

if(isset($_POST['register']))
{
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");

    if(mysqli_num_rows($check)>0)
    {
        $message = "<div class='alert alert-danger'>Email already exists.</div>";
    }
    else
    {
        $sql = "INSERT INTO users(fullname,email,phone,password)
                VALUES('$fullname','$email','$phone','$password')";

        if(mysqli_query($conn,$sql))
        {
            $message = "<div class='alert alert-success'>Registration Successful. Please Login.</div>";
        }
        else
        {
            $message = "<div class='alert alert-danger'>Something went wrong.</div>";
        }
    }
}

include("includes/header.php");
?>

<div class="row justify-content-center">

<div class="col-md-6">

<h2 class="mb-4">Create Account</h2>

<?php echo $message; ?>

<form method="POST">

<div class="mb-3">
<label>Full Name</label>
<input type="text" name="fullname" class="form-control" required>
</div>

<div class="mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control" required>
</div>

<div class="mb-3">
<label>Phone</label>
<input type="text" name="phone" class="form-control" required>
</div>

<div class="mb-3">
<label>Password</label>
<input type="password" name="password" class="form-control" required>
</div>

<button class="btn btn-primary w-100" name="register">
Register
</button>

</form>

</div>

</div>

<?php
include("includes/footer.php");
?>