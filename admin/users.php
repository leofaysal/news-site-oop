<?php include "header.php";
include "config.php";
include "classes.php";
?>


  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Users</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-user.php">add user</a>
              </div>
              <div class="col-md-12">

                  <table class="content-table">
                      <thead>
                          <th>S.No.</th>
                          <th>Full Name</th>
                          <th>User Name</th>
                          <th>Role</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                      <tbody>
                        <?php

                         //  $serial=$offset+1;
                         // while($row=mysqli_fetch_assoc($result)) {
                         $user=new user();
                         $res=$user->find_all_users();
                         foreach($res as $row){
                          ?>
                          <tr>
                              <td class='id'>  <?php echo   $row['user_id'];?></td>
                              <td><?php echo $row['first_name'] . " " . $row['last_name']; ?></td>
                              <td><?php echo $row['username']; ?></td>
                              <td><?php
                                if($row['role']==1){
                                    echo "admin";
                                }else{
                                    echo "moderater";
                                }
                               ?></td>
                              <td class='edit'><a href='update-user.php?id=<?php echo $row["user_id"]; ?>'><i class='fa fa-edit'></i></a></td>
                              <td class="delete"><a class="text-danger" onClick="return confirm('Are you sure you want to delete this user ?')" href="delete-user.php?id=<?php echo $row['user_id'];?>"><i class='fa fa-trash-o'></i></a></td>
                          </tr>
                          <!-- Javascript Fuction for deleting data -->
                          <!-- <script language="javascript">
                          function deleteConfirm(userid){
                            if(confirm("Are you sure you want to delete this?")){
                              window.location.href="delete-user.php?id="+userid;
                              return true;
                            }
                          }
                          </script> -->
                        <?php }?>
                      </tbody>
                      <?php if(isset($error_msg)){?>
                         <p class='alert alert-danger'><?php echo $error_msg ?></p>

                       <?php }?>
                  </table>
                  <?php

                  $db=new db_connect();
                    $url=basename($_SERVER['PHP_SELF']);
                  $db->pagination('user',$url);
                  ?>

              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
