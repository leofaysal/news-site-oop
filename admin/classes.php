<?php



class db_connect // database connection class
{
    private $username;
    private $password;
    private $host;
    private $db;
    private $query;
    private $connection;

    private $mysqli;
    private $auth;
    public $conn;
    public $hostname= "http://localhost/news-site-oops";

    function __construct()
    {
      $this->authenticate();
      // $this->authenticate();
		//	$this->authMessage();


    }

    function authenticate()
    {
      $this->host = "localhost";
      $this->username = "root";
      $this->password = "";
      $this->db = "news-site";

      $this->connection = mysqli_connect($this->host , $this->username , $this->password , $this->db);
      if($this->connection)
      {
        $this->auth =  true;
      }
      else
      {
         $this->auth = false;
      }
      return $this->auth;
    }


    //checking authentication



  function auth_status()
  {
    return $this->auth;
  }


  function auth_message()
  {
    if($this->auth_status())
    {
      return $this->auth_status();
    }
    else
    {
      echo "Error in mysqli Connection";
      die(print_r(mysqli_error()));
    }
  }

  function sq_conn()
  {
    return $this->connection;
  }

  function sq_conn_close()
  {
    $con_close = $this->connection->close();
    return $conn_close;
  }

  function run_query($query)
  {
    $this->query = mysqli_query($this->connection , $query);
    return $this->query;

  }

  function rows_num($res)
   {
    $row = mysqli_num_rows($res);
    return $row;
  }

   function pagination($type=''){
  //  $session=new Session;
     $limit=3;
     $where='';
     $table='post';
     $url=$this->current_page();
     if(isset($_SESSION['user_role'])){

           if($_SESSION['user_role']==0){
                $table="post";
                 $where= " WHERE author={$_SESSION['user_id']}";
           }else if($_SESSION['user_role'] ==1){
              $where='';
                   if($url=="post.php"){ $table="post";}
                   elseif($url=="users.php"){ $table="user";}
                    elseif($url=="category.php"){ $table="category";}
              }
      }else if (isset($_GET['aid'])){$where= " WHERE author={$_GET['aid']}"; $aid= "cid=".$_GET['aid'];}
      else if (isset($_GET['cid'])){$where= " WHERE category={$_GET['cid']}";}
      else if (isset($_GET['id'])){$where= " WHERE post_id={$_GET['id']}";}
      else if (isset($_GET['search'])){$where = "  WHERE post.title LIKE '%{$_GET['search']}%' OR post.description LIKE '%{$_GET['search']}%' ";}



    $sql="SELECT * FROM $table
           $where ";

    $res= $this->run_query($sql);
  //  print_r($res);
    if ($this->rows_num($res)>0){
    $total_records=$this->rows_num($res);

}
    $total_pages=ceil($total_records/$limit);
    if(isset($_GET['page'])){
      $page=$_GET['page'];
    }else{
      $page=1;
    }
      $output="<ul class='pagination'>";
      if($page>1){
        $output.="<li><a href='$url?page=".($page-1)."'>Prev</a></li>";
      }


      for($i=1;$i<=$total_pages;$i++){ //to show pages tabs
        if($i==$page){
          $cls="class='active'";
        }else{
          $cls="";
        }
        $output.="<li><a $cls href='$url?page=$i'>$i</a></li>";
      }

    if($total_pages>$page){
      $output.="<li><a href='$url?page=".($page+1)."'>Next</a></li>";
    }
      $output.="</ul>";
      echo $output;

}
  function current_page(){  //returns url of the current page
    return basename($_SERVER['PHP_SELF']) ;
}

function page_display_title($page_title='NEWS SITE'){   //display dyname title on front end
  $where="";
  $url=$this->current_page();
  if($url=='search.php'){
      $page_title= "{$_GET['search']}";
    }

  else if($url=='single.php'){
    $table="post";
    $where= " WHERE post_id={$_GET['id']}";
     $row_title=$this->find_by_id($table,$where);
     $page_title=$row_title['title'];
  }
  else  if($url=='category.php'){
      $table="category";
      $where= " WHERE category_id={$_GET['cid']}";
       $row_title=$this->find_by_id($table,$where);
       $page_title=$row_title['category_name'] ."  News";
   }
    else if($url=='author.php'){
        $table="user";
        $where= " WHERE user_id={$_GET['aid']}";
         $row_title=$this->find_by_id($table,$where);
        $page_title= "News By " .$row_title['first_name'] . " ".$row_title['last_name'] ;
      }
    return $page_title;

}

  function find_by_id($table,$where){

    $sql="SELECT * FROM $table $where";
    echo $sql;
    $result=$this->run_query($sql);
      //  $row=mysqli_fetch_assoc($result);
      if($this->rows_num($result)>0){
        foreach($result as $row){
          return $row;
        }
      }

    }

}
 $db = new db_connect();
class user extends db_connect //user class
{
    public $userid;
    public $fname;
    public  $lname;
    public $username;
    public $pass;
    public $role;
    public $sql;
    public $error;



function setuser($firstname , $lastname , $username , $pass , $role)
{
    $this->firstname = $firstname;
    $this->lastname = $lastname;
    $this->username = $username;
    $this->pass = $pass;
    $this->role = $role;

}
function insert_user() // use to insert user in database
{
    global $db;
    $try = new db_connect();
  //the form is coming from add-user.php page

   // $userid=mysqli_real_escape_string($db->conn,$post['user_id']);
    $fname=mysqli_real_escape_string($try->sq_conn(),$_POST['fname']);
    $lname=mysqli_real_escape_string($try->sq_conn(),$_POST['lname']);
    $pass = mysqli_real_escape_string($try->sq_conn(),md5($_POST['password']));
    $username=mysqli_real_escape_string($try->sq_conn(),$_POST['user']);
    $role=mysqli_real_escape_string($try->sq_conn(),$_POST['role']);


     $sql = "SELECT * FROM user WHERE username = '$username'";
    $res = $try->run_query($sql);
    if($try->rows_num($res)>0)
    {
      echo "Username Already Exist Try To use different username";
    }
else{

    $sql= "INSERT INTO user (first_name , last_name , username , password , role ) VALUES ('$fname' , '$lname' , '$username' , '$pass' , '$role')";

    if($try->run_query($sql)){
    header("Location:http://localhost/news-site-oops/admin/users.php");
      }
    }
  }
    function find_all_users() // get user data from database
    {

        global $db;
        $try = new db_connect();
        $limit=3;
        if(isset($_GET['page'])){
          $page=$_GET['page'];
        } else{
          $page=1;
        }
        $start=($page-1)*$limit;
        $sql = "SELECT * FROM user
        ORDER BY user_id DESC LIMIT $start, $limit";
        $res =  $try->run_query($sql) or die("Query Failed");;

        return $res;

    }


    function update_user()//update selective user from database
    {
      global $db;
      $try = new db_connect();
        $userid=mysqli_real_escape_string($try->sq_conn(),$_POST['user_id']);
        $fname=mysqli_real_escape_string($try->sq_conn(),$_POST['f_name']);
        $lname=mysqli_real_escape_string($try->sq_conn(),$_POST['l_name']);
    //   $pass = mysqli_real_escape_string($try->sq_conn(),md5($post['new-password']));
        $username=mysqli_real_escape_string($try->sq_conn(),$_POST['username']);
       if($_SESSION['user_role']==0){
         $role=$_SESSION['user_role'];
       }else{
         $role=mysqli_real_escape_string($try->sq_conn(),$_POST['role']);
       }

      //  die(print_r($post));


      if(isset($_POST['old-password'])&& $_POST['new-password']){
        $old_password=mysqli_real_escape_string($try->sq_conn(),md5($_POST['old-password']));
        $new_password=mysqli_real_escape_string($try->sq_conn(),md5($_POST['new-password']));
      }else{
        $old_password="";
        $new_password="";
      }
      $this->error="";
      $sql="SELECT username FROM user WHERE username='{$username}' AND user_id !='$userid'";
     $result=$try->run_query($sql) or die("Query Failed :select");

     if($try->rows_num($result)>0){
         // if input value exists
     $this->error="Username already exists , choose another username";
  //   echo "Username already exists , choose another username";
    //  die();
         }else{
           if(empty($old_password || $new_password)){
             $sql="UPDATE user SET first_name='{$fname}',last_name='{$lname}',username='{$username}',role='{$role}' WHERE user_id={$userid}";
            }
            else{
              $sql="UPDATE user SET first_name='{$fname}',last_name='{$lname}',username='{$username}', role='{$role}' ,password='{$new_password}' WHERE user_id={$userid} and password='{$old_password}'";

             }
            
             if($try->run_query($sql)){
                      if($_SESSION['user_role']==0)
                      {
                        header("Location:http://localhost/news-site-oops/admin/post.php");
                       }else{
                           header("Location:http://localhost/news-site-oops/admin/users.php");
                       }
             }
             else
             {
               echo "Query Failed..!!";
             }
           }

    //  $sql = "UPDATE user SET first_name='$fname',last_name='$lname',username='$username', password ='$pass' , role='$role' WHERE user_id='$userid'";

    }

    function select_user($post)// use to select user and update if not same
    {
      global $db;
      $try = new db_connect();
      // whole form values is coming from update-user.php

        $userid=mysqli_real_escape_string($try->sq_conn(),$post['user_id']);
        $fname=mysqli_real_escape_string($try->sq_conn(),$post['f_name']);
        $lname=mysqli_real_escape_string($try->sq_conn(),$post['l_name']);
        $username=mysqli_real_escape_string($try->sq_conn(),$post['username']);
        $role=mysqli_real_escape_string($try->sq_conn(),$post['role']);

      $sql = "SELECT * FROM user WHERE username = '$username' AND user_id != '$userid' ";
      $res = $try->run_query($sql) or die("Query Failed.123.!");
      if($try->rows_num($res)>0)
      {
       echo "Username Already Exist..!!";
      }
      else
      {
       $this->update_user($post);
      }

    }


    function delete_user()
    {
      global $db;
      $try = new db_connect();
      $query= "SELECT category FROM post WHERE author ={$_GET['id']}";
      $user_posts=$try->run_query($query);


      if($try->rows_num($user_posts)>0){
        while($row=mysqli_fetch_array($user_posts)){

         $query ="UPDATE category SET post=post - 1 WHERE category_id={$row['category']}";
        $res=$try->run_query($query);
        }
      }


        $sql = "DELETE FROM post WHERE author = {$_GET['id']};";
        $sql .= "DELETE FROM user WHERE user_id = {$_GET['id']};";



      if(mysqli_multi_query($try->sq_conn(),$sql))
      {
        header("Location:http://localhost/news-site-oops/admin/users.php");
      }
      else
      {
        echo "Delete Query Failed..!!";
      }

    }

public function verify_user($username,$password){

  $try=new db_connect();
  $username=mysqli_real_escape_string($try->sq_conn(),$username);
  $password=mysqli_real_escape_string($try->sq_conn(),$password);
  $sql="SELECT * FROM user WHERE username='{$username}' AND password='{$password}'";

  $result=$try->run_query($sql);

  if ($try->rows_num($result)>0){
    return $result;
  }
  else{
    return false;
  }

}

}



class posts extends db_connect // class of posts table
{

    public $title;
    public $description;
    public $category;
    public $post_date;
    public $author;
    public $post_img;



function set_post($title , $description , $category , $post_date , $author , $post_img)
{
    $this->title = $title;
    $this->description = $description;
    $this->category = $category;
    $this->post_date = $post_date;
    $this->author = $author;
    $this->post_img = $post_img;

}

public function show_post_backend($type="all"){
  $try = new db_connect();
  $where = '';
  $limit=''; $start='';
  $orderby='';  $range='';

  if(isset($_SESSION['user_role'])){
      if($type=="update"){
         if($_SESSION['user_role']==0){
             $where= " WHERE post.author={$_SESSION['user_id']} AND post_id= {$_GET['id']}";
         }elseif($_SESSION['user_role']==1){
           $where=" WHERE post_id= {$_GET['id']}";
         }
      }
      elseif($type="all"){
                 $limit=3;   $orderby=" ORDER BY post.post_id DESC  ";
                if(isset($_GET['page'])){
                    $page=$_GET['page'];
                }else{
                  $page=1;
                }
                $start=($page-1)*$limit;
                $range= "LIMIT $start,$limit";

        if($_SESSION['user_role']==0){
            $where= " WHERE post.author={$_SESSION['user_id']}";
        }elseif($_SESSION['user_role']==1){
          $where="";
        }
      }
    }
    $sql= "SELECT post.post_id,post.title,post.category,post.post_date,post.description,post.post_img,post.author,
          category.category_id,category.category_name,user.username FROM post
          LEFT JOIN category ON post.category=category.category_id
          LEFT JOIN user ON post.author=user.user_id
          $where $orderby
           $range";
  // echo $sql;

     $res = $try->run_query($sql);
  //   print_r($res);


     if($try->rows_num($res)>0)
     {
         while($rows = mysqli_fetch_assoc($res))
         {
             $array[] = $rows;

         }
         return $array;
     }



}
public function showPosts_frontend($type = ''){
  global $db;
  $try = new db_connect();
  $limit=3;
  $where = '';
   $orderby=" ORDER BY post.post_id DESC";
//  if($limit!=null){
    if(isset($_GET['page'])){
        $page=$_GET['page'];
    }else{
      $page=1;
    }
    $start=($page-1)*$limit;


 if($type == 'post') {
      $where = " WHERE post.post_id = {$_GET['id']} ";

}
else if($type == 'category') {
      $where = " WHERE post.category = {$_GET['cid']} ";

}
else if($type == 'author') {
      $where = " WHERE post.author = {$_GET['aid']} ";

}else if($type == 'search') {

 $search_term=mysqli_real_escape_string($try->sq_conn(),$_GET['search']);
$where = "   WHERE post.title LIKE '%{$search_term}%' OR post.description LIKE '%{$search_term}%' ";

}else if($type == 'single') {
  $where = "  WHERE post.post_id={$_GET['id']}";
  $orderby="";
}else if($type == 'recent post'){
    $start= 0;
    $limit= 5;

  }


  $sql= "SELECT post.post_id,post.title,post.category,post.post_date,post.description,post.post_img,post.author,
        category.category_id,category.category_name,user.username FROM post
        LEFT JOIN category ON post.category=category.category_id
        LEFT JOIN user ON post.author=user.user_id
        $where
        LIMIT $start, $limit";
echo $sql;

   $res = $try->run_query($sql);


   if($try->rows_num($res)>0)
   {
       while($rows = mysqli_fetch_assoc($res))
       {
           $array[] = $rows;

       }
       return $array;
   }


}
function insert_post() // use to insert data into the post table of database
{
    global $db;
    $try = new db_connect();
     // whole form values is coming from add-post.php then
     // form is sent to save-post where image is given then both things are passing to this method
    $title = mysqli_real_escape_string($try->sq_conn(), $_POST['post_title']);
    $description=mysqli_real_escape_string($try->sq_conn(),$_POST['postdesc']);
    $category=mysqli_real_escape_string($try->sq_conn(),$_POST['category']);
    $date=date("d M, Y");
   $auth_id=$_SESSION['user_id'];
    $sql = "SELECT * FROM post WHERE title = '$title'";
    $res = $try->run_query($sql);
    if($try->rows_num($res) > 0)
    {
      echo  "Try With Another Title because this title is already taken.. !!";
    }
    else
    {

     $img=$this->set_file();
     $sql= "INSERT INTO post (title , description , category , post_date , author , post_img ) VALUES ('$title' , '$description' , '$category' , '$date' , '$auth_id' , '$img');";

     $sql .="UPDATE category SET post=post + 1 WHERE category_id={$category}";

        if(mysqli_multi_query($try->sq_conn(),$sql))
          {
              header("Location:http://localhost/news-site-oops/admin/post.php");
          }
        else
        {
              echo "<div class='alert alert-danger'>Query Failed.</div>";
        }
      }
}

   function set_file(){
     $errors=array();
     $fileName=$_FILES['fileToUpload']['name'];
     $fileSize=$_FILES['fileToUpload']['size'];
     $fileTmpName=$_FILES['fileToUpload']['tmp_name'];
      $fileType=$_FILES['fileToUpload']['type'];
     $fileExt=strtolower(end(explode('.',$fileName)));
     $extType=array ("jpeg","png","gif","jpg");
     if(in_array($fileExt, $extType)=== false){
  $error[]="This extension file is not allowed,Please choose a JPG or PNG file.";
   }
         if($fileSize>2097152){
      $error[]="File size must be 2MB or lower.";
    }
    $new_name=time(). "-".basename($fileName);
    $target="upload/" .$new_name;
      if(empty($errors)== true){
        move_uploaded_file ($fileTmpName,$target);
        return $new_name;
      }
      else{
        print_r($errors);
        die("File Upload Failed.");
      }

   }

  function delete_post()//use to delete selective post from database
  {
    global $db;
     $try = new db_connect();
    $sql1="SELECT * FROM post WHERE post_id= {$_GET['id']} ";
   $result=$try->run_query($sql1);
    $row=mysqli_fetch_assoc($result);

  unlink("upload/".$row['post_img']);

  $sql= "DELETE FROM post WHERE post_id = {$_GET['id']};";
  $sql .="UPDATE category SET post = post-1 WHERE category_id={$_GET['cid']}";
  if (mysqli_multi_query($try->sq_conn(),$sql))
  {
    header("location:http://localhost/news-site-oops/admin/post.php");
  }
  else
  {
  echo "Query Failed";
  }
  }




function update_post($image_name)// use to update selective post from database
{
  global $db;

 // whole form values is coming from update-post.php
 //                               it is sending to save-update-post then it is coming with image from save-update-post

 $try = new db_connect();
 $title = mysqli_real_escape_string($try->sq_conn() , $_POST['post_title']);
 $description = mysqli_real_escape_string($try->sq_conn() , $_POST['postdesc']);
 $category = mysqli_real_escape_string($try->sq_conn() , $_POST['category']);
 $post_id = mysqli_real_escape_string($try->sq_conn(), $_POST['post_id']);


 $sql = "SELECT * FROM post WHERE title = '$title' And post_id != '$post_id'";
 $res = $try->run_query($sql);
 if($try->rows_num($res) > 0)
 {
   echo "Title Already Exist..!!";

 }
else
{


  $sql = "UPDATE post SET title = '$title' , description =   '$description' , category = '$category' , post_img = '$image_name' WHERE post_id = '$post_id'" ;

  if($try->run_query($sql))
{
  if($_POST['old-category']!=$_POST['category'])
    {

      $sql .="UPDATE category SET post=post-1 WHERE category_id='".$_POST['old-category']."';";
      $sql .="UPDATE category SET post=post+1 WHERE category_id='".$_POST['category']."';";
      $result= mysqli_multi_query($try->sq_conn(),$sql);
      if($result)
      {
        header("location:http://localhost/news-site-oops/admin/post.php");
      }
    }
  else
  {
  echo "Query Failed";

  }
  header("location:http://localhost/news-site-oops/admin/post.php");

  }
  else
  {
    echo "query failed..!!";
  }

    }
  }

}


class categories extends db_connect // class of category table
{
  public $category_id;
  public $category;
  public $post;

  function selectBox_category($category_id){
  $try = new db_connect();
    $sql = "SELECT * FROM category";
  //  echo $sql;
      $res =  $try->run_query($sql) or die("Query Failed");
    //  print_r($res);
      $cat_id=$category_id;
    //  die();
      if($try->rows_num($res)>0){
        while($row=mysqli_fetch_array($res)){
          if($cat_id==$row['category_id']){
                  $selected= "selected";
                   }else{
                     $selected= "";
                   }
          echo "<option {$selected} value='".$row['category_id']."'>".$row['category_name']."</option>";
          }

      return true;
        }
}

   function showCategory($type)
  {

      global $db;
      $try = new db_connect();
      $condition="";
      if ($type=='backend'){
        $limit=3;
        if(isset($_GET['page'])){
          $page=$_GET['page'];
        } else{
          $page=1;
        }
        $start=($page-1)*$limit;
      $condition= "LIMIT $start, $limit";
    } else if ($type=='menu'){
        $condition=" WHERE post > 0";
      }

      $sql = "SELECT * FROM category
             $condition";

      $res =  $try->run_query($sql) or die("Query Failed");

      return $try->rows_num($res)> 0 ? $res : false;

  }
  function create_category()// use to create category
  {
    global $db;

    //all the fields are coming from add-category.php

    $try = new db_connect();
    $category = mysqli_real_escape_string($try->sq_conn() , $_POST['cat']);

    $sql = "SELECT category_name FROM category WHERE category_name = '$category'";
    $res = $try->run_query($sql);
    if($try->rows_num($res)> 0 )
    {
       echo "Category Already Exists";
    }
    else
    {
      $sql = "INSERT INTO category (category_name) VALUES ('$category')";

      if($try->run_query($sql))
      {
        header("location:http://localhost/news-site-oops/admin/category.php");
      }
      else
      {
        echo "query Failed..!!";
      }
    }

  }


  function update_category() // use to update specific category
  {

    global $db;

     // whole form values is coming from update-category.php
     $try = new db_connect();
    $category = mysqli_real_escape_string($try->sq_conn(), $_POST['cat_name']);
    $cat_id  = mysqli_real_escape_string($try->sq_conn(), $_POST['cat_id']);

    $sql = "SELECT category_name FROM category WHERE category_name = '$category'";
    $res =$try->run_query($sql);
    if($try->rows_num($res) > 0 )
    {
       echo "Category Already Exists";
    }
    else
    {
      $sql = "UPDATE category  SET category_name ='$category' WHERE category_id = '$cat_id'";
      if($try->run_query($sql))
      {
        header("location:http://localhost/news-site-oops/admin/category.php");
      }
      else
      {
        echo "query Failed..!!";
      }
    }



  }


  function delete_category()// use to delete selected category
  {
    global $db;
    $try = new db_connect();
    $id= $_GET['id'];
    $sql = "DELETE FROM post Where category = '$id';";
    $sql .="DELETE FROM category WHERE category_id='$id'";

  if (mysqli_multi_query($try->sq_conn() , $sql))
   {
      header("location:http://localhost/news-site-oops/admin/category.php");
   }
 else
  {
       echo "Query Failed";
  }
   }
}

  class Session {

    private $signed_in=false;
    public  $user_id;
    public $user_role;
    public $username;
    public $password;


    function __construct(){
     session_start();
     $this->check_login();
    }

    public function is_signed_in(){
      return $this->signed_in;
    }

    public function login($user_record){

       if(!empty($user_record)){
           while($row=mysqli_fetch_assoc($user_record)){

            $_SESSION["username"]=$row['username'];
            $_SESSION["user_id"]=$row['user_id'];
            $_SESSION["user_role"]=$row['role'];
            $_SESSION["password"]=$_POST{'password'};
            $this->signed_in=true;

                         }
                    }
      }


      public function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        unset($_SESSION['user_role']);
        unset($_SESSION['user_id']);
           $this->signed_in=false;
      }


    private function check_login(){

      if(isset($_SESSION['user_id'])){

      $this->user_id=$_SESSION['user_id'];
      $this->username= $_SESSION["username"];
      $this->user_role=$_SESSION["user_role"];
      $this->password=$_SESSION["password"];
      $this->signed_in=true;

      }else {
          unset($this->user_id);
          $this->signed_in=false;
      }

    }

  }

  //  $session= new Session();

  class Settings extends db_connect{
    public $websitename;
    public $logo;
    public $footerdesc;

    function __construct(){
      $this->display_setting();
    }

    function display_setting(){
        $try=new db_connect();
        $sql="SELECT * FROM settings";

        $result=$try->run_query($sql) or die("Query Failed.");


        foreach($result as $table_field){

         $this->websitename= $table_field['websitename'];
          $this->logo= $table_field['logo'];
           $this->footerdesc= $table_field['footerdesc'];
         }

    }

    function change_settings(){
      $try=new db_connect();
      if(empty($_FILES['logo']['name'])){
      $file_name=$_POST['old_logo'];
      }else{
        $errors=array();
        $file_name=$_FILES['logo']['name'];
        $file_size=$_FILES['logo']['size'];
        $file_tmp=$_FILES['logo']['tmp_name'];
        $file_type=$_FILES['logo']['type'];
        $file_ext= strtolower(end(explode('.',$file_name)));
        $extensions=array("jpeg","jpg","png");

        if(in_array($file_ext,$extensions)=== false){
          $error[]="This extension file is not allowed,Please choose a JPG or PNG file.";
        }
        if($file_size>2097152){
            $error[]="File size must be 2MB or lower.";
          }
            if(empty($errors)== true){
              move_uploaded_file ($file_tmp,"images/".$file_name);
            }
            else{
              print_r($errors);
              die();
            }
      }

       $sql="UPDATE settings SET websitename='{$_POST["website_name"]}',logo='{$file_name}',footerdesc='{$_POST["footer_desc"]}'";

      $result=$try->run_query($sql);

       if ($result){
        header("location:http://localhost/news-site-oops/admin/post.php");
      }else{
        echo "Query Failed";
      }

    }

  }


?>
