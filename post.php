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
            if (isset($_SESSION['updated'])){
                echo "<h3 class='alert alert-success'>{$_SESSION['updated']}</h3>";
            }
            unset($_SESSION['updated']);
            if (isset($_GET['id'])) {
                $id = $_GET['id'];

                if (isset($_SESSION['role']) && $_SESSION['role'] == "Admin") {
                    $query = "SELECT * FROM posts WHERE post_id={$id}";
                } else {
                    $query = "SELECT * FROM posts WHERE post_id={$id} AND status='Published'";

                }
                $select_posts = mysqli_query($connection, $query);
                if (mysqli_num_rows($select_posts)==0){

                    http_response_code(404);
                    echo '<h1 class="text-center">This page was not found :(</h1>';
                    exit;
                }
                while ($row = mysqli_fetch_assoc($select_posts)) {
                    $post_title = $row['post_title'];
                    $post_date = date('F d, Y', strtotime($row['date']));
                    $post_image = $row['image'];
                    $post_author = $row['author'];
                    $post_content = $row['content'];
                    echo <<<EOT
                    <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                    EOT;
                    if (isset($_SESSION['role'])) {
                        echo "<a href='/cms/admin/posts.php?p=edit-post&id={$id}' class=\"btn btn-primary pull-right\">Edit Post</a>";
                    }
                    echo <<<EOT

                </h1>
                <!-- First Blog Post -->
                <h2>
                    {$post_title}
                </h2>
                <p class="lead">
                    by <a href="/cms/author_posts/{$post_author}">{$post_author}</a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on {$post_date}</p>
                <hr>
                <img class="img-responsive" src="/cms/images/{$post_image}" alt="">
                <hr>
                <p>{$post_content}</p>

                <hr>
EOT;
                }
            }

            ?>


        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php" ?>

    </div>
    <!-- /.row -->
    <!-- Blog Comments -->
    <?php
        if (isset($_POST['create_comment'])){
            $id= $_GET['id'];
            $comment_author = $_POST['comment_author'];
            $comment_email = $_POST['comment_email'];
            $comment_content = $_POST['comment_content'];
            $comment_date = date("Y-m-d h:i:sa");
            if (!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
                $query = "INSERT INTO comments (post_id, author, email, content, status, date)
                  VALUES ({$id},'{$comment_author}','{$comment_email}','{$comment_content}', 'Unapproved', '{$comment_date}')";
                $res = mysqli_query($connection, $query);
                queryResult($res);
                echo "<h3 class='alert alert-success'>Comment added successfully. Wait for approval...</h3>";
            }
            else{
                echo "<h3 class='alert alert-danger'>All fields are required.</h3>";
            }
        }

    ?>
    <!-- Comments Form -->
    <div class="well">
        <h4>Leave a Comment:</h4>
        <form action="" method="post" role="form">
            <div class="form-group">
                <label for="comment_author">Author</label>
                <input type="text" class="form-control" name="comment_author">
            </div>
            <div class="form-group">
                <label for="comment_email">Email</label>
                <input type="text" class="form-control" name="comment_email">
            </div>
            <div class="form-group">
                <label for="comment_content">Comment</label>
                <textarea name="comment_content" class="form-control" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" name="create_comment">Submit</button>
        </form>
    </div>

    <hr>

    <!-- Posted Comments -->

    <!-- Comment -->
    <?php
        $post_id = $_GET['id'];
        $comments_query = "SELECT * from comments WHERE post_id = {$post_id} AND status ='Approved'";
        $result = mysqli_query($connection, $comments_query);
        while ($row = mysqli_fetch_assoc($result)){
            $comment_author = $row['author'];
            $comment_date = $row['date'];
            $comment_content = $row['content'];
            echo <<<EOT
    <div class="media">
        <a class="pull-left" href="#">
            <img class="media-object" src="http://placehold.it/64x64" alt="">
        </a>
        <div class="media-body">
            <h4 class="media-heading">{$comment_author}
                <small>{$comment_date}</small>
            </h4>
            {$comment_content}
        </div>
    </div>
    <hr>

EOT;
        }


    ?>

    <?php include "includes/footer.php" ?>
