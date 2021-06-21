<?php include "header.php";

// if($_SESSION["user_role"]=='0'){
//
//
//   $post_id=$_GET['id'];
//   $sql2="SELECT author FROM post WHERE post_id={$post_id}";
//   $result2=mysqli_query($conn,$sql2) or die("Query Failed.");
//   $row2=mysqli_fetch_assoc($result2);
//
//    if($row2['author']!=$_SESSION["user_id"]){
//   header("location: {$hostname}/admin/post.php");
//    }
//}
$post=new posts();
$type='update';
$res=$post->show_post_backend($type);
 ?>
<div id="admin-content">
  <div class="container">
  <div class="row">
    <div class="col-md-12">
        <h1 class="admin-heading">Update Post</h1>
    </div>
    <div class="col-md-offset-3 col-md-6">
            <?php foreach($res as $row){ ?>
        <!-- Form for show edit-->
        <form action="save-update-post.php?id=<?php echo $row['post_id'];?>" method="POST" enctype="multipart/form-data" autocomplete="off">
            <div class="form-group">
                <input type="hidden" name="post_id"  class="form-control" value="<?php echo $row['post_id'];?>" placeholder="">
            </div>
            <div class="form-group">
                <label for="exampleInputTile">Title</label>
                <input type="text" name="post_title"  class="form-control" id="exampleInputUsername" value="<?php echo isset($_POST['post_title'])? $_POST['post_title']:$row['title'];?>" required>

            </div>
            <div class="form-group">
                <label for="exampleInputPassword1"> Description</label>
                <textarea name="postdesc" class="form-control"  required rows="5">
                  <?php echo isset($_POST['postdesc'])? $_POST['postdesc']:$row['description'];?>
                </textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputCategory">Category</label>
                <select class="form-control" name="category">
                    <option disabled> Select Category</option>
                  <?php
                   $category_id=$row['category'];
                  $category=new categories();
                  $category->selectBox_category($category_id);
                  ?>
                </select>
                <input type="hidden" name="old-category" value="<?php echo $row['category'];?>">
                  
            </div>
            <div class="form-group">
                <label for="fileToUpload">Post image</label>
                <input type="file" name="fileToUpload">
                <img src="upload/<?php echo $row['post_img'];?>" height="150px">
                <input type="hidden" name="old-image" value="<?php echo $row['post_img'];?>">
            </div>
            <input type="submit" name="submit" class="btn btn-primary" value="Update" />
        </form>
        <!-- Form End -->
          <?php
        }

      ?>
      </div>
    </div>
  </div>
</div>
<?php include "footer.php"; ?>
