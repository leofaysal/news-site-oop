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
                include "config.php";
                $cat_id=$_GET['id'];
                $sql="SELECT * FROM category where category_id={$cat_id}";
                $result=mysqli_query($conn,$sql);
                if(mysqli_num_rows($result)>0){
                  $row=mysqli_fetch_assoc($result);

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
                 //query for update category exist
                 $sql1="SELECT category_name FROM category WHERE category_name='{$_POST['cat_name']}'";

                 $result1=mysqli_query($conn,$sql1);
                 if(mysqli_num_rows($result1)){
                     // if input value exists
                   $error_categoryname="Category name already exist";
                   echo "<p class='alert alert-danger'>" .$error_categoryname. "<a href='#'class='close' data-dismiss='alert' aria-label='close'>&times;</a> </p>";

                 }else{
                   $sql1 = "UPDATE category SET category_id='{$_POST['cat_id']}',category_name='{$_POST['cat_name']}' WHERE  category_id={$_POST['cat_id']}";



                 if(mysqli_multi_query($conn,$sql1)){
                   // redirect to category page
                   header("location: {$hostname}/admin/category.php");
                   }
                 }

               }
                 ?>
                </div>
              </div>
            </div>
          </div>
<?php

include "footer.php"; ?>
