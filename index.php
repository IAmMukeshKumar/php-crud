<?php
require 'includes/index.php';

$err = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "select email from admin_user where email='$email' and password='$password'";

    $result = mysqli_query($conn,$query);

    if (mysqli_num_rows($result)==1) {
        $_SESSION['email'] = $email;
        header('location:http://localhost/CRUD/Home.php');
    }
    else {
        $err = "Wrong credentials";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login form</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap-3.3.7-dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">

    <form class="form-horizontal col-md-6 col-md-offset-3"
          action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <div class="form-group">
            <h4 style="color:red"><?= $err ?></h4>
            <label for="inputEmail3" class="control-label">Email</label>

            <input type="email" class="form-control" id="inputEmail3" name="email" placeholder="Email">

        </div>

        <div class="form-group">
            <label for="inputPassword3" class="control-label">Password</label>

            <input type="password" class="form-control" name="password" id="inputPassword3" placeholder="Password">

        </div>


        <button type="submit" class="btn btn-primary">Sign in</button>
        <buton class="btn btn-default"><a href="Register.php"> New register </a></buton>


    </form>
</div>


</body>
</html>

