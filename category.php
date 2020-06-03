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
            if(isset($_GET['id'])) {
                if (isset($_SESSION['role']) && $_SESSION['role'] == "Admin") {
                    $query = "SELECT * FROM posts WHERE category_id={$_GET['id']}";
                } else {
                    $query = "SELECT * FROM posts WHERE category_id={$_GET['id']} AND status='Published'";

                }
                $select_posts = mysqli_query($connection, $query);
                if (mysqli_num_rows($select_posts) == 0) {
                    echo "<h1 class='text-center'>No published posts available.</h1>";
                } else {
                    while ($row = mysqli_fetch_assoc($select_posts)) {
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_date = date('F d, Y', strtotime($row['date']));
                        $post_image = $row['image'];
                        $post_author = $row['author'];
                        $post_content = substr($row['content'], 0, 100);
                        echo <<<EOT
  <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <!-- First Blog Post -->
                <h2>
                    <a href="/cms/post/{$post_id}">{$post_title}</a>
                </h2>
                <p class="lead">
                    by <a href="/cms/author_posts/{$post_author}">{$post_author}</a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on {$post_date}</p>
                <hr>
                <img class="img-responsive" src="images/{$post_image}" alt="">
                <hr>
                <p>{$post_content}</p>
                <a class="btn btn-primary" href="/cms/post/{$post_id}">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>
EOT;

                    }
                }
            }
            else{
                header("Location: index.php");
            }
            ?>



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
