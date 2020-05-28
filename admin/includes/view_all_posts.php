<div class="col-xs-12">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Id</th>
            <th>Author</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Image</th>
            <th>Comments</th>
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
                                        <td style="vertical-align: middle;">$post_id</td>
                                        <td style="vertical-align: middle;">$post_author</td>
                                        <td style="vertical-align: middle;">$post_title</td>
                                        <td style="vertical-align: middle;">
                                        EOT;
                                        $cat= "SELECT * from categories WHERE id= {$post_category}";
                                        $res = mysqli_query($connection,$cat);
                                        while ($cat_row = mysqli_fetch_assoc($res)){
                                            echo $cat_row['title'];
                                        }
                                        echo <<<EOT
                                        </td>
                                        <td style="vertical-align: middle;"> 
                                        EOT;
                                        if ($post_status==0){
                                            echo "Drafted";
                                        }
                                        else{
                                            echo "Published";
                                        }
                                        echo <<<EOT
                                    </td>
                                        <td style="vertical-align: middle"><img width="150px" src="../images/{$post_image}" alt=""></td>
                                        <td style="vertical-align: middle">333</td>
                                        <td style="vertical-align: middle">{$post_date}</td>
                                        <td style="vertical-align: middle"><a class="btn btn-info" href="posts.php?p=edit-post&id=$post_id">Edit</a></td>
                                        <td style="vertical-align: middle"><a class="btn btn-danger" href="posts.php?del=$post_id">Delete</a></td>
                                        </tr>
                                    EOT;


}
?>

                            </tbody>
                        </table>
<?php
if (isset($_GET['del'])){
    $id = $_GET['del'];
    $query = "DELETE FROM posts WHERE id={$id}";
    $deletePost = mysqli_query($connection,$query);
    queryResult($deletePost);
    header("Location: posts.php");

}
?>
                    </div>