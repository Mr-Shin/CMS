<?php
if (isset($_POST['create_post'])){
    $title = $_POST['title'];
    $author = $_SESSION['firstname'] . " " . $_SESSION['lastname'];
    $category = $_POST['category_id'];
    $status = $_POST['status'];
    $image = $_FILES['image']['name'];
    $tmp_image = $_FILES['image']['tmp_name'];
    $content = $_POST['content'];
    $date = date("Y-m-d h:i:sa");


    move_uploaded_file($tmp_image,"../images/$image");

    $query = "INSERT INTO posts (post_title, author, category_id, status, image, content, date)
              VALUES('{$title}','{$author}','{$category}','{$status}','{$image}','{$content}','{$date}')";
    $post=mysqli_query($connection,$query);
    queryResult($post);
    $id = mysqli_insert_id($connection);
    echo "<h3 class='alert alert-success'>Post Added successfully. <a href='../post.php?id={$id}'>View Post</a></h3>";

}
?>

<form action="" method="post" enctype="multipart/form-data">


    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title">
    </div>

    <div class="form-group">
        <label for="category">Category</label>
        <select name="category_id" id="">

            <?php

            $query = "SELECT * FROM categories";
            $select_categories = mysqli_query($connection,$query);

            queryResult($select_categories);


            while($row = mysqli_fetch_assoc($select_categories )) {
                $id = $row['id'];
                $title = $row['title'];


                echo "<option value='{$id}'>{$title}</option>";


            }

            ?>


        </select>

    </div>

    <div class="form-group">
        <label for="status">Status</label>
        <select id="status" name="status">
            <option value="Published">Published</option>
            <option value="Draft">Draft</option>
        </select>
    </div>



    <div class="form-group">
        <label for="image">Post Image</label>
        <input type="file" name="image">
    </div>


    <div class="form-group">
        <label for="content">Post Content</label>
        <textarea class="form-control" name="content" id="" cols="30" rows="10"></textarea>
    </div>



    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
    </div>





</form>
