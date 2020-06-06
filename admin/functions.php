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
        $stmt = mysqli_prepare($connection,"INSERT INTO categories (title) VALUE (?)");
        mysqli_stmt_bind_param($stmt, 's',$title);
        mysqli_stmt_execute($stmt);
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
//-------- AUTHENTICATION HELPERS --------//
function isLoggedIn(){
    if (isset($_SESSION['username'])){
        return true;
    }
    else{
        return false;
    }
}
function is_admin($username){
    if (isLoggedIn()){
        global $connection;
        $query = "SELECT role FROM users WHERE username = '$username'";
        $res = mysqli_query($connection, $query);
        queryResult($res);
        $row = mysqli_fetch_assoc($res);
        if ($row['role'] == 'Admin') {
            return true;
        } else {
            return false;
        }
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

function login_user($user,$pass){
    global $connection;
    $user = mysqli_real_escape_string($connection,$user);
    $pass = mysqli_real_escape_string($connection,$pass);
    $q = "SELECT * FROM users WHERE username = '{$user}'";
    $res = mysqli_query($connection,$q);
    if (mysqli_num_rows($res)>0){
        while ($row = mysqli_fetch_assoc($res)){
            if (password_verify($pass,$row['password'])){
                $_SESSION['username'] = $row['username'];
                $_SESSION['firstname'] = $row['firstname'];
                $_SESSION['lastname'] = $row['lastname'];
                $_SESSION['role'] = $row['role'];
                header("Location: /cms/admin");

            }
            else{
                $_SESSION['wrong'] = "Wrong Password";
            }

        }
    }
    else{
        $_SESSION['wrong'] = "Wrong Username Or Password";
    }

}
function email_exists($email){
    global $connection;
    $stmt = mysqli_prepare($connection,"SELECT * FROM users WHERE email=?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $count = mysqli_stmt_num_rows($stmt);
    if ($count==0){
        return false;
    }
    else{
        return true;
    }
}
function getUserId($user){
    global $connection;
    $query = "SELECT id FROM users WHERE username = '{$user}'";
    $res = mysqli_query($connection,$query);
    queryResult($res);
    return mysqli_fetch_array($res)['id'];
}









function likeOrUnlike($user_id,$post_id){
    global $connection;
    $r =mysqli_query($connection,"SELECT * FROM likes WHERE post_id={$post_id} AND user_id={$user_id}");
    if (mysqli_num_rows($r)==0){
        $like_status = 'Like';
    }
    else{
        $like_status = 'Unlike';
    }
    return $like_status;
}
function getPostLikes($post_id){
    global $connection;
    $res = mysqli_query($connection,"SELECT likes FROM posts WHERE post_id={$post_id}");
    queryResult($res);
    return mysqli_fetch_array($res)['likes'];
}


