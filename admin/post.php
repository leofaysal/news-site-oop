<?php include "header.php"; ?>

  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Posts</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-post.php">add post</a>
              </div>
              <div class="col-md-12">

                  <table class="content-table">
                      <thead>
                          <th>S.No.</th>
                          <th>Title</th>
                          <th>Category</th>
                          <th>Date</th>
                          <th>Author</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                      <tbody>
                          <?php
                          include_once 'config.php';
                          include_once 'database.php';

                          $limit=3;
                          $db=new Database();
                         if ($_SESSION['user_role']=="1"){
                           $db->selectData('post','post.post_id,post.title,category.category_name,post.post_date,user.username','category ON post.category=category.category_id
                           LEFT JOIN user ON post.author=user.user_id',null,'post.post_id',3);
                         }elseif ($_SESSION['user_role']=="0"){
                           $db->selectData('post','post.post_id,post.title,category.category_name,post.post_date,user.username','category ON post.category=category.category_id
                           LEFT JOIN user ON post.author=user.user_id',"post.author={$_SESSION['user_id']}",'post.post_id',3);
                         }


                          $result=$db->getResult();
                        //  print_r($result);
                          foreach($result as $row) { ?>
                          <tr>

                            <td class='id'><?php echo $row['post_id'];?></td>
                              <td><?php echo $row['title'];?></td>
                              <td><?php echo $row['category_name'];?></td>
                              <td><?php echo $row['post_date'];?></td>
                              <td><?php echo $row['username'];?></td>
                              <td class='edit'><a href='update-post.php?id=<?php echo $row["post_id"];?>'><i class='fa fa-edit'></i></a></td>
                              <td class='delete'><a onClick="deleteConfirm(<?php echo $row['post_id']; ?>)"><i class='fa fa-trash-o'></i></a></td>


                          <!-- Javascript Fuction for deleting data -->
                          <script language="javascript">
                          function deleteConfirm(postid){
                            if(confirm("Are you sure you want to delete this?")){
                              window.location.href="delete-post.php?id="+postid;
                              return true;
                            }

                          }
                          </script>
                          </tr>
                          <?php
                                      }?>
                      </tbody>
                  </table>
                  <?php
                 if ($_SESSION['user_role']=="1"){
                  echo $db->pagination('post','category ON post.category=category.category_id LEFT JOIN user ON post.author=user.user_id',null,$limit);
                }
                else if ($_SESSION['user_role']=="0"){
                    echo $db->pagination('post','category ON post.category=category.category_id LEFT JOIN user ON post.author=user.user_id',"post.author={$_SESSION['user_id']}",$limit);
                }?>
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
