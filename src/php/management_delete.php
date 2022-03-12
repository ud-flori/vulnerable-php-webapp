<?php
session_start();
if(!(isset($_SESSION["flag"])) || (isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"] == false)){
        header("Location: ../../public/index.php");
}

require_once("databaseaccess.php");
$conn = connectdb();
$data = $_POST["data"];

$sql = "DELETE FROM chatforce.users WHERE id =?";
$stmt = $sql = $conn->prepare($sql);
$stmt->bind_param("i",$data["id"]);
$stmt->execute();
?>