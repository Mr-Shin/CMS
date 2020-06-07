<?php
if (isset($_GET['id'])){
    $id = $_GET['id'];
    $query ="SELECT * FROM users WHERE id={$id}";
    $res = mysqli_query($connection,$query);
    queryResult($res);
    while ($row = mysqli_fetch_assoc($res)){
        $user_id = $row['id'];
        $user_firstname = "{$row['firstname']}";
        $user_lastname = "{$row['lastname']}";
        $username = $row['username'];
        $pass = $row['password'];
        $user_email = $row['email'];
        $user_role = $row['role'];
    }
}
else{
    header("Location: index.php");
}

if (isset($_POST['update_user'])){
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    if (!empty($_POST['password'])){
    $password = $_POST['password'];
    $password = password_hash($password, PASSWORD_BCRYPT);
    }
    else{
        $password = $pass;
    }

    $role = $_POST['role'];

    $query = "UPDATE users SET ";
    $query .="firstname  = '{$firstname}', ";
    $query .="lastname  = '{$lastname}', ";
    $query .="username = '{$username}', ";
    $query .="email   =  '{$email}', ";
    $query .="password = '{$password}', ";
    $query .="role= '{$role}' ";
    $query .= "WHERE id = {$user_id} ";
    $res = mysqli_query($connection,$query);
    queryResult($res);
    header("Location: users.php");

}
?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="firstname">First Name</label>
        <input type="text" class="form-control" name="firstname" value="<?php echo $user_firstname?>">
    </div>
    <div class="form-group">
        <label for="lastname">Last Name</label>
        <input type="text" class="form-control" name="lastname" value="<?php echo $user_lastname?>">
    </div>

    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username" value="<?php echo $username?>">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" name="email" value="<?php echo $user_email?>">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" name="password">
    </div>
    <div class="form-group">
        <label for="role">Role</label>
        <select id="role" name="role">
            <?php
            echo "<option selected value='{$user_role}'>{$user_role}</option>";

            if ($user_role=="Admin") {
                echo "<option value='Subscriber'>Subscriber</option>";

            }
            else{
                echo "<option value='Admin'>Admin</option>";

            }
            ?>
        </select>
    </div>




    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_user" value="Update User">
    </div>





</form>
