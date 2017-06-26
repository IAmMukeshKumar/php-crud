<?php
require 'includes/index.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

$errors = [];
$inputs = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["name"])) {
        $errors['name'] = "Name is required";
    } else {
        $inputs['name'] = sanitize($_POST["name"]);
        if (!preg_match("/^[a-zA-Z ]*$/", $_POST['name'])) {
            $errors['name'] = "Only letters and white space allowed";
        }
    }

    if (empty($_POST["address"])) {
        $errors['address'] = "Address is required";
    } else {
        $inputs['address'] = sanitize($_POST["address"]);
    }

    if (strlen($_POST["password"]) <= 6) {
        $errors['password'] = "Password must be atleast 6 characters ";
    } else {

        $password_sanitized = sanitize($_POST["password"]);
        $inputs['password']=md5($password_sanitized);
    }

    if (empty($_POST["password_match"])) {
        $errors['password_match'] = "Reenter the password";
    } else {

       $password_match_sanitized = sanitize($_POST["password_match"]);
       $inputs['password_match']=md5($password_match_sanitized);
    }

    if (!(empty($_POST["password"]) && empty($_POST["password_match"]))) {
        if (strcmp($_POST["password"], $_POST["password_match"])) {
            $errors['password_matched'] = "Password did not matched";
        }
    }


    if (empty($_POST["email"])) {
        $errors['email'] = "Email is required";
    } else {
        $inputs['email'] = sanitize($_POST["email"]);
        if (!filter_var($inputs['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email format";
        }
    }

    if (empty($_POST["education"])) {
        $errors['education'] = "Education is required";
    } else {
        $inputs['education'] = sanitize($_POST["education"]);
    }

    if (empty($_POST["address"])) {
        $errors['address'] = "Address is required";
    } else {
        $inputs['address'] = sanitize($_POST["address"]);
    }


        $inputs['gender'] = sanitize($_POST["gender"]);

        $inputs['role'] = sanitize($_POST["role"]);

    if (empty($errors)) {

        $values = implode("','", $inputs);

        $sql = "insert into users (name,address, password,password_match,email,education,gender,role) values ('$values')";

     print_r($sql);

         echo $inputs["name"];

        if (mysqli_query($conn, $sql)) {
            header('location: congratulation.php');

        } else {
            $errors['server'] = "Error registering, please try again.";

        }
    }
}

require 'partials/header.php';
?>



<div class="container">

    <div class="col-md-6 col-md-offset-3">
        <?php if (!empty(getError('password_matched'))): ?>
            <div class="alert alert-danger">
                 <?php echo getError('password_matched'); ?>
            </div>
        <?php endif; ?>
    </div>

    <form class="form-horizontal col-md-6 col-md-offset-3"
          action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

        <div class="form-group">
            <h1> Fill your credentials</h1>
            <label for="inputName3" class="control-label">Name</label>
            <input type="text" class="form-control" id="inputName3" name="name" placeholder="Name"
                   value="<?php old('name') ?>">
            <?php echo getError('name'); ?>
            <br>

            <label for="inputEducation3" class="control-label">Education</label>

            <input type="text" class="form-control" name="education" id="inputEducation3" placeholder="Education" value="<?php old('education') ?>">
            <?php echo getError('education'); ?> <br>
            <label for="inputAddress3" class="control-label">Address</label>

            <textarea class="form-control" rows="3" name="address"><?php echo old('address') ?></textarea>
            <?php echo getError('address'); ?> <br>

            <label>
                <p>Gender</p>
                <input type="radio" name="gender" id="optionsRadios1" value=1 checked>
                Male
                <input type="radio" name="gender" id="optionsRadios2" value=0>
                Female
            </label>
            <br>

            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" name="email" id="exampleInputEmail1" placeholder="Email" value="<?php old('email') ?>">

            <?php echo getError('email'); ?><br>
            <label>
                <p>Role</p>
                <input type="radio" name="role" id="optionsRadios1" value=1 checked>
                Admin
                <input type="radio" name="role" id="optionsRadios2" value=0>
                User
                <?php echo getError('role'); ?>
            </label><br>

            <label for="exampleInputPassword1">Password </label>

            <input type="password" class="form-control" name="password" id="exampleInputPassword1"
                   placeholder="Password" value="<?php old('password') ?>">
            <?php echo getError('password'); ?><br>
            <input type="password" class="form-control" name="password_match" id="exampleInputPassword1"
                   placeholder="Reenter Password" value="<?php old('password_match') ?>">
            <?php echo getError('password_match'); ?><br>
            <?php echo getError('server'); ?>
            <label><br>
                <input type="submit" name="submit" class="btn btn-primary" value="Register">
            </label>
        </div>
    </form>

</div>


<?php require 'partials/footer.php';?>

