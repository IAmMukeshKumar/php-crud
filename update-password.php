<?php
require 'includes/index.php';
$errors = [];
$inputs = [];
if(!isset($_SESSION['email']))
    header('location:index.php');

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (empty($_POST["email"])) {
        $errors['email'] = "Email is required";
    } else {
        $inputs['email'] = $_POST["email"];
    }

    if (empty($_POST["password"])) {
        $errors['password'] = "Please insert a password";
    } else {
        $inputs['password'] = $_POST["password"];
    }

    if (empty($errors)) {
        $email = $inputs['email'];
        $password = $inputs['password'];
        $password_md5=md5($password);
        $token_update=md5(mt_rand(0,getrandmax()));
        $sql = "UPDATE users SET password='$password_md5', token='$token_update'  WHERE email='$email'";

        $result = mysqli_query($conn, $sql);

        if ($result) {
         echo "Updated";
        }
        else{
            echo "No";
        }
    }
}
require 'partials/header.php';
?>

<div class="container">

    <form class="form-horizontal col-md-6 col-md-offset-3"
          action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <h1> Reset your password</h1>

        <label for="exampleInputEmail1">Email address</label>
        <input type="email" class="form-control" name="email" id="exampleInputEmail1" placeholder="Email" value="<?php echo old('email') ?>">
        <?php echo getError('email'); ?><br>
        <label for="exampleInputPassword1"> New password </label>
        <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Password" value="<?php echo old('password') ?>">
        <?php echo getError('password'); ?><br>
        <label><br>
            <input type="submit" name="submit" class="btn btn-primary" value="Submit">
        </label>
    </form>
</div>

<?php require 'partials/footer.php'; ?>

