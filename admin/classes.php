<?php

include "config.php";

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
   function pagination($table,$limit,$url){
    $sql="SELECT COUNT(*) FROM $table";
    $res= $this->run_query($sql);
    $total_records =$this->rows_num($res);
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
  //  if($total_record>$limit){

      for($i=1;$i<=$total_pages;$i++){ //to show pages tabs
        if($i==$page){
          $cls="class='active'";
        }else{
          $cls="";
        }
        $output.="<li><a $cls href='$url?page=$i'>$i</a></li>";
      }
  //  }
    if($total_pages>$page){
      $output.="<li><a href='$url?page=".($page+1)."'>Next</a></li>";
    }
      $output.="</ul>";
      echo $output;

}

}
//  $db = new db_connect();
class user extends db_connect //user class
{
    public $userid;
    public $fname;
    public  $lname;
    public $username;
    public $pass;
    public $role;
    public $sql;



function setuser($firstname , $lastname , $username , $pass , $role)
{
    $this->firstname = $firstname;
    $this->lastname = $lastname;
    $this->username = $username;
    $this->pass = $pass;
    $this->role = $role;

}
function insert($post) // use to insert user in database
{
    global $db;
    $try = new db_connect();
  //the form is coming from add-user.php page


   // $userid=mysqli_real_escape_string($db->conn,$post['user_id']);
    $fname=mysqli_real_escape_string($try->sq_conn(),$post['fname']);
    $lname=mysqli_real_escape_string($try->sq_conn(),$post['lname']);
    $pass = mysqli_real_escape_string($try->sq_conn(),md5($post['password']));
    $username=mysqli_real_escape_string($try->sq_conn(),$post['user']);
    $role=mysqli_real_escape_string($try->sq_conn(),$post['role']);


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
    function get_data() // get user data from database
    {

        global $db;
        $sql = "SELECT * FROM user";
        $res = mysqli_query($db->conn , $sql) or die("Query Failed");;
        if($try->rows_num($res)>0)
        {
            while($rows = mysqli_fetch_assoc($res))
            {
                $array[] = $rows;
            }
            print_r($array);
        }

    }


    function update_user($post)//update selective user from database
    {
      global $db;
      $try = new db_connect();
        $userid=mysqli_real_escape_string($try->sq_conn(),$post['user_id']);
        $fname=mysqli_real_escape_string($try->sq_conn(),$post['f_name']);
        $lname=mysqli_real_escape_string($try->sq_conn(),$post['l_name']);
        $pass = mysqli_real_escape_string($try->sq_conn(),md5($post['newpass']));
        $username=mysqli_real_escape_string($try->sq_conn(),$post['username']);
        $role=mysqli_real_escape_string($try->sq_conn(),$post['role']);
      //  die(print_r($post));

      if($_POST['newpass'] == "")
      {
        $pass = $_POST['oldpass'];
      }

      $sql = "UPDATE user SET first_name='$fname',last_name='$lname',username='$username', password ='$pass' , role='$role' WHERE user_id='$userid'";
      if($try->run_query($sql))
      {
         header("Location:http://localhost/news-site-oops/admin/users.php");
      }
      else
      {
        echo "Query Failed..!!";
      }
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
    function delete_user($id)
    {
      global $db;
      $try = new db_connect();
      $sql = "DELETE FROM post WHERE author = '$id';";
      $sql .= "DELETE FROM user WHERE user_id = '$id'";
      if(mysqli_multi_query($try->sq_conn(),$sql))
      {
        header("Location:http://localhost/news-site-oops/admin/users.php");
      }
      else
      {
        echo "Delete Query Failed..!!";
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
    $this->$post_img = $post_img;

}
public static function showPosts($session){
  global $db;
  $try = new db_connect();
  $limit=3;
//  if($limit!=null){
    if(isset($_GET['page'])){
        $page=$_GET['page'];
    }else{
      $page=1;
    }
    $start=($page-1)*$limit;



  if($session['user_role']=="1"){
  $sql= "SELECT post.post_id,post.title,post.post_date,category.category_name,user.username FROM post
        LEFT JOIN category ON post.category=category.category_id
        LEFT JOIN user ON post.author=user.user_id
        ORDER BY post.post_id LIMIT $start $limit";
}elseif ($session['user_role']=="0"){
  $sql= "SELECT post.post_id,post.title,post.post_date,category.category_name,user.username FROM post
        LEFT JOIN category ON post.category=category.category_id
        LEFT JOIN user ON post.author=user.username
        WHERE post.author={$session['user_id']};
        ORDER BY post.post_id LIMIT $start $limit";
 }
   $res = $try->run_query($sql);
   return $res;
}
function insert_post($post , $auth_id , $img) // use to insert data into the post table of database
{
    global $db;
    $try = new db_connect();
     // whole form values is coming from add-post.php then
     // form is sent to save-post where image is given then both things are passing to this method
    $title = mysqli_real_escape_string($try->sq_conn(), $post['post_title']);
    $description=mysqli_real_escape_string($try->sq_conn(),$post['postdesc']);
    $category=mysqli_real_escape_string($try->sq_conn(),$post['category']);
    $date=date("d M, Y");

    $sql = "SELECT * FROM post WHERE title = '$title'";
    $res = $try->run_query($sql);
    if($try->rows_num($res) > 0)
    {
      echo  "Try With Another Title because this title is already taken.. !!";
    }
    else
    {


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

  function delete_post($id , $cid)//use to delete selective post from database
  {
    global $db;
     $try = new db_connect();
    $sql1="SELECT * FROM post WHERE post_id= '$id' ";
   $result=$try->run_query($sql1);
    $row=mysqli_fetch_assoc($result);

  unlink("upload/".$row['post_img']);

  $sql= "DELETE FROM post WHERE post_id = '$id';";
  $sql .="UPDATE category SET post = post-1 WHERE category_id='$cid'";
  if (mysqli_multi_query($try->sq_conn(),$sql))
  {
    header("location:http://localhost/news-site-oops/admin/post.php");
  }
  else
  {
  echo "Query Failed";
  }
  }




function update_post($post , $image_name)// use to update selective post from database
{
  global $db;

 // whole form values is coming from update-post.php
 //                               it is sending to save-update-post then it is coming with image from save-update-post

 $try = new db_connect();
 $title = mysqli_real_escape_string($try->sq_conn() , $post['post_title']);
 $description = mysqli_real_escape_string($try->sq_conn() , $post['postdesc']);
 $category = mysqli_real_escape_string($try->sq_conn() , $post['category']);
 $post_id = mysqli_real_escape_string($try->sq_conn(), $post['post_id']);


 $sql = "SELECT * FROM post WHERE title = '$title' And post_id != '$post_id'";
 $res = $try->run_query($sql);
 if($try->rows_num($res) > 0)
 {
   echo "Title is Already Exist..!!";

 }
else
{


  $sql = "UPDATE post SET title = '$title' , description =   '$description' , category = '$category' , post_img = '$image_name' WHERE post_id = '$post_id'" ;

  if($try->run_query($sql))
{
  if($post['old-category']!=$post['category'])
    {

      $sql .="UPDATE category SET post=post-1 WHERE category_id='".$post['old-category']."';";
      $sql .="UPDATE category SET post=post+1 WHERE category_id='".$post['category']."';";
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


  function create_category($post)// use to create category
  {
    global $db;

    //all the fields are coming from add-category.php

    $try = new db_connect();
    $category = mysqli_real_escape_string($try->sq_conn() , $post['cat']);

    $sql = "SELECT category_name FROM category WHERE category_name = '$category'";
    $res = $try->run_query($sql);
    if($try->rows_num($res)> 0 )
    {
       echo "Category Already Exists";
    }
    else
    {
      $sql = "INSERT INTO category (category_name) VALUES ('$category')";
    //  echo $sql;
    //  die();
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


  function update_category($post) // use to update specific category
  {

    global $db;

     // whole form values is coming from update-category.php
     $try = new db_connect();
    $category = mysqli_real_escape_string($try->sq_conn(), $post['cat_name']);
    $cat_id  = mysqli_real_escape_string($try->sq_conn(), $post['cat_id']);

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


  function delete_category($id)// use to delete selected category
  {
    global $db;
    $try = new db_connect();
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


?>
