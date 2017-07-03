<?php
require 'includes/index.php';

$err = '';
if (isset($_SESSION['email']))
    header('location:home.php');
else {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $email = $_POST['email'];
        $password = $_POST['password'];
        $password_md5 = md5($password);

        $query = "select email,role from users where email='$email' and password='$password_md5'";

        $result = mysqli_query($conn, $query);
        $rows = mysqli_fetch_assoc($result);
        $role = $rows["role"];
        if (mysqli_num_rows($result) == 1) {
            $_SESSION['role'] = $rows['role'];
            $_SESSION['email'] = $email;
            header('location:home.php');
        } else {
            $err = "Wrong credentials";
        }
    }
}
require 'partials/header.php';
?>


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

            <input type="password" class="form-control" name="password" id="inputPassword3"
                   placeholder="Password">

        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Sign in</button>

            <a href="register.php">  Register </a>
            <br><br>
            <a href="forgot-password.php">Forgot password? </a>
        </div>


    </form>


</div>


<?php require 'partials/footer.php'; ?>

