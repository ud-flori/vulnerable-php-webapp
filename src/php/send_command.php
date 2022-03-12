<?php

function is_it_executable($command){
    $exec = True;
    
    $blacklist = ['&', '|', ';'];
    foreach(str_split($command) as $char){
        if(in_array($char,$blacklist)){
            $exec = False;
        }
    }

    $blacklist_commands = ['mkdir', 'ping', 'cp', 'mv'];
    foreach($blacklist_commands as $single_command)
    if(strpos($command, $single_command) !== false){
        $exec = False;
    }
    return $exec;
}



session_start();
$_SESSION["cli_response"] = null;
if(isset($_POST))
$input = $_POST['command'];
if(empty($input)){
    $_SESSION["cli_response"] = "Blank input!";
    header("Location: ../../public/cli.php");
}
else{
if(is_it_executable($input)){
$cli_response = shell_exec($input);
$_SESSION["cli_response"] = $cli_response;
}
else{
$_SESSION["cli_response"] = "Threat detected!";
}
}
if($_SESSION["cli_response"] == ""){
    $_SESSION["cli_response"] = "Unrecognized command!";
};
header("Location: ../../public/cli.php");
return;

?>