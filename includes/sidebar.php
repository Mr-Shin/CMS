<div class="col-md-4">

    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="search.php" method="post">
        <div class="input-group">
            <input name="search" type="text" class="form-control">
            <span class="input-group-btn">
                            <button name="submit" class="btn btn-default" type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>

        </div>
        </form>
        <!-- /.input-group -->
    </div>
    <!-- Blog Search Well -->

    <div class="well">
        <?php
            if (isset($_SESSION['wrong'])){
                $m = $_SESSION['wrong'];
                echo "<h5 class='alert alert-danger'>{$m}</h5>";
                unset($_SESSION['wrong']);
            }
        ?>
        <?php if (isset($_SESSION['role'])): ?>
        <h4> Logged in as <?php echo $_SESSION['username']?></h4>
            <a href="includes/logout.php" class="btn btn-primary">Logout</a>
        <?php else: ?>

        <h4>Login</h4>
        <form action="includes/login.php" method="post">
            <div class="form-group">
                <input name="username" type="text" class="form-control" placeholder="Username">
            </div>
            <div class="form-group">
                <input name="password" type="password" class="form-control" placeholder="Password">
            </div>
            <button class="btn btn-primary" name="login" type="submit">
                Login
            </button>
        </form>
        <!-- /.input-group -->
    <?php endif; ?>
    </div>
    <!-- Blog Categories Well -->
    <div class="well">
        <?php
        $query="SELECT * FROM categories";
        $items=mysqli_query($connection,$query);
        ?>
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                    <?php
                    while ($row = mysqli_fetch_assoc($items)){
                        echo "<li> <a href=\"category.php?id={$row['id']}\">{$row['title']}</a></li>";
                    }
                    ?>
                </ul>
            </div>

        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
    <div class="well">
        <h4>Side Widget Well</h4>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.</p>
    </div>

</div>