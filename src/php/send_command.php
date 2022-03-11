<?php
session_start();
$_SESSION["cli_response"] = null;
if(isset($_POST))
$cli_response = shell_exec($_POST['command']);
$_SESSION["cli_response"] = $cli_response;
header("Location: ../../public/cli.php");
return;

?>