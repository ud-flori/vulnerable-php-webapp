<?php
session_start();    
if(!(isset($_SESSION["flag"])) || (isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"] == false)){
    header("Location: ../../public/index.php");
}
require_once("databaseaccess.php");
$conn = connectdb();
$sql = "SELECT id,username FROM chatforce.users";
$stmt = $sql = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$ids = array();
$usernames = array();
$index = 0;
foreach($result as $user){
    $ids[$index] = $user['id'];
    $usernames[$index] = $user['username'];
    $index = $index+1;
}

$data = array_map(null,$ids,$usernames);
$_SESSION['users'] = $data;
header("Location: ../../public/management.php");
?>
