<?php
if (isset($_POST['add_user'])){
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
//    $image = $_FILES['image']['name'];
//    $tmp_image = $_FILES['image']['tmp_name'];
    $role = $_POST['role'];


//    move_uploaded_file($tmp_image,"../images/$image");

    $query = "INSERT INTO users (firstname, lastname, username, email, password, role)
              VALUES('{$firstname}','{$lastname}','{$username}','{$email}','{$password}','{$role}')";
    $user=mysqli_query($connection,$query);
    queryResult($user);
    header("Location: users.php");

}
?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="firstname">First Name</label>
        <input type="text" class="form-control" name="firstname">
    </div>
    <div class="form-group">
        <label for="lastname">Last Name</label>
        <input type="text" class="form-control" name="lastname">
    </div>

    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" name="email">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" name="password">
    </div>
<!--    <div class="form-group">-->
<!--        <label for="image">User Image</label>-->
<!--        <input type="file" name="image">-->
<!--    </div>-->

    <div class="form-group">
        <label for="role">Role</label>
        <select id="role" name="role">
            <option value="Admin">Admin</option>
            <option value="Subscriber">Subscriber</option>
        </select>
    </div>




    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="add_user" value="Add User">
    </div>





</form>
