<?php
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $query = "SELECT title from categories WHERE id={$id}";
    $found_item=mysqli_query($connection,$query);

    echo <<<EOT
                                            <form action="" method="post">
                                            <div class="form-group">
                                            EOT;


    echo "<label for=\"title\">Edit Category</label>";

    while ($row = mysqli_fetch_assoc($found_item)){
        echo  "<input class='form-control' type='text' name='title' value='{$row['title']}'>";
    }
    echo <<<EOT
                                        </div>
                                    <div class="form-group">
                                        <input class="btn btn-primary" type="submit" name="update" value="Update Category">
                                    </div>
                                </form>
                                EOT;
}
if (isset($_POST['update'])) {
    $title = $_POST['title'];
    if (empty($title)) {
        echo 'Cannot be empty <br>';
    } else {
        $stmt = mysqli_prepare($connection,"UPDATE categories SET title=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, 'si', $title,$id);
        mysqli_stmt_execute($stmt);
        if (!$stmt){
            die("Query Failed! ".mysqli_error($connection));
        }
        header("Location: categories.php");

    }
}

