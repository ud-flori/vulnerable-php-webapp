<?php
session_start();

require_once("databaseaccess.php");

if(empty($_POST['username']) || empty($_POST['password'])){
 $_SESSION["flag"] = 0;
 $_SESSION["invalidCredentials"] = 1;
 header("Location: ../../public/login.php");
 exit();
}

 $username = $_POST['username'];
 $password = $_POST['password'];
 $host = "localhost";
 $dbname = "vulnsite";


 if(empty($username) || empty($password)) {
  $_SESSION["flag"] = 0;
  $_SESSION["invalidCredentials"] = 1;
  header("Location: ../../public/login.php");
  return;
 }

$conn = connectdb(); //connectb function in databaseaccess.php

$sql = "SELECT * FROM chatforce.users WHERE username =?";
$stmt = $sql = $conn->prepare($sql);
$stmt->bind_param("s",$username);
$stmt->execute();
$result = $stmt->get_result();
$row = mysqli_num_rows($result);
$data = mysqli_fetch_array($result, MYSQLI_ASSOC);
$pw = $data['password'];

if (password_verify($password,$pw))
    {
 session_start();
 $sql = "SELECT * FROM chatforce.users WHERE username =? AND role =?";
 $stmt = $sql = $conn->prepare($sql);
 $role = "admin";
 $stmt->bind_param("ss",$username,$role);
 $stmt->execute();
 $result = $stmt->get_result();
 $isadmin = mysqli_num_rows($result);
 if($isadmin === 1){
  $_SESSION["isAdmin"] = true;
  $_SESSION["XMLattempts"] = 0; //set the XML attempts variable*/
 }
 else{
  $_SESSION["isAdmin"] = false;
 }



 $_SESSION["flag"] = 1;
 $_SESSION["invalidCredentials"] = 1;
 $_SESSION["username"] = $username;
 header("Location: ../../public/index.php");
 return;
}

 session_start();
 $_SESSION["flag"] = 0;
 $_SESSION["invalidCredentials"] = 1;
 header("Location: ../../public/login.php");

?>
