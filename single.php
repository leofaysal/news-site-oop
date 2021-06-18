<?php include 'header.php';
include 'config.php';
//include 'admin/classes.php';
$type='single';
$post= new posts();
$result=$post->showPosts_frontend($type);
 ?>

    <div id="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                  <!-- post-container -->
                    <div class="post-container">
                        <?php  foreach($result as $row){ ?>
                        <div class="post-content single-post">
                            <h3><?php echo $row['title'];?></h3>
                            <div class="post-information">
                                <span>
                                    <i class="fa fa-tags" aria-hidden="true"></i>
                                    <a href='category.php?cid=<?php echo $row['category'];?>'><?php echo $row['category_name'];?></a>
                                </span>
                                </span>
                                <span>
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <a href='author.php?aid=<?php echo $row['author'];?>'><?php echo $row['username'];?></a>
                                </span>
                                <span>
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                  <?php echo $row['post_date'];?>
                                </span>
                            </div>
                          <img src="admin/upload/<?php echo $row['post_img'];?>" alt=""/>
                            <p class="description">
                              <?php echo $row['description'];?>
                            </p>
                        </div>
                        <?php
                            }

                          ?>
                    </div>

                    <!-- /post-container -->
                </div>
                <?php include 'sidebar.php'; ?>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>
