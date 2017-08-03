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
    if (empty($_POST["email"])) {
        $errors['email'] = "Email is required";
    } else {
        $inputs['email'] = sanitize($_POST["email"]);
        if (!filter_var($inputs['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email format";
        }
    }

    if (empty($errors)) {

        $name = $inputs['name'];
        $email = $inputs['email'];
        $query = "select id from users where email='$email' and name='$name'";
        $result = mysqli_query($conn, $query);
        $rows = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) == 1) {
            $random_function_call = md5(mt_rand(0, getrandmax()));
            $password_md5 = md5($random_function_call);

            $id = $rows['id'];
            $token = md5(mt_rand(0, getrandmax()));
            $query_set_token = "UPDATE users SET token='$token',password='$password_md5' where id='$id'";

            $result = mysqli_query($conn, $query_set_token);
            $affected = mysqli_affected_rows($conn);

            if ($affected == 1) {
                $to = $_POST["email"];
                $subject = 'Your Password';
                $message = 'Your password is : ' . $random_function_call . "     Link to update your password  http://crud.admin.user/reset-password.php?key=$token ";
                $from = "From:Do not reply. This message is send to you by machine <no-reply@no-reply.biz>";

                // To send HTML mail, the Content-type header must be set
                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $mail = mail($to, $subject, $message, $from, $headers);
                if ($mail) {
                    $inputs['mail_confirmation'] = " Machine generated password and <abbr title='ONE TIME LINK'>OTL</abbr> has been sent to your mail please check your MAIL  <br> <a href='login.php'> Login</a> ";
                } else {
                    $inputs['mail_confirmation'] = "We are not able to send mail currently please try later";
                }
            }
        } elseif (mysqli_num_rows($result) < 1) {

            $inputs['mail_confirmation'] = "Email or Name is/are not valid please try again with a valid one";

        } else {

            echo mysqli_error($conn);

        }
    }
}

require 'partials/header.php';
?>
    <div class="container">
        <div class="col-md-6 col-md-offset-3">
            <?php if (!empty($inputs['mail_confirmation'])): ?>
                <div class="alert alert-danger">
                    <?php echo $inputs['mail_confirmation'] ?>
                </div>
            <?php endif; ?>
        </div>

        <form class="form-horizontal col-md-6 col-md-offset-3"
              action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" name="email" id="exampleInputEmail1" placeholder="Email"
                   value="<?php echo old('email') ?>">
            <?php echo getError('email'); ?><br>
            <label for="exampleInputName">Your name </label>
            <input type="text" class="form-control" id="inputName3" name="name" placeholder="Name"
                   value="<?php echo old('name') ?>">
            <?php echo getError('name'); ?>
            <br>
            <input type="submit" name="submit" class="btn btn-primary" value="Go">
            <button type="reset" class="btn btn-default" value="Reset">Reset</button>
        </form>
    </div>

<?php require 'partials/footer.php'; ?>