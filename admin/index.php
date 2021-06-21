<?php

require_once ('classes.php');

  $session=new Session();
//  $session->user_restriction();
if(isset($_POST['login'])){
  $username=trim($_POST['username']);
  $password=trim(md5($_POST['password']));

  $user= new user();
  $user_record=$user->verify_user($username,$password);

  if($user_record){

    $session->login($user_record);
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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
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
                        <?php if(isset($error_message)){ ?>
                        <div class='alert alert-danger alert-dismissible show' role='alert'> <?php echo $error_message; ?>
                          <button class='close' data-dismiss='alert' aria-label='close'>
                          <span aria-hidden='true'>&times;</span>
                        </button></div>
                       <?php }  ?>
                    </div>
                </div>
            </div>
        </div>


</body>
</html>
