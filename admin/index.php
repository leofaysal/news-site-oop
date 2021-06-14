<?php

require_once ('classes.php');
if(!session_id()){
  session_start();
}
  $session=new Session();

  // if(!$session->is_signed_in){
  //   header("Location:http://localhost/news-site-oops/admin/");
  // }
if(isset($_POST['login'])){
  $username=trim($_POST['username']);
  $password=trim(md5($_POST['password']));
  $user= new user();
  $user_record=$user->verify_user($username,$password);
  //print_r($user_record);
  //die();
  //$user_found=array_shift($user_record);
  if($user_record){

    $session->login($user_record);
    //echo $session->username;
  header("Location:http://localhost/news-site-oops/admin/post.php");
  }else{
    $error_message="Username or Password incorrect";
  }
}
else{
    $username="";
    $password="";
  }

?>

<!doctype html>
<html>
   <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>ADMIN | Login</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css" />
        <link rel="stylesheet" href="font/font-awesome-4.7.0/css/font-awesome.css">
        <link rel="stylesheet" href="../css/style.css">
    </head>

    <body>
        <div id="wrapper-admin" class="body-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-offset-4 col-md-4">
                        <img class="logo" src="images/news.jpg">
                        <h3 class="heading">Admin</h3>
                        <!-- Form Start -->
                        <form  action="<?php $_SERVER['PHP_SELF']?>" method ="POST">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="" required>
                            </div>
                            <input type="submit" name="login" class="btn btn-primary" value="login" />
                           <input type="submit" class="btn btn-primary" name="signup" value="Sign Up">
                        </form>
                        <!-- /Form  End -->

                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
