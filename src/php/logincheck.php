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

$conn = connectdb();


$sql = "SELECT * FROM chatforce.users WHERE username = '$username'";
$result = $conn->query($sql);
$data = mysqli_fetch_array($result, MYSQLI_ASSOC);
$pw_database = $data['password'];
$role = $data['role'];
$id = $data['id'];
if (password_verify($password,$pw_database))
    {
 session_start();
 if($role === 'admin'){
  $_SESSION["isAdmin"] = true;
 }
 else{
  $_SESSION["isAdmin"] = false;
 }
 $_SESSION["flag"] = 1;
 $_SESSION["invalidCredentials"] = 1;
 $_SESSION["username"] = $data["username"];
echo "success";
 header("Location: ../../public/index.php");
 return;
}

 session_start();
 $_SESSION["flag"] = 0;
 $_SESSION["invalidCredentials"] = 1; 
 echo "fail";
 header("Location: ../../public/login.php");

?>
