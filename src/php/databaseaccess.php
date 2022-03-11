<?php
function connectdb(){
    $ini_array = parse_ini_file("../../config/mysql.ini");
    $username = $ini_array["username"];
    $password = $ini_array["password"];
    $host = $ini_array["host"];
    $dbname = $ini_array["dbname"];

    $conn = new mysqli($host, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}
?>
