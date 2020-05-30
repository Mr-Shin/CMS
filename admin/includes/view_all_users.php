<div class="col-xs-12">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
        </tr>

        </thead>
        <tbody>
<?php
$query = "SELECT * FROM users";
$select_users = mysqli_query($connection, $query);
while ($row = mysqli_fetch_assoc($select_users)) {
    $user_id = $row['id'];
    $user_name = "{$row['firstname']} {$row['lastname']}";
    $username = $row['username'];
    $password = $row['password'];
    $user_email = $row['email'];
    $user_image = $row['image'];
    $user_role = $row['role'];
    echo <<<EOT
        <tr>
            <td style="vertical-align: middle;">$user_id</td>
            <td style="vertical-align: middle;">$user_name</td>
            <td style="vertical-align: middle">$username</td>
            <td style="vertical-align: middle">$user_email</td>
            <td style="vertical-align: middle">$user_role</td>
        EOT;
                                        if ($user_role=="Admin"){
                                            $user_role = "Subscriber";
                                        }
                                        else{
                                            $user_role = "Admin";
                                        }
                                        echo <<<EOT
                                        <td style="vertical-align: middle"><a class="btn btn-success" href="users.php?id=$user_id&role=$user_role">
                                            Make the user 
                                        EOT;
                                                  echo strtolower($user_role);
                                        echo <<<EOT
                                            </a>
                                        </td>
            <td style="vertical-align: middle"><a class="btn btn-info" href="users.php?p=edit-user&id=$user_id">Edit</a></td>
            <td style="vertical-align: middle"><a class="btn btn-danger" href="users.php?del=$user_id">Delete</a></td>
        </tr>
    EOT;

}
?>

<?php
if (isset($_GET['role'])){
    $id = $_GET['id'];
    $role = $_GET['role'];
    $q = "UPDATE users SET role='{$role}' WHERE id = {$id}";
    $res = mysqli_query($connection, $q);
    queryResult($res);
    header("Location: users.php");

}
if (isset($_GET['del'])){
    $id = $_GET['del'];
    $query = "DELETE FROM users WHERE id={$id}";
    $deleteUser = mysqli_query($connection,$query);
    queryResult($deleteUser);
    header("Location: users.php");

}
?>
</tbody>
</table>
</div>