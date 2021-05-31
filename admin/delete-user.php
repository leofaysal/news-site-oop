<?php
include "classes.php";
$user=new user();
$user->delete_user($_GET['id']);
?>
