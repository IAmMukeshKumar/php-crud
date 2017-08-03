<?php
require 'includes/index.php';

if (!isset($_SESSION['email'])) {
    header('location:index.php');
} else {

    $errors = [];
    $inputs = [];

    //print_r($_SERVER["REQUEST_METHOD"]); die;
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

            $name = $inputs['name'];
            $gender = $inputs['gender'];
            $address = $inputs['address'];
            $education = $inputs['education'];
            $email = $inputs['email'];

            $role = $inputs['role'];
            $sql = "UPDATE users SET name='$name',address='$address', email='$email',education='$education',gender=$gender,role='$role' where email='$email'";


            $result = mysqli_query($conn, $sql);

            $affected = mysqli_affected_rows($conn);
            if ($affected>=1) {
                header('location: congratulation.php');

            } elseif($affected<1) {
                $errors['server'] = "You have made no change in data";

            }
            else{
                $errors['server']=mysqli_error($result);
            }
        }
        $rows = '';
    } else {

        $key = $_REQUEST['key'];
        $query = "select name,address,email,education,gender,role from users where id='$key'";
        $result = mysqli_query($conn, $query);
        $rows = mysqli_fetch_assoc($result);
        $_SESSION['key'] = $key;
    }
}
require 'partials/header.php';

?>

<div class="container">

    <div class="col-md-6 col-md-offset-3">
        <?php if (getError('server')!=null): ?>
        <div class="alert alert-danger">
        <?php echo getError('server'); ?>
    </div>
        <?php endif ;?>
    </div>
    <form class="form-horizontal col-md-6 col-md-offset-3"
          action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?key=" . $_SESSION['key']; ?>" method="POST">

        <div class="form-group">
            <h1> Fill your credentials</h1>
            <label for="inputName3" class="control-label">Name</label>
            <input type="text" class="form-control" id="inputName3" name="name" placeholder="Name"
                   value="<?php if (old('name') == null) {
                       if (getError('name')) {
                           //
                       } else {
                           echo $rows['name'];
                       }

                   } else {
                       echo old('name');
                   } ?>">
            <?php echo getError('name'); ?>
            <br>

            <label for="inputEducation3" class="control-label">Education</label>

            <input type="text" class="form-control" name="education" id="inputEducation3" placeholder="Education"
                   value="<?php if (old('education') == null) {
                       if (getError('education')) {
                           //
                       } else {
                           echo $rows['education'];
                       }
                   } else {
                       echo old('education');
                   } ?>">
            <?php echo getError('education'); ?> <br>
            <label for="inputAddress3" class="control-label">Address</label>

            <textarea class="form-control" rows="3" name="address"><?php if (old('address') == null) {
                    if (getError('address')) {
                        //
                    } else {
                        echo $rows['address'];
                    }
                } else {
                    echo old('address');
                } ?></textarea>
            <?php echo getError('address'); ?> <br>

            <label>
                <p>Gender</p>
                <input type="radio" name="gender" id="optionsRadios1" value=1 <?php
                if (empty($rows)) {
                    if (old('gender') == 1) {
                        echo "checked";
                    }
                } else {
                    if ($rows['gender'] == 1) {
                        echo "checked";
                    }
                }
                ?>>

                Male
                <input type="radio" name="gender" id="optionsRadios2" value=0
                    <?php
                    if (empty($rows)) {
                        if (old('gender') == 0) {
                            echo "checked";
                        }
                    } else {
                        if ($rows['gender'] == 0) {
                            echo "checked";
                        }
                    }
                    ?>
                >
                Female
            </label>
            <br>

            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" name="email" id="exampleInputEmail1" placeholder="Email"
                   value="<?php if (old('email') == null ) {
                       if (getError('email')) {
                           //
                       } else {
                           echo $rows['email'];
                       }
                   } else {
                       echo old('email');
                   } ?>"  readonly>

            <?php echo getError('email'); ?><br>
            <label>
                <p>Role</p>
                <input type="radio" name="role" id="optionsRadios1" value=1 <?php
                if (empty($rows)) {
                    if (old('role') == 1) {
                        echo "checked";
                    }
                } else {
                    if ($rows['role'] == 1) {
                        echo "checked";
                    }
                }
                ?> >
                Admin
                <input type="radio" name="role" id="optionsRadios2" value=0 <?php
                if (empty($rows)) {
                    if (old('role') == 0) {
                        echo "checked";
                    }
                } else {
                    if ($rows['role'] == 0) {
                        echo "checked";
                    }
                }
                ?>>
                User
                <?php echo getError('role'); ?>
            </label><br>

            <label><br>
                <input type="submit" name="submit" class="btn btn-primary" value="Register">

                <button type="reset" class="btn btn-default" value="Reset">Reset</button><br><br>
                <button class="btn btn-default"><a href="includes/logout.php"> <i class="glyphicon glyphicon-off"></i> </a>
                </button>
            </label>
        </div>
    </form>

</div>


<?php require 'partials/footer.php'; ?>
