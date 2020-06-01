<?php
    $id = $_GET['id'];
    $query ="SELECT * FROM posts WHERE id={$id}";
    $res = mysqli_query($connection,$query);
    queryResult($res);
    while ($row = mysqli_fetch_assoc($res)){
        $post_id = $row['id'];
        $post_title = $row['title'];
        $post_date = date('F d, Y', strtotime($row['date']));
        $post_image = $row['image'];
        $post_category = $row['category_id'];
        $post_content = $row['content'];
        $post_status = $row['status'];
    }

    if (isset($_POST['update_post'])){
        $title = $_POST['title'];
        $category = $_POST['category_id'];
        $status = $_POST['status'];
        $image = $_FILES['image']['name'];
        $tmp_image = $_FILES['image']['tmp_name'];
        $content = $_POST['content'];
        $date = date("Y-m-d h:i:sa");
        move_uploaded_file($tmp_image,"../images/$image");

        if (empty($image)){
            $image = $post_image;
        }
        $query = "UPDATE posts SET ";
        $query .="title  = '{$title}', ";
        $query .="category_id = {$category}, ";
        $query .="date   =  '{$date}', ";
        $query .="status = '{$status}', ";
        $query .="content= '{$content}', ";
        $query .="image  = '{$image}' ";
        $query .= "WHERE id = {$post_id} ";
        $res = mysqli_query($connection,$query);
        queryResult($res);
        $_SESSION['updated'] = "Post Updated Successfully";

        header("Location: ../post.php?id={$id}");

    }
?>

<form action="" method="post" enctype="multipart/form-data">


    <div class="form-group">
        <label for="title">Post Title</label>
        <input value="<?php echo $post_title ?>" type="text" class="form-control" name="title">
    </div>

    <div class="form-group">
        <label for="category">Category</label>
        <select name="category_id" id="category_id">

            <?php

                        $query = "SELECT * FROM categories";
                        $select_categories = mysqli_query($connection,$query);

                        queryResult($select_categories);


                        while($row = mysqli_fetch_assoc($select_categories )) {
                            $id = $row['id'];
                            $title = $row['title'];

                            if ($id==$post_category) {
                                echo "<option selected value='{$id}'>{$title}</option>";
                            }
                            else{
                                echo "<option value='{$id}'>{$title}</option>";

                            }

                        }

            ?>


        </select>

    </div>

    <div class="form-group">
        <label for="status">Status</label>
        <select id="status" name="status">
            <?php
            echo "<option selected value='{$post_status}'>{$post_status}</option>";

            if ($post_status=="Published") {
                echo "<option value='Draft'>Draft</option>";

            }
            else{
                echo "<option value='Published'>Published</option>";

            }
            ?>

        </select>
    </div>



    <div class="form-group">
        <label for="image">Post Image</label>
        <input type="file" name="image">
        <img style="margin-top: 2rem" width="100px" src="../images/<?php echo $post_image?>" alt="">
    </div>


    <div class="form-group">
        <label for="content">Post Content</label>
        <textarea class="form-control" name="content" id="" cols="30" rows="10"><?php echo $post_content ?></textarea>
    </div>



    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_post" value="Update Post">
    </div>





</form>
