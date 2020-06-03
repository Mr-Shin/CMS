<?php include "includes/header.php" ?>

<?php
    if (!is_admin($_SESSION['username'])){
        header('Location: /cms/admin');
    }
?>

<body>
<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/navigation.php" ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Users
                    </h1>

                    <?php
                    $source='';
                    if (isset($_GET['p'])){
                        $source = $_GET['p'];

                    }
                    switch ($source){
                        case 'add-user':
                            include "includes/add_user.php";
                            break;
                        case 'edit-user':
                            include "includes/edit_user.php";
                            break;
                        default:
                            include "includes/view_all_users.php";

                    }
                    ?>
                </div>
            </div>
        </div>

    </div>

</div>

<?php include "includes/footer.php";?>