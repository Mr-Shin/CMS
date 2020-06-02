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



