<?php include "includes/db.php"?>
<?php include "includes/header.php"?>
<body>

    <!-- Navigation -->
        <?php include "includes/nav.php"?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <?php
                    $query= "SELECT * FROM posts";
                    $select_posts = mysqli_query($connection,$query);
                    while ($row = mysqli_fetch_assoc($select_posts)){
                        $post_title = $row['title'];
                        $post_date = date('F d, Y',strtotime($row['date']));
                        $post_image = $row['image'];
                        $post_author = $row['author'];
                        $post_content = $row['content'];
                        echo <<<EOT
  <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <!-- First Blog Post -->
                <h2>
                    <a href="#">{$post_title}</a>
                </h2>
                <p class="lead">
                    by <a href="index.php">{$post_author}</a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on {$post_date}</p>
                <hr>
                <img class="img-responsive" src="{$post_image}" alt="">
                <hr>
                <p>{$post_content}</p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>
EOT;

                    }
                ?>


                <!-- Pager -->
                <ul class="pager">
                    <li class="previous">
                        <a href="#">&larr; Older</a>
                    </li>
                    <li class="next">
                        <a href="#">Newer &rarr;</a>
                    </li>
                </ul>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php" ?>

        </div>
        <!-- /.row -->

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
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
