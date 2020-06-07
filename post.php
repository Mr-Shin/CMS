<?php include "includes/header.php"?>
<?php include "admin/functions.php"?>
<body>

<!-- Navigation -->
<?php include "includes/nav.php"?>


<!-- Like Related Code -->
<?php
if (isLoggedIn()) {
    $user_id = getUserId($_SESSION['username']);
    $post_id = $_GET['id'];

    $like_status = likeOrUnlike($user_id, $post_id);

    if (isset($_POST['liked'])) {

        // Fetching The Post
        $post_q = "SELECT * FROM posts WHERE post_id ={$post_id}";
        $p_res = mysqli_query($connection, $post_q);
        $row = mysqli_fetch_array($p_res);
        $likes = $row['likes'];

        //Update Post With Likes
        $update_q = "UPDATE posts SET likes={$likes} + 1 WHERE post_id={$post_id}";
        mysqli_query($connection, $update_q);

        //Create Likes For Post
        $insert_q = "INSERT INTO likes (user_id,post_id) VALUES ({$user_id},{$post_id})";
        mysqli_query($connection, $insert_q);

    }
    if (isset($_POST['unliked'])) {

        // Fetching The Post
        $post_q = "SELECT * FROM posts WHERE post_id ={$post_id}";
        $p_res = mysqli_query($connection, $post_q);
        $row = mysqli_fetch_array($p_res);
        $likes = $row['likes'];

        //Update Post With Likes
        $update_q = "UPDATE posts SET likes={$likes} - 1 WHERE post_id={$post_id}";
        mysqli_query($connection, $update_q);

        //Delete Like
        $delete_q = "DELETE FROM likes WHERE post_id={$post_id} AND user_id={$user_id}";
        mysqli_query($connection, $delete_q);

    }
}

?>

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

                if (is_admin()) {
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
                    if (is_admin()) {
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
    <div class="row">
        <div class="col-xs-12 text-center">
            <?php if(isLoggedIn()):?>
                <p><a class="likefn <?php echo  strtolower($like_status)?>" href="javascript:void(0)"><span class="glyphicon glyphicon-thumbs-<?php echo $like_status=='Like' ? 'up' : 'down'?>"></span> <span class="likefn-text"><?php echo $like_status;?></span></a></p>
            <?php else:?>
                <p>You need to <a href="/cms/login"> login</a> to be able to like</p>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 text-center">
            <p>Likes: <span class="like-number"><?php echo getPostLikes($_GET['id']);?></span></p>
        </div>
    </div>
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
                <input type="email" class="form-control" name="comment_email">
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
<script src="/cms/js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="/cms/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        let post_id =<?php echo $post_id; ?>;
        let user_id =<?php echo $user_id; ?>;
        let number =parseInt($('.like-number').text());
        $('.likefn').click(function () {
            if ($(this).hasClass('like')){
                $.ajax({
                    url: "/cms/post.php?id=" + post_id,
                    type: "post",
                    data:{
                        'liked': 1,
                        'post_id':post_id,
                        'user_id': user_id,
                    }
                });
                $(this).addClass('unlike').removeClass('like');
                $(".likefn-text").text('Unlike');
                $('.glyphicon').addClass('glyphicon-thumbs-down').removeClass('glyphicon-thumbs-up');
                number+=1;
            }
            else{
                $.ajax({
                    url: "/cms/post.php?id=" + post_id,
                    type: "post",
                    data:{
                        'unliked': 1,
                        'post_id':post_id,
                        'user_id': user_id,
                    },

                })
                $(this).addClass('like').removeClass('unlike');
                $(".likefn-text").text('Like');
                $('.glyphicon').addClass('glyphicon-thumbs-up').removeClass('glyphicon-thumbs-down');
                number-=1;
            }
            $('.like-number').text(number);


        });

    })
</script>

</body>

</html>
