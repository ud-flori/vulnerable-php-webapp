<?php
require_once(dirname(__DIR__)."/src/php/databaseaccess.php");

session_start();
$text = "";
$username = $_SESSION["username"];
if (isset($_POST["message"])) {  
    $text_raw = $_POST["message"];
    $text = $text_raw;
    //strip_tags($text_raw);
}

$conn = connectdb();

if(isset($_POST["clear"])){
    $sql = "TRUNCATE TABLE chatforce.chat";
    $conn -> query($sql);
    exit();
}

if ($text != "") {
    $sql = "INSERT INTO chatforce.chat VALUES('',?,?)";
    $stmt = $sql = $conn->prepare($sql);
    $stmt->bind_param("ss",$text,$username);
    $stmt->execute();
    $result = $stmt->get_result();
}


$sql = "SELECT CONCAT(username, ': ', text) FROM chatforce.chat ORDER BY id ASC";
$result = $conn->query($sql);


while ($row = mysqli_fetch_assoc($result))
    foreach ($row as $field => $value){
        echo $value . "\n";
    }
?>