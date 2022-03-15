<?php
session_start();
$_SESSION['users'] = null;
if(!(isset($_SESSION["flag"])) ||
    (
        isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"] == false))

    {
        header("Location: index.php");
}

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

if(isset($_GET['logout'])){
    session_start();
    $_SESSION["flag"] = 0;
    $_SESSION["isAdmin"] = 0;
    $_SESSION["username"] = null;
    header("Location: login.php");
    }

if(isset($_GET['set_command'])){
    echo "je";
    $_SESSION["cli_response"] = null;
    if(isset($_POST))
    $input = $_POST['command'];
    if(empty($input)){
        $_SESSION["cli_response"] = "Blank input!";
        header("Location: cli.php");
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
    header("Location: cli.php");
    return;
}
?>

<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="resources/icon.png" sizes="16x16">
    <title>ChatForce - Command Line</title>
    <meta charset="UTF-8">
</head>

<body style="background-color: whitesmoke; background-image: url(resources/index_background.png);height: 100%; overflow-x:hidden;
  background-position: left;
  background-repeat: no-repeat;
  background-size: cover;">
<nav class ="navbar navbar-expand-md navbar-dark bg-dark">
<div class="collapse navbar-collapse align-middle align-content-center">
    <ul class="nav nav-pills bg-dark align-middle mr-auto align-content-center">
        <li class = "nav-item align-middle text-light">
            
            <h1>ChatForce</h1>
        </li>
        <?php
        if (isset($_SESSION["Admin"]) && $_SESSION["Admin"] == true) : ?>
            <li class="nav-item ml-auto align-middle">
                <a class="nav-link align-content-center" href="admin.php">Admin Panel</a>
            </li>
        <?php endif ?>
        <?php
        if (isset($_SESSION["flag"]) && $_SESSION["flag"] == 1) : ?>
            <li class="nav-item ml-auto align-middle">
                <a class="nav-link align-content-center text-danger" href="chat.php">Chat</a>
            </li>
            <li class="nav-item ml-auto align-middle">
                <a class="nav-link align-content-center text-danger" href="dashboard.php">Dashboard</a>
            </li>
        <?php endif ?>
        <?php
        if (isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"] == true) : ?>
        <li class="nav-item ml-auto align-middle">
                <a class="nav-link align-content-center text-danger" href="cli.php">Command Line</a>
            </li>
            <li class="nav-item ml-auto align-middle">
                <a class="nav-link align-content-center text-danger" href="management.php">Manage Users</a>
            </li>
        <?php endif ?>
    </ul>

    <ul class="navbar-nav bg-dark">
        <li class="nav-item ml-auto text-light ">
            <p class="nav-link text-light padding-top-20 href="#">

                <?php
                if(isset($_SESSION['username'])){
                    echo "You're logged in as: ";
                    echo $_SESSION["username"];
                }
                else{
                    echo '<strong>You are not logged in.</strong>';
                }
                ?>
            </p>
        </li>
        <li class = "nav-item">
            <button type="button" class="btn btn-danger navbar-btn mt-1 mb-1 mr-1 btn-sm ml-5" name="Login" onclick="document.location.href = '.?logout'">
            <?php
                if(isset($_SESSION["flag"]) && $_SESSION["flag"] === 1){
                    echo "Logout";
                }
                else{
                    echo "Login";
                }
            ?>

            </button>
        </li>
    </ul>
</div>
</nav>

    <form method="post" class="text-light" action="/cli.php?set_command" style=" margin: 0 auto; margin-top: 5%; width: 20%; height: 20%; padding: 50px;"  >
    <h3 style="padding-bottom: 5px">Command Line Input</h3>
    <div class="mb-3">
        <input type=text name= "command" class="form-control">
    </div>
    <button type="submit" class="btn btn-danger">Send to server</button>
</form>
    
    <h3 class="text-light" style="margin: 0 auto; margin-top: 0%; width: 20%; height: auto; padding: 50px;">Server Response</h3></br>
    <div class="d-flex justify-content-center"><input type=text name= "command" class="form-control" style="width:300px;" readonly value="<?php echo $_SESSION["cli_response"] ?>">
    </div>
    </html>
