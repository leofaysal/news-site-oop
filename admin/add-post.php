<?php include "header.php";
class Post{
  private $db_host='localhost';
  private $db_username='root';
  private $db_password='';
  private $db_name='news-site';
  private $db_conn=false;
  public function __construct(){
    $this->dbConnect();
  }
  // function for database connection
  public function dbConnect(){
      if(!$this->db_conn){
        $this->mysqli_conn= new mysqli($this->db_host,$this->db_username,$this->db_password,$this->db_name);
      $db_conn=true;
      }
      if($this->mysqli_conn->connect_error){
        print_r($this->mysqli_conn->connect_error);
        }
    }
    public function addPost($_POST){

      $title=mysqli_real_escape_string($this->mysqli_conn,$_POST['post_title']);
      $desc=mysqli_real_escape_string($this->mysqli_conn,$_POST['postdesc']);
      $category=mysqli_real_escape_string($this->mysqli_conn,$_POST['category']);
      $date=date("d M,Y");
      $author=$_SESSION['user_id'];
     $fileName=$_FILES['fileToUpload']['name'];
     $fileSize=$_FILES['fileToUpload']['size'];
     $fileTmpName=$_FILES['fileToUpload']['tmp'];
     $fileExt=strtolower(end(explode('.',$fileName)));
     $extType=array ("jpeg","png","gif","jpg");
     if(in_array($fileExt,$extType)){
       $fileNewName=time()."-".basename($fileName);
       $destFolder="upload/".$fileNewName;
       move_uploaded_file($fileTmpName,$destFolder);
     }
     $sql="INSERT INTO post (title,description,category,post_date,author,post_img)
      VALUES ({$title},{$desc},{$category},{$date},{$author},{$fileNewName})";

    }
   public function sql_query($sql){

      $this->res= mysqli_query($this->mysqli_conn,$sql);
      //  print_r($res);
     return $res;


    }
    public function showCategory(){
      $sql="SELECT * FROM category";
      $cat=$mysqli_conn->sql_query($sql);
    //  print_r($cat);
      if(mysqli_num_rows($cat)>0){
        whlie ($row=mysqli_fetch_assoc($cat)){
          echo "<option value=".$row['category_id'].">".$row['category_name'] ."</option>";
        }

      }

    }
}
//print_r ($_POST);
$db= new Post();


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
                          <label for="exampleInputPassword1"> Description</label>
                          <textarea name="postdesc" class="form-control" rows="5" required><?php echo isset($_POST['postdesc'])? $_POST['postdesc']:''; ?></textarea>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputPassword1">Category</label>
                          <select name="category" class="form-control"  value="">
                              <option disabled> Select Category</option>
                              <?php
                              $db= new Post;
                              $db->showCategory();
                              ?>
                          </select>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputPassword1">Post image</label>
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
