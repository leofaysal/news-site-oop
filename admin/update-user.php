<?php include "header.php";
include "classes.php";
if($_SESSION["user_role"]=='0'){
  include "config.php";

  $user_id=$_GET['id'];
  $sql2="SELECT author FROM post WHERE author={$user_id}";
  $result2=mysqli_query($conn,$sql2) or die("Query Failed:user");
  $row2=mysqli_fetch_assoc($result2);

   if($row2['author']!=$_SESSION["user_id"]){
  header("location: {$hostname}/admin/users.php");
   }
}

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
                  <?php
                  include "config.php";
                  $user_id=$_GET['id'];
                  $sql="SELECT * FROM user WHERE user_id= {$user_id}";

                  $result=mysqli_query($conn,$sql) or die("Query Failed, Select user");
                  if(mysqli_num_rows($result) > 0){
                    while($row=mysqli_fetch_assoc($result)){
                  ?>
                  <!-- Form Start -->
                  <form  action="<?php echo $_SERVER['PHP_SELF'].'?id='.$row['user_id'];?>" method ="POST">
                      <div class="form-group">
                          <input type="hidden" name="user_id"  class="form-control" value="<?php echo $row['user_id'];?>" placeholder="" >
                      </div>
                          <div class="form-group">
                          <label>First Name</label>
                          <input type="text" name="f_name" class="form-control" value="<?php echo isset($_POST['f_name'])? $_POST['f_name']:$row['first_name']; ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>Last Name</label>
                          <input type="text" name="l_name" class="form-control" value="<?php echo isset($_POST['l_name'])? $_POST['l_name']:$row['last_name']; ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>User Name</label>
                          <input type="text" name="username" class="form-control" value="<?php echo isset($_POST['username'])? $_POST['username']: $row['username']; ?>" placeholder="" required>
                            <?php  if(isset($user->error)){
                              echo '<p class="error alert alert-danger">' . $user->error .' <a href="#"class="close" data-dismiss="alert" aria-label="close">&times;</a></p>';}
                               ?>
                      </div>
                      <div class="form-group">
                          <label>User Role</label>
                          <select class="form-control" name="role" value="<?php echo isset($_POST['role'])? $_POST['role']:$row['role']; ?>">
                            <?php
                             if(isset($_POST['role'])){
                               if($_POST['role']==1){
                                   echo "<option value='1' selected>Admin</option>
                                       <option value='0'>Moderater</option>";
                               }else{
                                 echo "<option value='1'>Admin</option>
                                   <option value='0' selected>Moderater</option>";
                               }
                             }else{
                               if($row['role']==1){
                                   echo "<option value='1' selected>Admin</option>
                                       <option value='0'>Moderater</option>";
                               }else{
                                 echo "<option value='1'>Admin</option>
                                   <option value='0' selected>Moderater</option>";
                               }
                             }

                            ?>
                          </select>
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
                <?php
                  }
                }
                ?>
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
