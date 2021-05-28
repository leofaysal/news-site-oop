<?php
include "config.php";
include "classes.php";
if($_SESSION["user_role"] == '0'){
     header("Location: {$hostname}/admin/post.php");
   }
$cat= new categories();
$cat->delete_category($_GET['id']);

?>
