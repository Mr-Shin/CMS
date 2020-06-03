<div class="col-xs-12">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Id</th>
            <th>Author</th>
            <th>Comment</th>
            <th>Email</th>
            <th>Status</th>
            <th>In Response to</th>
            <th>Date</th>
        </tr>

        </thead>
        <tbody>
<?php
$query = "SELECT * FROM comments";
$select_comments = mysqli_query($connection, $query);
while ($row = mysqli_fetch_assoc($select_comments)) {
    $comment_id = $row['id'];
    $comment_post_id = $row['post_id'];
    $comment_author = $row['author'];
    $comment_date = date('F d, Y', strtotime($row['date']));
    $comment_content = $row['content'];
    $comment_status = $row['status'];
    $comment_email = $row['email'];
    echo <<<EOT
        <tr>
        <td style="vertical-align: middle;">$comment_id</td>
        <td style="vertical-align: middle;">$comment_author</td>
        <td style="vertical-align: middle">$comment_content</td>
        <td style="vertical-align: middle">$comment_email</td>
        <td style="vertical-align: middle">$comment_status</td>
        <td style="vertical-align: middle">
        EOT;
        $q = "SELECT * from posts WHERE post_id={$comment_post_id}";
        $res = mysqli_query($connection,$q);
        while ($row = mysqli_fetch_assoc($res)){
            echo "<a href=\"../post.php?id={$row['post_id']}\">{$row['title']}</a>";
        }
                                         echo <<<EOT
                                        </td>
                                        <td style="vertical-align: middle">$comment_date</td>
        EOT;
                                        if ($comment_status=="Approved"){
                                            $comment_status = "Unapprove";
                                        }
                                        else{
                                            $comment_status = "Approve";
                                        }
                                        echo <<<EOT
                                        <td style="vertical-align: middle"><a class="btn btn-success" href="comments.php?id=$comment_id&status=$comment_status">
                                               {$comment_status}    
                                        </a>
                                        </td>
                                        <td style="vertical-align: middle"><a class="btn btn-danger" href="comments.php?del=$comment_id">Delete</a></td>
                                        </tr>
                                    EOT;


}
?>

<?php

if (isset($_GET['status'])){
    $id = $_GET['id'];
    $status = $_GET['status'];
    $q = "UPDATE comments SET status='{$status}d' WHERE id = {$id}";
    $res = mysqli_query($connection, $q);
    queryResult($res);
    header("Location: comments.php");

}

if (isset($_GET['del'])){
    if (isset($_SESSION['role'])) {
        if ($_SESSION['role']=='Admin'){
            $id = $_GET['del'];
            $query = "DELETE FROM comments WHERE id={$id}";
            $deleteComment = mysqli_query($connection,$query);
            queryResult($deleteComment);
            header("Location: comments.php");
        }
    }


}
?>
                    </div>