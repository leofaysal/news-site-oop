<?php include "header.php";
if(isset($_POST['submit'])){
  $user=new user();
  $user->update_user();
}

?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading">Modify User Details</h1>
              </div>
              <div class="col-md-offset-4 col-md-4">
              <?php  $user_id= "WHERE user_id=" .$_SESSION['user_id'];
                 $row=$db->find_by_id('user',$user_id);
                 ?>
                  <!-- Form Start -->
                  <form  action="<?php echo $_SERVER['PHP_SELF'];?>" method ="POST">
                      <div class="form-group">
                          <input type="hidden" name="user_id"  class="form-control" value=" <?php echo $row['user_id'];?>" placeholder="" >
                      </div>
                          <div class="form-group">
                          <label>First Name</label>
                          <input type="text" name="f_name" class="form-control" value="<?php echo $row['first_name']; ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>Last Name</label>
                          <input type="text" name="l_name" class="form-control" value="<?php echo $row['last_name']; ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>User Name</label>
                          <input type="text" name="username" class="form-control" value="<?php echo $row['username']; ?>" placeholder="" required>

                      </div>
                      <div class="form-group changepass" style="color:white; background:black; width:150px; padding:10px; border-radius:10px; cursor:pointer">Change Password</div>

                      <div class="form-group mypass" style="display: none ">
                          <label > Enter Old Password</label>
                          <input type="password" name="old-password" class="form-control"  value="" placeholder="">
                      </div>
                      <div class="form-group mypass" style="display: none">
                          <label > Enter New Password</label>
                          <input type="password" name="new-password" class="form-control"  value="" placeholder="">
                      </div>

                      <input type="submit" name="submit" class="btn btn-primary" value="Update" required />

                  </form>
                  <!-- /Form -->


            
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>

<script type="text/javascript">
jQuery(function($) {

  $('.changepass').on('click', function() {
		$('.mypass').toggle();
	})
})
</script>
