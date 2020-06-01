<?php include "includes/header.php"?>

<body>
<?php deleteCategory()?>
<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/navigation.php"?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Categories
                    </h1>

                        <div class="col-xs-6">
                            <form action="" method="post">
                                <div class="form-group">
                                    <?php addCategory() ?>
                                    <label for="title">Add Category</label>
                                    <input class="form-control" type="text" name="title">
                                </div>
                                <div class="form-group">
                                    <input class="btn btn-primary" type="submit" name="submit" value="Add Category">
                                </div>
                            </form>
                            <?php include "includes/update_categories.php"?>
                        </div>

                <div class="col-xs-6">
                    <?php findAllCategories()?>
                </div>
                </div>
            </div>
        </div>

    </div>

</div>

<?php include "includes/footer.php";?>