<?php include "header.php";

if (isset($_POST['submit'])){
$post= new posts();

$post->insert_post();

}

?>
  <div id="admin-content">
      <div class="container">
         <div class="row">
             <div class="col-md-12">
                 <h1 class="admin-heading">Add New Post</h1>
             </div>
              <div class="col-md-offset-3 col-md-6">
                  <!-- Form -->
                  <form  action="<?php $_SERVER ['PHP_SELF'];?>" method="POST" enctype="multipart/form-data">
                      <div class="form-group">
                          <label for="post_title">Title</label>
                          <input type="text" name="post_title" class="form-control"  value="<?php echo isset($_POST['post_title'])? $_POST['post_title']:''; ?>" autocomplete="off" required></br>

                      </div>
                      <div class="form-group">
                          <label for="postdesc"> Description</label>
                          <textarea name="postdesc" class="form-control" rows="5" required><?php echo isset($_POST['postdesc'])? $_POST['postdesc']:''; ?></textarea>
                      </div>
                      <div class="form-group">
                          <label for="category">Category</label>
                          <select name="category" class="form-control"  value="">
                              <option disabled> Select Category</option>
                              <?php
                              $category= new categories;
                              $category->selectBox_category();

                              ?>
                          </select>
                      </div>
                      <div class="form-group">
                          <label for="fileToUpload">Post image</label>
                          <input type="file" name="fileToUpload" required>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Save" required />
                  </form>
                  <!--/Form -->
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
