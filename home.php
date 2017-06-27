
<?php
require 'includes/index.php';

if(!isset($_SESSION['email']))
    header('location:index.php');
require 'partials/header.php' ;
?>


<div class="container">
    <table class="table table-striped">
        <h3> Users</h3>
        <tr>
            <th> Name </th>
            <th> Email</th>
            <th>Education</th>
            <th> Gender </th>
            <th> Role </th>
            <th> Address </th>
            <th> Action</th>
        </tr>

        <?php
        if($_SESSION['role']==1)
        {
            $query="select name,address,email,education,gender,role,id from users";

        }
        else
        {
            $email=$_SESSION['email'];
            $query="select name,address,email,education,gender,role,id from users where email='$email' ";

        }
        $result = mysqli_query($conn,$query);

        while($rows=mysqli_fetch_assoc($result))
        {  ?>

            <tr>
                <td><?php echo $rows["name"] ;?></td>
                <td><?php echo $rows["email"] ;?></td>
                <td><?php echo $rows["education"]; ?></td>
                <td><?php $rows["gender"]? $gender="Male":$gender="Female"; echo $gender;?></td>
                <td><?php $rows["role"]? $role="Admin":$role="User"; echo $role;?></td>
                <td><?php echo $rows["address"] ;?></td>
                <td> <?php echo "<a href='update.php?key=" .$rows['id'] . "'>".'<div class="btn btn-primary btn-xs"> <i class="glyphicon glyphicon-pencil"></i></div>  '. "  </a>" ; ?>
                    <a class="delete_button" data-id="<?php echo $rows['id'];?>"> <div class="btn btn-danger btn-xs" ><i class="glyphicon glyphicon-trash"></i></div></a></td>
            </tr>


        <?php } ?>
    <button class="btn btn-default"><a href="includes/logout.php"> <i class="glyphicon glyphicon-off"></i> </a></button>

    <div>
        <?php require 'partials/footer.php' ;?>