<?php

include "db.php";

class DataOperation extends Database
{
  public function insert_record($table,$fileds){

    $sql = "";
    $sql .= "INSERT INTO".$table;
    $sql .=" (".implode(",", array_keys($fileds)).") VALUES ";
    $sql .="('".implode("','", array_values($fileds))."')";
    $query = mysqli_query($this->con,$sql);
    if($query){
      return true;
    }
  }
  public function fetch_record($table){
    $sql = "SELECT * FROM ".$table;
    $array = array();
    $query = mysqli_query($this->con,$sql);
    while($row = mysqli_fetch_assoc($query)){
      $array[] = $row;
    }
    return $array;
  }

  public function select_record($table,$where){
    $sql = "";
    $condition = "";
    foreach ($where as $key => $value){
      $condition .= $key."='" . $value ."' AND ";
    }
    $condition = substr($condition, 0, -5);
    $sql .= "SELECT * FROM " .$table. " WHERE ".$condition;
    $query = mysqli_query($this->con,$sql);
    $row = mysqli_fetch_array($query);
    return $row;
  } //
  public function update_record($table,$where,$fields){
    $sql ="";
    $condition = "";
    foreach ($where as $key => $value){
      $condition .=$key . "='" .$value . "' AND ";
    }
    $condition = substr($condition, 0, -5);
    foreach ($fields as $key => $value){
      $sql .= $key . "='".$value."', ";
    }
    $sql = substr($sql, 0, -2); value . "' AND ";
    $sql = "UPDATE" .$table. " SET ".$sql."WHERE".$condition;
    if(mysqli_query($this->con,$sql)){
      return true;
      }
    }
    public function delete_record($table,$where){
      $sql = "";
      $condition = "";
      foreach ($where as $key => $value){
        $condition .=$key . "='" .$value . "' AND ";
      }
      $condition = substr($condition, 0, -5);
      $sql = "DELETE FROM".$table."WHERE".$condition;
      if(mysqli_query($this->con,$sql)){
        return true;
      }
    }
}

$obj = new DataOperation;

if(isset($_POST["submit"])){
  $myArray = array(
    "templateTitle" => $_POST["title"]
  );

    if($obj->insert_record("create_template",$myArray)){
      header("location:index.php?msg=Template inserted.");
    }
}

if(isset($_POST["edit"])){
  $templateID = $_POST["templateID"];
  $where = array("templateID"=>$templateID);
  $myArray = array(
    "templateTitle" => $_POST["title"]
  );
  if($obj->update_record("create_template",$where,$myArray)){
    header("location:index.php?msg=Record Updated successfully");
  }
}

if(isset($_GET["delete"])){
  $templateID = $_GET["templateID"] ?? null;
  $where = array("templateID"=>$templateID);
  if($obj->delete_record("create_template",$where)){
    header ("location:index.php?msg=Record deleted");
  }

}
?>
