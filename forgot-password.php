<?php use PHPMailer\PHPMailer\PHPMailer;?>
<?php use PHPMailer\PHPMailer\Exception;?>
<?php use PHPMailer\PHPMailer\SMTP;?>
<?php  include "includes/header.php"; ?>
<?php  include "admin/functions.php"; ?>


<?php
    require './vendor/autoload.php';

    if (isset($_POST['recover-submit'])){
        $email = $_POST['email'];
        $length = 50;
        $token = bin2hex(openssl_random_pseudo_bytes($length));
        if (email_exists($email)){
            if ($stmt = mysqli_prepare($connection, "UPDATE users SET token='{$token}' WHERE email=?")) {
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);


                /*
                 Configure PHP Mailer
                 */
                $mail = new PHPMailer();
                $mail->isSMTP();
                $mail->Host       = Config::SMTP_HOST;
                $mail->SMTPAuth   = true;
                $mail->Username   = Config::SMTP_USER;
                $mail->Password   = Config::SMTP_PASSWORD;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = Config::SMTP_PORT;
                $mail->isHTML(true);
                $mail->setFrom('support@cms.com', 'Admin');
                $mail->addAddress($email);
                $mail->Subject='Reset Password';
                $mail->Body = '<p>Please click to reset your password.
                <a href="http://localhost:1180/cms/reset.php?email='.$email.'&token='.$token.'">Reset Password</a>
                </p>';
                if ($mail->send()){
                    $status =  "Email sent, Check your email.";
                }else{
                    $status = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }

            }else{
                $status = "Something's Wrong.";
            }
        }
        else{
            $status = "This email does not exist.";
        }
    }
?>

<!-- Navigation -->
<?php  include "includes/nav.php"; ?>

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
                            <h2 class="text-center">Forgot Password?</h2>
                            <p>You can reset your password here.</p>
                            <div class="panel-body">




                                <form id="register-form" role="form" class="form" method="post">

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                            <input id="email" name="email" placeholder="email address" class="form-control"  type="email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                    </div>

                                    <input type="hidden" class="hide" name="token" id="token" value="">
                                </form>
                                <?php
                                if (isset($status)){
                                    echo "<h4 class=\"alert alert-info\"> {$status}</h4>";

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

