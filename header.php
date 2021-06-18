
<?php
// *** Make the title dynamic ***

include "admin/classes.php";

$db= new db_connect();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php  echo $db->page_display_title() ;?> </title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="css/font-awesome.css">
    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<!-- HEADER -->
<div id="header">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- LOGO -->
            <div class=" col-md-offset-4 col-md-4">
              <?php
                $setting=new Settings();
                if($setting->logo == ""){
                     echo  '<a href="index.php"><h1>'.$setting->websitename.'</h1></a>';
                   }
                   else{
                     echo '<a href="index.php"><img class="logo" src="admin/images/' .$setting->logo .'"></a>';
                   }

                ?>

            </div>
            <!-- /LOGO -->
        </div>
    </div>
</div>
<!-- /HEADER -->
<!-- Menu Bar -->
<div id="menu-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
              <?php

              if(isset($_GET['cid'])){
                  $cat_id=$_GET['cid'];
              }
                $active="";
                $type='menu';
                $category= new categories();
                $result=$category->showCategory($type);


              ?>
                <ul class='menu'>

                  <li><a href="<?php echo $db->hostname;?>">HOME</a></li>

                  <?php

                foreach($result as $row){

                        if(isset($_GET['cid'])){
                        $cat_id=$_GET['cid'];
                        if($row["category_id"]==$cat_id){
                          $active="active";
                        }else{
                            $active="";
                        }
                    }

                     echo "<li><a class='{$active}' href='category.php?cid={$row["category_id"]}'>{$row["category_name"]}</a></li>";
                      }
                    ?>
                </ul>

            </div>
        </div>
    </div>
</div>
<!-- /Menu Bar -->
