<?php
session_start();
$_SESSION['users'] = null;

if(isset($_GET['login'])){
session_destroy();
session_start();

require_once(dirname(__DIR__)."/src/php/databaseaccess.php");

if(empty($_POST['username']) || empty($_POST['password'])){
 $_SESSION["flag"] = 0;
 $_SESSION["invalidCredentials"] = 1;
 header("Location: login.php");
 exit();
}
 $username = $_POST['username'];
 $password = $_POST['password'];

$conn = connectdb();


$sql = "SELECT * FROM chatforce.users WHERE username = '$username'";
$result = $conn->query($sql);
$data = mysqli_fetch_array($result, MYSQLI_ASSOC);
$pw_database = $data['password'];
$role = $data['role'];
$id = $data['id'];
if (password_verify($password,$pw_database))
{
if($role === 'admin'){
$_SESSION["isAdmin"] = true;
}
else{
  $_SESSION["isAdmin"] = false;
}
 $_SESSION["flag"] = 1;
 $_SESSION["invalidCredentials"] = 0;
 $_SESSION["username"] = $data["username"];
 header("Location: index.php");
 return;
}

 $_SESSION["flag"] = 0;
 $_SESSION["invalidCredentials"] = 1;

}


?>

<html>
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>ChatForce - Login</title>
    <link rel="icon" type="image/png" href="resources/icon.png" sizes="16x16">
</head>

<body style="background-image: url(resources/index_background.png);background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
">
<nav class ="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="collapse navbar-collapse align-middle align-content-center">
    <ul class="nav nav-pills bg-dark align-middle mr-auto align-content-center">
        <li class = "nav-item align-middle text-light">
            <h1>ChatForce</h1>
        </li>

        <li class="nav-item ml-auto align-middle">
            <a class="nav-link align-content-center text-danger" href="index.php">Home</a>
        </li>

    </ul>

    </li>
    </ul>
</div>
</nav>

<form method="post" action="/login.php?login" style="margin: 0 auto; margin-top: 10%; width: 20%; height: 20%; padding: 50px;" >
<?php
    if(isset($_SESSION) && isset($_SESSION["invalidCredentials"])) {
        if ($_SESSION["invalidCredentials"] === 1){
            echo '<strong style="color: red; ">Invalid username or password!</strong>';
        }
    };
    ?>
    <?php
    if(isset($_SESSION["startTimeLogin"])){
        $elapsedTime = (time() - $_SESSION["startTimeLogin"]) / 60;
        if($elapsedTime >= 5) {
            $_SESSION["manyLogins"] = false;
            unset($_SESSION["loginAttempts"]);
        }
    }
    ?>
    <div class="mb-3">
        <label class="form-label text-light">Username</label>
        <input type=text name= "username" class="form-control"  placeholder="Please enter your username">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label text-light">Password</label>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Please enter your password">
    </div>
    <?php
    if(isset($_SESSION["manyLogins"]) && ($_SESSION["manyLogins"] === 1)){
        echo '<strong style = "color: red; "> Too many login attempts!</strong>';
    }
    else{
        echo '<button type="submit" class="btn btn-danger"">Submit</button>';
    }
    ?>

</form>
</body>

</html>