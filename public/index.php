<?php
 session_start();
 $_SESSION["invalidCredentials"] = 0;
 $_SESSION["cli_response"] = null;
 $_SESSION['users'] = null;
?>

<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="../resources/icon.png" sizes="16x16">
    <title>ChatForce - Home</title>
    <meta charset="UTF-8">
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
            <button type="button" class="btn btn-danger navbar-btn mt-1 mb-1 mr-1 btn-sm ml-5" name="Login" onclick="document.location.href = '../src/php/logout.php'">
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

<?php
        if (isset($_SESSION["flag"]) && $_SESSION["flag"] === 0) : ?>
           <div class="row justify-content-md-center justify-content-right">
            <div class="col col-6 p-5">
            <div class="text-center">
            <h1 style="text-align: center;  color:#A52A2A">Welcome stranger!</h1>
            <h2 style="text-align: center;  color:#A52A2A"> Please login first to use our functionalities.</h2>
            <h2 style="text-align: center;  color:#A52A2A"> If you don't have an account feel free to register.</h2>
            <button type="button" class="btn btn-danger navbar-btn mt-1 mb-1 mr-1 btn-sm ml-5" name="Register" onclick="document.location.href = 'register.php'"><b>Register</b>
        </div>
    </div>
</div>
        <?php endif ?>


<p style="position: absolute; bottom: 0; right: 0;"> <img src="../resources/icon.png" style="max-width: 30px"> <b class="text-light">ChatForce v1.0</b></p>
</body>
</html>
