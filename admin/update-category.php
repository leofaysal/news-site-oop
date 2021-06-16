<?php include "header.php";

if($_SESSION["user_role"]=='0'){
  header("Location:{$hostname}/admin/post.php");
}
 ?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="adin-heading"> Update Category</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
                <!-- Datebase configuration to update category -->
                <?php
                 $category=new categories();
                 $res=$category->showCategory('frontend');
                 foreach($res as $row){
                ?>
                  <form action="<?php $_SERVER['PHP_SELF'];?>" method ="POST">
                      <div class="form-group">
                          <input type="hidden" name="cat_id"  class="form-control" value="<?php echo $row['category_id'];?>" placeholder="">
                      </div>
                      <div class="form-group">
                          <label>Category Name</label>
                          <input type="text" name="cat_name" class="form-control" value="<?php echo $row['category_name'];?>"  placeholder="" required>

                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
                  </form>
                <?php
               }

               if(isset($_POST['submit'])){
                 $cat= new categories();
                 $cat-> update_category();
               }
                 ?>
                </div>
              </div>
            </div>
          </div>
<?php

include "footer.php"; ?>
