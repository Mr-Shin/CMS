<?php
if (isset($_POST['deleteBtn'])){
    foreach ($_POST['checkBox'] as $check){
        $query = "DELETE FROM posts WHERE id={$check}";
        $deletePosts = mysqli_query($connection,$query);
        queryResult($deletePosts);
        header("Location: posts.php");
    }
}

?>
<?php include "delete_modal.php"?>
<div class="col-xs-12">
    <form action="" method="post">
        <div id="deleteBulk" class="col-xs-12" style="margin-bottom:2rem;padding: 0">
            <button onclick="return confirm('Are you sure?')" type="submit" name="deleteBtn" id="deleteBtn" class="btn btn-danger" disabled>Delete</button>
        </div>
        <table class="table table-bordered">


            <thead>
        <tr>
            <th><input type="checkbox" id="checkAll"></th>
            <th>Id</th>
            <th>Author</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Image</th>
            <th>Date</th>
        </tr>

        </thead>
        <tbody>
<?php
$query = "SELECT * FROM posts";
$select_posts = mysqli_query($connection, $query);
while ($row = mysqli_fetch_assoc($select_posts)) {
    $post_id = $row['id'];
    $post_title = $row['title'];
    $post_date = date('F d, Y', strtotime($row['date']));
    $post_image = $row['image'];
    $post_author = $row['author'];
    $post_category = $row['category_id'];
    $post_content = $row['content'];
    $post_status = $row['status'];
    echo <<<EOT
                                        <tr>
                                        <td style="vertical-align: middle;"><input class="checkBoxes" type="checkbox" name="checkBox[]" value="{$post_id}"></td>
                                        <td style="vertical-align: middle;">$post_id</td>
                                        <td style="vertical-align: middle;">$post_author</td>
                                        <td style="vertical-align: middle;"><a href="../post.php?id={$post_id}">$post_title</a></td>
                                        <td style="vertical-align: middle;">
                                        EOT;
                                        $cat= "SELECT * from categories WHERE id= {$post_category}";
                                        $res = mysqli_query($connection,$cat);
                                        while ($cat_row = mysqli_fetch_assoc($res)){
                                            echo $cat_row['title'];
                                        }
                                        echo <<<EOT
                                        </td>
                                        <td style="vertical-align: middle;">{$post_status}</td>
                                        <td style="vertical-align: middle"><img width="150px" src="../images/{$post_image}" alt=""></td>
                                        <td style="vertical-align: middle">{$post_date}</td>
                                        <td style="vertical-align: middle"><a class="btn btn-info" href="posts.php?p=edit-post&id=$post_id">Edit</a></td>
                                        <td style="vertical-align: middle"><a data-id="{$post_id}" class="btn btn-danger delete_link" data-toggle="modal" data-target="#exampleModal">Delete</a></td>
                                        </tr>
                                    EOT;


}
?>

                            </tbody>
                        </table>
</form>
<?php
if (isset($_GET['del'])){
    if (isset($_SESSION['role'])) {
        if ($_SESSION['role']=='Admin'){

            $id = $_GET['del'];
            $query = "DELETE FROM posts WHERE id={$id}";
            $deletePost = mysqli_query($connection,$query);
            queryResult($deletePost);
            header("Location: posts.php");

        }
    }
}
?>
</div>