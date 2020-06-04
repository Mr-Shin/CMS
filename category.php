<?php include "includes/header.php"?>
<?php include "admin/functions.php"?>
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
                if (isset($_SESSION['username']) && is_admin($_SESSION['username'])) {
                    $stmt1 =mysqli_prepare($connection,"SELECT post_id, post_title, author, date, image, content FROM posts WHERE category_id=?");
                } else {
                    $stmt2 =mysqli_prepare($connection,"SELECT post_id, post_title, author, image, date, content FROM posts WHERE category_id=? AND status=?");
                    $published = "Published";
                }
                if(isset($stmt1)){
                    mysqli_stmt_bind_param($stmt1,"i", $_GET['id']);
                    mysqli_stmt_execute($stmt1);
                    mysqli_stmt_bind_result($stmt1,$post_id,$post_title, $author, $date, $image, $content);
                    $stmt = $stmt1;
                }
                else{
                    mysqli_stmt_bind_param($stmt2,"is", $_GET['id'], $published);
                    mysqli_stmt_execute($stmt2);
                    mysqli_stmt_bind_result($stmt2,$post_id, $post_title, $author, $date, $image, $content);
                    $stmt = $stmt2;

                }
//                if (mysqli_stmt_num_rows($stmt) == 0) {
//                    echo "<h1 class='text-center'>No published posts available.</h1>";
//                }
                    while (mysqli_stmt_fetch($stmt)) {
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
                    by <a href="/cms/author_posts/{$author}">{$author}</a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on {$date}</p>
                <hr>
                <img class="img-responsive" src="/cms/images/{$image}" alt="">
                <hr>
                <p>{$content}</p>
                <a class="btn btn-primary" href="/cms/post/{$post_id}">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>
EOT;

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
    <?php include "includes/footer.php" ?>

