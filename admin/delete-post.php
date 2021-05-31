<?php
include "classes.php";
$post=new posts();
$post->delete_post($_GET['id']);

?>
