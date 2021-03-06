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
            $author = $_GET['author'];
            if (is_admin()) {
                $query = "SELECT * FROM posts WHERE author='{$author}'";
            } else {
                $query = "SELECT * FROM posts WHERE author='{$author}' AND status='Published'";
            }
           $select_posts = mysqli_query($connection,$query);
            if (mysqli_num_rows($select_posts) == 0){
                echo "<h1 class='text-center'>No published posts available.</h1>";
            }
            while ($row = mysqli_fetch_assoc($select_posts)){
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                $post_date = date('F d, Y',strtotime($row['date']));
                $post_image = $row['image'];
                $post_author = $row['author'];
                $post_content =substr($row['content'],0,100);
                echo <<<EOT
                <h2>
                    <a href="/cms/post/{$post_id}">{$post_title}</a>
                </h2>
                <p class="lead">
                    by {$post_author}
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on {$post_date}</p>
                <hr>
                <img class="img-responsive" src="/cms/images/{$post_image}" alt="">
                <hr>
                <p>{$post_content}</p>
                <a class="btn btn-primary" href="/cms/post/{$post_id}">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>
EOT;

            }
            ?>


        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php" ?>

    </div>
    <!-- /.row -->

    <hr>
    <?php include "includes/footer.php"?>