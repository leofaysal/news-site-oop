<?php
//Database connection Class
class Database{
  private $host='localhost';
  private $dbusername='root';
  private $dbpwd='';
  private $dbname='news-site';
  private $db_conn=false;
  private $resultArr=array(); //variable to store result of connection or queries

  public function __construct(){

    //check if connection is not establish then it will establish in if condition
    if(!$this->db_conn){
    $this->conn=new mysqli($this->host,$this->dbusername,$this->dbpwd,$this->dbname);
    //Checking for connection error and displaying error message
    $db_conn=true;
    if($this->conn->connect_error){
      //array push used to push error in result array
      array_push($this->resultArr,$this->mysqli->connect_error);
      return false;
      }
    }
    else{
      return true;
    }
  }

 //Function for select-get data from database
    public function selectData($table,$rows='*',$join=null,$where=null,$order=null,$limit=null){

     if($this->tableExists($table)){
      $sql="SELECT $rows FROM $table";
          if($join!=null){
            $sql .=" JOIN $join";
          }
          if($where!=null){
            $sql .=" WHERE $where";
          }
          if($order!=null){
            $sql .=" ORDER BY $order";
          }
          if($limit!=null){
            if(isset($_GET['page'])){
                $page=$_GET['page'];
            }else{
              $page=1;
            }
            $start=($page-1)*$limit;
            $sql .=" LIMIT $start, $limit";
          }
      //  echo $sql;
          $query=$this->conn->query($sql);
          if($query){
            $this->resultArr=$query->fetch_all(MYSQLI_ASSOC);
            return true;
          }else{
            array_push($this->resultArr,$this->conn->error);
            return false;
          }
     }else{
       return false;
        }

   }
   public function sql($sql){
     $query=$this->conn->query($sql);
     if($query){
       $this->resultArr=$query->fetch_all(MYSQL_ASSOC);
       return true;
     }else{
       array_push($this->resultArr,$this->conn->error);
       return false;
     }
   }
   //Function for Inserting data into database
   public function insertData($table,$data=array()){
     //check if the enter table exists in database;
     if($this->tableExists($table)){
      $table_columns=implode(',',array_keys($data));
        $table_value=implode("','",$data);
       $sql="INSERT INTO $table ($table_columns) VALUES ('$table_value')";
       if($this->conn->query($sql)){
         array_push($this->resultArr,$this->conn->insert_id);//the data is inserted
         return true;
       }else{
         array_push($this->resultArr,$this->conn->error);
         return false;
       }
     }else{
      return false;
     }

   }
   //Function for Deleting data from database
   public function deleteData($table,$where= null){

     if($this->tableExists($table)){

     $sql="DELETE FROM $table";
     if ($where!=null){
       $sql .=" WHERE $where";
     }

     if($this->conn->query($sql)){
       array_push($this->resultArr,$this->conn->affected_rows); //the data is deleted
       return true;
     }
       else{
         array_push($this->resultArr,$this->conn->error);
       }

    }else{
      return false;
    }
  }
  //Function for Updating data into database
  public function updateData($table,$data=array(),$where= null){

    if($this->tableExists($table)){
     $args=array();
     foreach($data as $key=>$value){
     $args[]="$key='$value'"; //store data array into array in the form of key=value
     }

    $sql="UPDATE $table SET " .  implode(',',$args);
    if ($where!=null){
      $sql .=" WHERE $where";
    }

    if($this->conn->query($sql)){
      array_push($this->resultArr,$this->conn->affected_rows); //the data is updated
      return true;
    }
      else{
        array_push($this->resultArr,$this->conn->error);
      }

   }else{
     return false;
   }
  }
  //Function for Managing pagination
  public function pagination($table,$join=null,$where=null,$limit=null){
   if($this->tableExists($table)){
        if($limit!=null){
          $sql="SELECT COUNT(*) FROM $table";
          if($join!=null){
            $sql .=" JOIN $join";
          }
          if($where!=null){
            $sql .=" WHERE $where";
          }
 echo $sql;
          $query=$this->conn->query($sql);//count the total number of records

          $total_record=$query->fetch_array();
          $total_record=  $total_record[0];//will store the total number of record
          $total_pages=ceil($total_record/$limit);//calculate the pages
          $url=basename($_SERVER['PHP_SELF']);//return the current page url(current filename) on which to show pagination

          if(isset($_GET['page'])){
            $page=$_GET['page'];
          }else{
            $page=1;
          }
            $output="<ul class='pagination'>";
            if($page>1){
              $output.="<li><a href='$url?page=".($page-1)."'>Prev</a></li>";
            }
        //  if($total_record>$limit){

            for($i=1;$i<=$total_pages;$i++){ //to show pages tabs
              if($i==$page){
                $cls="class='active'";
              }else{
                $cls="";
              }
              $output.="<li><a $cls href='$url?page=$i'>$i</a></li>";
            }
        //  }
          if($total_pages>$page){
            $output.="<li><a href='$url?page=".($page+1)."'>Next</a></li>";
          }
            $output.="</ul>";
            echo $output;

        }else{
          return false;
        }
      }
    else{
     return false;
    }

  }
//Function to check if table exists in database
 private function tableExists($table){
 $sql="SHOW TABLES FROM `$this->dbname` LIKE '$table'";

 $tableInDb=$this->conn->query($sql);

 if($tableInDb){
   if($tableInDb->num_rows==1){
    return true;
  }else{
  array_push($this->resultArr,$table." table doesnot exist in this database.");
  return false;
  }
 }
}
//Function to show resultArr and reset its value
public function getResult(){
  $val=$this->resultArr;
  $this->resultArr=array();
  return $val;
}
//function to escape characters in string
public function escapeString($data){

  return $this->conn->real_escape_string($data);
}

//Function to close coonection
  public function __destruct(){
  if($this->db_conn){
    if($this->conn->close()){
      $this->db_conn=false;
      return true;
       }
  }else{
    return false;
  }

  }
 }

?>
