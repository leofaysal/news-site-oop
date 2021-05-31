<?php
ob_start();
include "header.php";
if($_SESSION["user_role"]=='0'){
  header("Location:{$hostname}/admin/post.php");
}
 ?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading">Add User</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
                  <!-- Form Start -->
                  <form  action="<?php $_SERVER['PHP_SELF'];?>" method ="POST" autocomplete="off">
                      <div class="form-group">
                          <label>First Name</label>
                          <input type="text" name="fname" class="form-control" value="<?php echo isset($_POST['fname'])? $_POST['fname'] :'';?>" placeholder="First Name" required>
                      </div>
                          <div class="form-group">
                          <label>Last Name</label>
                          <input type="text" name="lname" class="form-control" value="<?php echo isset($_POST['lname'])? $_POST['lname'] :'';?>"placeholder="Last Name" required>
                      </div>
                      <div class="form-group">
                          <label>User Name</label>
                          <input type="text" name="user" class="form-control"value="<?php echo isset($_POST['user'])? $_POST['user'] :'';?>" placeholder="Username" required>
                      </div>

                      <div class="form-group">
                          <label>Password</label>
                          <input type="password" name="password" class="form-control" placeholder="Password" required>
                      </div>
                      <div class="form-group">
                          <label>User Role</label>
                          <select class="form-control" name="role" >
                              <option value="0">moderater</option>
                              <option value="1">admin</option>
                          </select>
                      </div>
                      <input type="submit"  name="save" class="btn btn-primary" value="Save" required />
                  </form>
                   <!-- Form End-->
                   <?php
                   include "classes.php";
                   if(isset($_POST['save'])){
                     $user=new user();
                     $user->insert($_POST);
                   }
                   ?>
               </div>
           </div>
       </div>
   </div>
<?php include "footer.php";
ob_end_flush();
 ?>
