 <?php  include "includes/header.php"; ?>
<?php include "admin/functions.php";?>
 <?php
 if (isset($_SESSION['username'])){
     header('Location: /cms/admin');
     exit;
 }
 ?>


 <?php
    if (isset($_GET['lang'])){
        $_SESSION['lang'] = $_GET['lang'];
        include "includes/languages/" . $_SESSION['lang'].".php";
        if ($_SESSION['lang'] != $_GET['lang']){
            echo "<script type='text/javascript'>location.reload()</script>";
        }
    }
    else{
        include "includes/languages/en.php";

    }
 ?>
    <!-- Navigation -->

 <?php include "includes/nav.php"?>
    
 
    <!-- Page Content -->
    <div class="container">
        <form method="get" action="" id="lang_form">
            <div class="form-group">
                <label for="lang">Language</label>
                <select class="form-control" name="lang" id="lang" onchange="changeLang()">

                    <option value="en" <?php if (isset($_SESSION['lang']) && $_SESSION['lang']=='en'){echo "selected";} ?>>English</option>
                    <option value="fa" <?php if (isset($_SESSION['lang']) && $_SESSION['lang']=='fa'){echo "selected";} ?>>Farsi</option>
                </select>
            </div>
        </form>
<section id="login">
    <div class="container">

        <?php
        $query = "SELECT users.id, , ";
        $query .= "categories.id, categories.title FROM users LEFT JOIN categories ON users.id = likes.users_id";
        if (isset($_POST['register'])) {
            $username =trim($_POST['username']);
            $email = trim($_POST['email']);
            register_user($username, trim($_POST['password']),$email);
        }?>
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h2 class="text-center"><?php echo _REGISTER?></h2>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off" style="margin-top: 2rem">
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="<?php echo _USERNAME?>"
                                   value="<?php echo isset($username) ? $username : '' ?>">
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="<?php echo _EMAIL?>"
                                   value="<?php echo isset($email) ? $email : '' ?>">
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="<?php echo _PASSWORD?>">
                        </div>
                
                        <input type="submit" name="register" id="btn-login" class="btn btn-primary btn-lg btn-block" value="<?php echo _REGISTER?>">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>
        <!-- Footer -->
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
 <!-- /.container -->

 <!-- jQuery -->
 <script src="/cms/js/jquery.js"></script>

 <!-- Bootstrap Core JavaScript -->
 <script src="/cms/js/bootstrap.min.js"></script>
<script>
    function changeLang() {
        $('#lang_form').submit();
    }
</script>
 </body>

 </html>
