<?php include "includes/header.php" ?>

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
                        Posts
                    </h1>

                    <?php
                    $source='';
                    if (isset($_GET['p'])){
                        $source = $_GET['p'];

                    }
                    switch ($source){
                        case 'add-post':
                            include "includes/add_post.php";
                            break;
                        case 'edit-post':
                            include "includes/edit_post.php";
                            break;
                        default:
                            include "includes/view_all_posts.php";

                    }
                    ?>
                </div>
            </div>
        </div>

    </div>

</div>


<?php include "includes/footer.php";?>