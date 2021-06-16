<?php
//include "config.php ";
include "classes.php";
$post =new posts();
if(empty($_FILES['fileToUpload']['name'])){
$image_name=$_POST['old-image'];

}else{
  $image_name=$post->set_file();

  //$post->update_post($image_name);
}
echo $image_name;
 $post->update_post($image_name);
//   $errors=array();
//   $file_name=$_FILES['new-image']['name'];
//   $file_size=$_FILES['new-image']['size'];
//   $file_tmp=$_FILES['new-image']['tmp_name'];
//   $file_type=$_FILES['new-image']['type'];
//   $text=explode('.',$file_name);
//   $file_ext= strtolower(end($text));
//   $extensions=array("jpeg","jpg","png");
//
//   if(in_array($file_ext,$extensions)=== false){
//     $error[]="This extension file is not allowed,Please choose a JPG or PNG file.";
//   }
//   if($file_size>2097152){
//       $error[]="File size must be 2MB or lower.";
//     }
//     $new_name=time(). "-".basename($file_name);
//     $target="upload/" .$new_name;
//     $image_name=$new_name;
//       if(empty($errors)== true){
//         move_uploaded_file ($file_tmp,$target);
//       }
//       else{
//         print_r($errors);
//         die();
//       }
// }
// $sql="SELECT * FROM post WHERE title='{$_POST["post_title"]}' AND post_id !='{$_GET["id"]}'";
// $result=mysqli_query($conn,$sql);
//
// if(mysqli_num_rows($result)){
// $title_error="Title already exists";
// include "update-post.php";
// }
// elseif(empty($_POST['post_title'])){
//   $title_error="Please enter the title";
//   include "update-post.php";
// }
// else{
// $sql="UPDATE post SET title='{$_POST["post_title"]}', description='{$_POST["postdesc"]}', category={$_POST["category"]}, post_img='{$image_name}'
// WHERE post_id={$_POST["post_id"]};";
//
// if($_POST['old-category']!=$_POST['category']){
//   $sql .="UPDATE category SET post=post-1 WHERE category_id={$_POST['old-category']};";
//   $sql .="UPDATE category SET post=post+1 WHERE category_id={$_POST['category']};";
//
// }
//
// $result=mysqli_multi_query($conn,$sql);
// if($result){
//   header("location: {$hostname}/admin/post.php");
// }else{
//   echo "Query Failed";
//  }

?>
