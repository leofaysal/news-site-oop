<?php
include "config.php";
include "classes.php";
$cat= new categories();
$cat->delete_category($_POST);

?>
