<?php  include "includes/db.php"; ?>
 <?php  include "includes/header.php"; ?>



    <!-- Navigation -->

    <?php include "includes/nav.php"?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <?php
        if (isset($_POST['register'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            if (!empty($username) && !empty($password) && !empty($email)){
                if (strlen($password)<6){
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
        ?>
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h2 class="text-center">Register</h2>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off" style="margin-top: 2rem">
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                        </div>
                
                        <input type="submit" name="register" id="btn-login" class="btn btn-primary btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Your Website 2014</p>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </footer>
    </div>
        <!-- jQuery -->
        <script src="js/jquery.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>

        </body>

        </html>