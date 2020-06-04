 <?php  include "includes/header.php"; ?>
<?php include "admin/functions.php";?>
 <?php
 if (isset($_SESSION['username'])){
     header('Location: /cms/admin');
     exit;
 }
 ?>
    <!-- Navigation -->

 <?php include "includes/nav.php"?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">

        <?php
        if (isset($_POST['register'])) {
            $username =trim($_POST['username']);
            $email = trim($_POST['email']);
            register_user($username, trim($_POST['password']),$email);
        }?>
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h2 class="text-center">Register</h2>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off" style="margin-top: 2rem">
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username"
                                   value="<?php echo isset($username) ? $username : '' ?>">
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com"
                                   value="<?php echo isset($email) ? $email : '' ?>">
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
        <?php include "includes/footer.php" ?>
