<?php  include "includes/header.php"; ?>



<!-- Navigation -->

<?php include "includes/nav.php"?>


<!-- Page Content -->
<div class="container">

    <section id="login">
        <div class="container">
            <?php
            if (isset($_POST['submit'])) {
                $email = $_POST['email'];
                $subject = $_POST['subject'];
                $message = $_POST['message'];
                if (!empty($subject) && !empty($message) && !empty($email)){
                    $to = 'shendabadihosein@gmail.com';
                    $header = "From: " .$email;
                    mail($to,$subject,$message,$header);
                }
                else{
                    echo "<h3 class='alert alert-danger'>All fields are required.</h3>";

                }

            }
            ?>
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h2 class="text-center">Contact Us</h2>
                        <form role="form" action="" method="post" id="login-form" autocomplete="off" style="margin-top: 2rem">
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email ">
                            </div>
                            <div class="form-group">
                                <label for="subject" class="sr-only">Subject</label>
                                <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject">
                            </div>
                            <div class="form-group">
                                <label for="message" class="sr-only">Message</label>
                                <textarea name="message" id="message" class="form-control" placeholder="Your Message"></textarea>
                            </div>

                            <input type="submit" name="submit" id="btn-login" class="btn btn-primary btn-lg btn-block" value="Submit">
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