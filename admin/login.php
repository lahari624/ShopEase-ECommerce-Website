<?php
include("../includes/db.php");
session_start();

$message = "";

if(isset($_POST['login']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admins WHERE username='$username'";

    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result)==1)
    {
        $admin = mysqli_fetch_assoc($result);

        if($password == $admin['password'])
        {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['username'];

            header("Location: dashboard.php");
            exit();
        }
        else
        {
            $message = "Incorrect Password";
        }
    }
    else
    {
        $message = "Admin Not Found";
    }
}
?>

<!DOCTYPE html>

<html>

<head>

<title>Admin Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container">

<div class="row justify-content-center mt-5">

<div class="col-md-4">

<div class="card shadow">

<div class="card-body">

<h3 class="text-center mb-4">

Admin Login

</h3>

<?php

if($message!="")
{
?>

<div class="alert alert-danger">

<?php echo $message; ?>

</div>

<?php
}
?>

<form method="POST">

<div class="mb-3">

<label>Username</label>

<input
type="text"
name="username"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Password</label>

<input
type="password"
name="password"
class="form-control"
required>

</div>

<button
class="btn btn-dark w-100"
name="login">

Login

</button>

</form>

</div>

</div>

</div>

</div>

</div>

</body>

</html>