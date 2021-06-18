<?php include 'header.php';
//include 'admin/classes.php';
?>
    <div id="main-content">
      <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                  <?php
                  //include "config.php";
                  if(isset($_GET['aid'])){
                    $type="author";
                    $post=new posts();
                    $result=$post->showPosts_frontend($type);
                  ?>
                    <h2 class="page-heading"><?php  echo $result[0]['username']; ?></h2>
                  <?php
                    foreach($result as $row){
                  ?>
                    <div class="post-content">
                        <div class="row">
                            <div class="col-md-4">
                                <a class="post-img" href="single.php?id=<?php echo $row['post_id'];?>"><img src="admin/upload/<?php echo $row['post_img'];?>" alt=""/></a>
                            </div>
                            <div class="col-md-8">
                                <div class="inner-content clearfix">
                                    <h3><a href="single.php?id=<?php echo $row['post_id'];?>"><?php echo $row['title'];?></a></h3>
                                    <div class="post-information">
                                        <span>
                                            <i class="fa fa-tags" aria-hidden="true"></i>
                                            <a href='category.php?cid=<?php echo $row['category'];?>'><?php echo $row['category_name'];?></a>
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
                                    <p class="description">
                                        <?php echo substr($row['description'],0,150) . "...";?>
                                    </p>
                                    <a class='read-more pull-right' href="single.php?id=<?php echo $row['post_id'];?>">read more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        }
}

                        $db->pagination();


                      ?>
                </div><!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
      </div>
    </div>
<?php include 'footer.php'; ?>
