<?php
session_start();
$_SESSION['users'] = null;
$_SESSION["cli_response"] = null;
if((!(isset($_SESSION["flag"]))) || $_SESSION["flag"]===0){
    header("Location: ../pages/index.php");
}

if(isset($_GET['logout'])){
    session_start();
    $_SESSION["flag"] = 0;
    $_SESSION["isAdmin"] = false;
    $_SESSION["username"] = null;
    header("Location: login.php");
    }
    
?>

<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="../resources/icon.png" sizes="16x16">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>ChatForce - Chat</title>
    <meta charset="UTF-8">
    <script type="text/javascript">
        function update()
        {
            $.post("chatserver.php", {}, function(data){ $("#screen").html(data);});

            setTimeout('update()', 1000);
        }

        $(document).ready(

            function()
            {
                update();
                console.log($("#button"));
                $("#button").click(
                    function()
                    {
                        $.post("chatserver.php",
                            { message: $("#message").val() },
                            function(data){
                                $("#screen").val(data);
                                $("#message").val("");
                            }
                        );
                    }
                );

                $("#clear").click(
                    function()
                    {
                        $.post("chatserver.php",
                            { clear: $("#clear").val() }
                        );
                    }
                );


            });
    </script>
</head>

<body style="background-color: whitesmoke; background-image: url(../resources/index_background.png);height: 100%; overflow-x:hidden;
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

<div style="margin-left: 40rem; margin-top: 20rem">
    <div style="width: 40%; height: 30%; margin: 5%">
        <div style="height: 90%; background-color: white;" class="form-group">
            <textarea rows="10" id="screen" style="border-color: rgb(0,123,255);background-color: white; resize: none" class="form-control" disabled> </textarea>
        </div>
    <div style="height: 10%;" class="input-group">
        <input type="text" class="form-control" style="border: solid 1px black; border-color: rgb(0,123,255)" id="message">
        <button class="btn btn-danger" id="button">Send</button>
        <?php
        if (isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"] === true) : ?>
            <button class="btn btn-warning" id="clear">Clear</button>
        <?php endif ?>
    </div>
        
</body>

    </html>
