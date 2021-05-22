<?php
include ('database.php');

$obj=new Database();
//$obj->getData();
//$obj->insertData('user',['first_name'=>'Ayesha','last_name'=>'khan','username'=>'ayesha','password'=>'1234','role'=>'0']);
//print_r($obj->tableExists('user'));
//echo "Insert result is: ";
//print_r($obj->getResult());
// $obj->updateData('user',['first_name'=>'Ayesha','last_name'=>'khan','username'=>'ayshi','password'=>'81dc9bdb52d04dc20036dbd8313ed055','role'=>'0'],'user_id="40"');
// echo "Update Result is: ";
// print_r($obj->getResult());
// $obj->deleteData('user','user_id="40"');
// echo "Delete Result is: ";
// print_r($obj->getResult());
echo" <pre>";
$obj->selectData('user','user_id,first_name',null,null,'first_name','2');
echo "\n\n Select Result is: ";
print_r($obj->getResult());
$obj->pagination('user',null,null,'2');
//echo "\n\n Select Result is: ";


?>
