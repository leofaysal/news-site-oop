<?php include "header.php";
//  include "classes.php";
if(isset($_POST['submit'])){

}
   ?>
  <div id="admin-content">
      <div class="container">
         <div class="row">
             <div class="col-md-12">
                 <h1 class="admin-heading">Website Settings</h1>
             </div>
              <div class="col-md-offset-3 col-md-6">

                <?php

                    $setting=new Settings();

                ?>
                  <!-- Form -->
                  <form  action="" method="POST" enctype="multipart/form-data">
                      <div class="form-group">
                          <label for="website_name">Website Name</label>
                          <input type="text" name="website_name" value="<?php echo $setting->websitename;?>" class="form-control" autocomplete="off" required>
                      </div>
                      <div class="form-group">
                          <label for="logo">Website Logo</label>
                          <input type="file" name="logo">
                          <img src="images/<?php echo $setting->logo;?>">
                          <input type="hidden" name="old_logo" value="<?php echo $setting->logo;?>" >
                      </div>
                      <div class="form-group">
                          <label for="footer_desc">Footer Description</label>
                          <textarea name="footer_desc" class="form-control" rows="5" required><?php echo $setting->footerdesc;?></textarea>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Save" required />
                  </form>
                  <!--/Form -->

              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
