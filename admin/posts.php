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



<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>
<script>
    $(".checkBoxes").change(function(){
        if ($('.checkBoxes:checked').length > 0) {
            $('#deleteBtn').prop('disabled', false);
        }
        else{
                $('#deleteBtn').prop('disabled',true);

        }
    });
    $("#checkAll").change(function() {
        if(this.checked) {
            $('#deleteBtn').prop('disabled',false);
            $(".checkBoxes").prop('checked',true)
        }
        else if(!this.checked) {
            $('#deleteBtn').prop('disabled',true);
            $(".checkBoxes").prop('checked',false)
        }
    });

</script>
</body>

</html>