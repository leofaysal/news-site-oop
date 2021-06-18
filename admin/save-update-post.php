<?php

include "classes.php";
if(isset($_POST['submit'])){
  $post =new posts();
  if(empty($_FILES['fileToUpload']['name'])){
  $image_name=$_POST['old-image'];

  }else {  $image_name=$post->set_file();   }

   $post->update_post($image_name);
} else{    echo "Query Failed";   }



?>
