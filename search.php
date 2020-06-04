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
            if(isset($_POST['submit'])){
                $search = $_POST['search'];
                $query = "SELECT * FROM posts WHERE post_title LIKE '%$search%' AND status='Published'";
                $search_query = mysqli_query($connection,$query);
                if (mysqli_num_rows($search_query)>0) {
                    while ($row = mysqli_fetch_assoc($search_query)) {
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
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
                    <a href="/cms/post/{$post_id}">{$post_title}</a>
                </h2>
                <p class="lead">
                    by <a href="/cms/author_posts/{$post_author}">{$post_author}</a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on {$post_date}</p>
                <hr>
                <img class="img-responsive" src="{$post_image}" alt="">
                <hr>
                <p>{$post_content}</p>
                <a class="btn btn-primary" href="/cms/post/{$post_id}">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>
EOT;

            }
                    }
                else{
                    echo '<h3>No Result.</h3>';
                }
            }
            ?>


        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php" ?>

    </div>
    <!-- /.row -->

    <hr>

    <?php include "includes/footer.php" ?>
