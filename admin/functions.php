<?php

function usersOnline()
{
    if (isset($_GET['online'])) {
        global $connection;
        if (!$connection){
            session_start();
            include "../includes/db.php";

            $session = session_id();
            $time = time();
            $time_to_check = 5;
            $time_out = $time - $time_to_check;
            $query = "SELECT * FROM users_online WHERE session = '$session'";
            $r = mysqli_query($connection, $query);
            $count = mysqli_num_rows($r);
            if ($count == 0) {

                mysqli_query($connection, "INSERT INTO users_online (session, time) VALUES ('$session','$time')");
            } else {
                mysqli_query($connection, "UPDATE users_online SET time= '$time' WHERE session= '$session'");

            }
            $users_online = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out' ");
            $count_user = mysqli_num_rows($users_online);
            echo $count_user;
        }
    }
}
usersOnline();
function queryResult($result){
    global $connection;
    if (!$result){
        die("Query Failed. ".mysqli_error($connection));
    }
}
function addCategory(){
    global $connection;
    if (isset($_POST['submit'])){
        $title = $_POST['title'];
    if (empty($title)){
        echo 'Cannot be empty <br>';
    }
    else {
        $query = "INSERT INTO categories (title) VALUE ('{$title}')";
        mysqli_query($connection,$query);
    }
    }
}

function findAllCategories(){
    global $connection;
    $query="SELECT * FROM categories";
    $items=mysqli_query($connection,$query);
    if (mysqli_num_rows($items)==0){
        echo "<h2 class=\"text-center\">No Categories Found.</h2>";
    }
    else{
        echo <<<EOT
                                <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Category Title</th>
                                </tr>
                                </thead>
                                <tbody>
                                EOT;
        while ($row = mysqli_fetch_assoc($items)){
            echo <<<EOT
                                    <tr>
                                        <td style="vertical-align: middle">
                                            {$row['id']}
                                        </td>
                                        <td style="vertical-align: middle">
                                            {$row['title']}
                                        </td>
                                        <td class="text-center" style="padding: 2rem">
                                           <a class="btn-danger text-center" style="padding: 1rem 2rem;" href="categories.php?delete={$row['id']}"> Delete </a>
                                        </td>
                                        <td class="text-center" style="padding: 2rem">
                                           <a class="btn-info text-center" style="padding: 1rem 2rem;" href="categories.php?edit={$row['id']}"> Edit </a>
                                        </td>
                                    </tr>
                                    EOT;}
        echo <<<EOT
                                    </tbody>
                                    </table>
                                    
                        EOT;}
}

function deleteCategory(){
    global $connection;
    if (isset($_GET['delete'])){
        if (isset($_SESSION['role'])) {
            if ($_SESSION['role']=='Admin'){
                $delete_id=$_GET['delete'];
                $query = "DELETE FROM categories WHERE id={$delete_id}";
                $log=mysqli_query($connection,$query);
                if (!$log){
                    die("Query Failed! ".mysqli_error($connection));
                }
                header("Location: categories.php");
            }
        }

    }
}

function recordCount($table){
    global $connection;
    $query = "SELECT * FROM " . $table;
    $select = mysqli_query($connection,$query);
    queryResult($select);
    $result = mysqli_num_rows($select);
    return $result;
}
function is_admin($username){
    global $connection;
    $query = "SELECT role FROM users WHERE username = '$username'";
    $res = mysqli_query($connection,$query);
    queryResult($res);
    $row = mysqli_fetch_assoc($res);
    if ($row['role'] == 'Admin'){
        return true;
    }
    else{
        return false;
    }
}

function username_exists($username){
    global $connection;
    $query = "SELECT username FROM users WHERE username = '$username'";
    $res = mysqli_query($connection,$query);
    queryResult($res);
    if (mysqli_num_rows($res) > 0){
        return true;
    }
    else{
        return false;
    }
}

function register_user($username, $password, $email){
        global $connection;
            if (!empty($username) && !empty($password) && !empty($email)){
                if (username_exists($username)){
                    echo "<h3 class='alert alert-danger'>User Exists.</h3>";
                }
                else if (strlen($password)<6){
                    echo "<h3 class='alert alert-danger'>Password must be longer than 6 characters.</h3>";
                }
                else {
                    $username = mysqli_real_escape_string($connection, $username);
                    $password = mysqli_real_escape_string($connection, $password);
                    $password = password_hash($password, PASSWORD_BCRYPT);
                    $email = mysqli_real_escape_string($connection, $email);
                    $q = "INSERT INTO users (username, password, email, role) VALUES ('{$username}', '{$password}', '{$email}', 'Subscriber')";
                    $res = mysqli_query($connection, $q);
                    echo "<h3 class='alert alert-success'>Your registration has been submitted.</h3>";

                }
            }
            else{
                echo "<h3 class='alert alert-danger'>All fields are required.</h3>";

            }


}


