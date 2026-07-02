<?php
include("includes/db.php");

session_start();

$message = "";

if(isset($_POST['login']))
{
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result)==1)
    {
        $user = mysqli_fetch_assoc($result);

        if(password_verify($password,$user['password']))
        {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['fullname'];

            header("Location: index.php");
            exit();
        }
        else
        {
            $message = "<div class='alert alert-danger'>Incorrect Password</div>";
        }
    }
    else
    {
        $message = "<div class='alert alert-danger'>User Not Found</div>";
    }
}

include("includes/header.php");
?>

<div class="row justify-content-center">

<div class="col-md-5">

<h2 class="mb-4">Login</h2>

<?php echo $message; ?>

<form method="POST">

<div class="mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control" required>
</div>

<div class="mb-3">
<label>Password</label>
<input type="password" name="password" class="form-control" required>
</div>

<button type="submit" name="login" class="btn btn-primary w-100">
Login
</button>

</form>

</div>

</div>

<?php
include("includes/footer.php");
?>