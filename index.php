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
                <!-- Pagination Code -->
                <?php
                $per_page = 3;
                if (isset($_GET['p'])){
                    $p = $_GET['p'];
                }
                else{
                    $p = 1;
                }
                if ($p ==1){
                    $page_1=0;
                } else{
                    $page_1 = ($p * $per_page) -$per_page;
                }


                if (is_admin()) {
                    $query_count = "SELECT * FROM posts";
                } else {
                    $query_count = "SELECT * FROM posts WHERE status='Published'";
                }
                $find = mysqli_query($connection,$query_count);
                $count = mysqli_num_rows($find);
                $count = ceil($count/$per_page);

                    $query= $query_count ." LIMIT {$page_1},$per_page ";
                    $select_posts = mysqli_query($connection,$query);
                    if (mysqli_num_rows($select_posts) == 0){
                        echo "<h1 class='text-center'>No posts available.</h1>";
                    }
                    while ($row = mysqli_fetch_assoc($select_posts)){
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_date = date('F d, Y',strtotime($row['date']));
                        $post_image = $row['image'];
                        $post_author = $row['author'];
                        $post_content =substr($row['content'],0,100);
                        echo <<<EOT
                                    <!-- Blog Post -->
                                    <h2>
                                        <a href="/cms/post/{$post_id}">{$post_title}</a>
                                    </h2>
                                    <p class="lead">
                                        by <a href="/cms/author_posts/{$post_author}">{$post_author}</a>
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
        <div class="text-center">
        <ul class="pagination">
            <?php
                for ($i=1; $i <=$count; $i++){
                    if ($i == $p) {
                        echo "<li class='active'><a href=\"index.php?p={$i}\">{$i}</a></li>";
                    }
                    else{
                        echo "<li><a href=\"index.php?p={$i}\">{$i}</a></li>";

                    }
                    }
            ?>
        </ul>
        </div>
        <?php include "includes/footer.php" ?>

