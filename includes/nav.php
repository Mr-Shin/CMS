<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/cms">CMS</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php
                    $query="SELECT * FROM categories";
                    $items=mysqli_query($connection,$query);
                    while ($row = mysqli_fetch_assoc($items)){
                        $category_class = '';
                        $register_class = '';
                        $contact_class = '';
                        $pageName =basename($_SERVER['PHP_SELF']);
                        if (isset($_GET['id']) && $_GET['id']==$row['id']){
                            $category_class= 'active';
                        }
                        else if ($pageName == 'registration.php'){
                            $register_class= 'active';
                        }
                        else if ($pageName == 'contact.php'){
                            $contact_class= 'active';
                        }
                        echo "<li class='{$category_class}'> <a href=\"/cms/category/{$row['id']}\">{$row['title']}</a></li>";
                    }
                ?>
                <li><a href="/cms/admin">Admin</a></li>
                <li class='<?php echo $register_class ?>'><a href="/cms/registration">Register</a></li>
                <li class='<?php echo $contact_class ?>'><a href="/cms/contact">Contact Us</a></li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
