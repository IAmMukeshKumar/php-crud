<?php
require 'includes/index.php';

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


//    if (strlen($_POST["password"]) <= 6) {
//        $errors['password'] = "Password must be atleast 6 characters ";
//    } else {
//
//        $password_sanitized = sanitize($_POST["password"]);
    //  $inputs['password']=md5($password_sanitized);

    $random_function_call = md5(mt_rand(0, getrandmax()));
    $inputs['password'] = md5($random_function_call);

    //    }
//
//    if (empty($_POST["password_match"])) {
//        $errors['password_match'] = "Reenter the password";
//    } else {
//
//       $password_match_sanitized = sanitize($_POST["password_match"]);
//       $inputs['password_match']=md5($password_match_sanitized);
//    }
//
//    if (!(empty($_POST["password"]) && empty($_POST["password_match"]))) {
//        if (strcmp($_POST["password"], $_POST["password_match"])) {
//            $errors['password_matched'] = "Password did not matched";
    //  $inputs['password_match']=($random_function_call);
//        }
//    }


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
    $token = md5(mt_rand(0, getrandmax()));
    $inputs['token'] = $token;

    if (empty($errors)) {

        $values = implode("','", $inputs);

        $sql = "insert into users (name,address,password,email,education,gender,role,token) values ('$values')";
        $result=mysqli_query($conn, $sql);
        if (mysqli_affected_rows($conn)==1) {

            $to = $_POST["email"];
            $subject = 'Your Password';
            $message = 'Your password is : ' . $random_function_call . "  <br>   Link to update your password  http://crud.admin.user/reset-password.php?key=$token ";
            $from = "From:Do not reply. This message is send to you by machine <no-reply@no-reply.biz>";
            // To send HTML mail, the Content-type header must be set
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            mail($to, $subject, $message, $from, $headers);

            header('location: congratulation.php');

        }
        else
        {
            $errors['server']=mysqli_error($conn);
        }
    }
}

require 'partials/header.php';
?>

<div class="container">

    <div class="col-md-6 col-md-offset-3">
        <?php if (getError('server')!=null): ?>
            <div class="alert alert-danger">
                <?php echo "<h4>Server says :</h4> <br> ".getError('server'); ?>
            </div>
        <?php endif ;?>
    </div>

    <form class="form-horizontal col-md-6 col-md-offset-3"
          action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

        <div class="form-group">
            <h1> Fill your credentials</h1>
            <label for="inputName3" class="control-label">Name</label>
            <input type="text" class="form-control" id="inputName3" name="name" placeholder="Name"
                   value="<?php echo old('name') ?>">
            <?php echo getError('name'); ?>
            <br>

            <label for="inputEducation3" class="control-label">Education</label>

            <input type="text" class="form-control" name="education" id="inputEducation3" placeholder="Education"
                   value="<?php echo old('education') ?>">
            <?php echo getError('education'); ?> <br>
            <label for="inputAddress3" class="control-label">Address</label>

            <textarea class="form-control" rows="3" name="address"><?php echo old('address') ?></textarea>
            <?php echo getError('address'); ?> <br>

            <label>
                <p>Gender</p>
                <input type="radio" name="gender" id="optionsRadios1" value=1 <?php if (old('gender') == 1) {
                    echo "checked";
                } ?>>
                Male
                <input type="radio" name="gender" id="optionsRadios2" value=0 <?php if (old('gender') == 0) {
                    echo "checked";
                } ?>>
                Female
            </label>
            <br>

            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" name="email" id="exampleInputEmail1" placeholder="Email"
                   value="<?php echo old('email') ?>">

            <?php echo getError('email'); ?><br>
            <label>
                <p>Role</p>
                <input type="radio" name="role" id="optionsRadios1" value=1 <?php if (old('role') == 1) {
                    echo "checked";
                } ?>>
                Admin
                <input type="radio" name="role" id="optionsRadios2" value=0 <?php if (old('role') == 0) {
                    echo "checked";
                } ?>>
                User
                <?php echo getError('role'); ?>
            </label><br>
            <!--            <label for="exampleInputPassword1">Password </label>-->
            <!---->
            <!--            <input type="password" class="form-control" name="password" id="exampleInputPassword1"-->
            <!--                   placeholder="Password" value="--><?php //echo old('password') ?><!--">-->
            <!--            --><?php //echo getError('password'); ?><!--<br>-->
            <!--            <input type="password" class="form-control" name="password_match" id="exampleInputPassword1"-->
            <!--                   placeholder="Reenter Password" value="-->
            <?php //echo old('password_match') ?><!--">-->
            <!--            --><?php //echo getError('password_match'); ?><!--<br>-->
<!--            --><?php //echo getError('server'); ?>
            <label><br>
                <input type="submit" name="submit" class="btn btn-primary" value="Register">
                <a href="login.php">Login </a>
            </label>
        </div>
    </form>

</div>


<?php require 'partials/footer.php'; ?>

