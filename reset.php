<?php  include "includes/header.php"; ?>
<?php  include "admin/functions.php"; ?>
<?php
    if (!isset($_GET['email']) || !isset($_GET['token'])){
        http_response_code(404);
        echo '<h1 class="text-center">This page was not found :(</h1>';
        exit;
    }
    $token=$_GET['token'];
    $email=$_GET['email'];
    if ($stmt = mysqli_prepare($connection,'SELECT username, email FROM users WHERE token=?')) {
        mysqli_stmt_bind_param($stmt, 's', $token);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $username, $email);
        mysqli_stmt_store_result($stmt);
        $count = mysqli_stmt_num_rows($stmt);
        mysqli_stmt_fetch($stmt);
        $user = $username;

        mysqli_stmt_close($stmt);
        if ($count == 0) {
            http_response_code(404);
            echo "<h1 class=\"text-center\">This link is expired.</h1>";
            exit;

        }
        if (isset($_POST['resetPassword'])) {
            if (isset($_POST['password']) && isset($_POST['confirmPassword'])) {
                $pass = $_POST['password'];
                if ($pass == $_POST['confirmPassword']) {
                    $password = password_hash($pass, PASSWORD_BCRYPT);
                    $stmt = mysqli_prepare($connection, "UPDATE users SET token='',password=? WHERE email = ?");
                    mysqli_stmt_bind_param($stmt, 'ss', $password, $email);
                    mysqli_stmt_execute($stmt);
                    if (mysqli_stmt_affected_rows($stmt) > 0) {
                        $m = "Your password is changed.";
                        login_user($user,$pass);
                    } else {
                        $m = "Something is wrong.";
                    }

                } else {
                    $m = "Two fields doesn't match";
                }
            }

        }
    }
?>

<!-- Navigation -->
<?php include "includes/nav.php"?>

<!-- Page Content -->
<div class="container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">

                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Reset Password</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">

                                    <form id="reset-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input required id="password" name="password" placeholder="New Password" class="form-control"  type="password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input required id="ConfirmPassword" name="confirmPassword" placeholder="Confirm Password" class="form-control"  type="password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="resetPassword" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>
                                    </form>
                                    <?php
                                    if (isset($m)){
                                    echo "<h4 class=\"alert alert-info\"> {$m}</h4>";

                                    }
                                    ?>
                                </div><!-- Body-->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->

