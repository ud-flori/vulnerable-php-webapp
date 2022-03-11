<?php
session_start();

require_once("../php/databaseaccess.php");

if(isset($_POST))
$host = "localhost";
$first_name_raw = $_POST['first_name'];
$first_name = strip_tags($first_name_raw);
$last_name_raw = $_POST['last_name'];
$last_name = strip_tags($last_name_raw);
$email_raw = $_POST['email'];
$email = strip_tags($email_raw);
$username_raw = $_POST['username'];
$username = strip_tags($username_raw);
$password_raw = $_POST['password'];
$role = 'user';
$password = password_hash($password_raw, PASSWORD_DEFAULT);
$conn = connectdb();



$sql = "SELECT * FROM chatforce.users WHERE username = ?";
$stmt = $sql = $conn->prepare($sql);
$stmt->bind_param("s",$username);
$stmt->execute();
$result = $stmt->get_result();
$row = mysqli_num_rows($result);
$data = mysqli_fetch_array($result, MYSQLI_ASSOC);
$pw = $data['password'];
if (password_verify($password_raw,$pw)) {
    $_SESSION["BrokenCredential"] = true;
    header("Location: ../../public/register.php");
    return;
}
else{
    $sql = "INSERT INTO chatforce.users (first_name,last_name,email,username,password,role) VALUES (?,?,?,?,?,?)";
    $stmt = $sql = $conn->prepare($sql);
    $stmt->bind_param("ssssss",$first_name,$last_name,$email,$username,$password,$role);
    $stmt->execute();
    $result = $stmt->get_result();
    $_SESSION["BrokenCredential"] = false;
    header("Location: ../../public/register.php");
    return;
}
?>