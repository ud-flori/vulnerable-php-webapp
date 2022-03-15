<?php
session_start();
$_SESSION["cli_response"] = null;
if(!(isset($_SESSION["flag"])) ||
    (
        isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"] == false))

    {
        header("Location: index.php");
}

if(isset($_GET['logout'])){
    session_start();
    $_SESSION["flag"] = 0;
    $_SESSION["isAdmin"] = 0;
    $_SESSION["username"] = null;
    header("Location: login.php");
    }

if(isset($_GET['get_users'])){
require_once(dirname(__DIR__)."/src/php/databaseaccess.php");
$conn = connectdb();
$sql = "SELECT id,username,role FROM chatforce.users";
$stmt = $sql = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$ids = array();
$usernames = array();
$roles = array();
$index = 0;
foreach($result as $user){
    $ids[$index] = $user['id'];
    $usernames[$index] = $user['username'];
    $roles[$index] = $user['role'];
    $index = $index+1;
}

$data = array_map(null,$ids,$usernames,$roles);
$_SESSION['users'] = $data;
header("Location: management.php");
}
?>

<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="resources/icon.png" sizes="16x16">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>ChatForce - Manage users</title>
    <meta charset="UTF-8">
</head>
<script type="text/javascript">

    function send($param){
        $.post("../src/php/management_delete.php", {
    type: 'POST',
    data: {
      "id": $param
    }
  })
}
</script>

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
            <button type="button" class="btn btn-danger navbar-btn mt-1 mb-1 mr-1 btn-sm ml-5" name="Login" onclick="document.location.href = '/management.php?logout'">
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



<form method="post" class="text-light" action="/management.php?get_users" style=" margin: 0 auto; margin-top: 5%; width: 20%; height: 20%; padding: 50px;"  >
    <h3 style="padding-bottom: 5px">Get Users</h3>
    <button type="submit" class="btn btn-danger">GET</button>
</form>
<div class="container bg-secondary rounded">
  <div class="row">
    <div class="col-sm">
      ID
    </div>
    <div class="col-sm">
      Username
    </div>
    <div class="col-sm">
     Function
    </div>
  </div>
</div>
<?php
if(isset($_SESSION['users'])){
    foreach($_SESSION['users'] as $single_user){
    echo '
    <div class="container bg-secondary rounded">
    <div class="row">
      <div class="col-sm" id='.$single_user[0].'>
        '.$single_user[0].'
      </div>
      <div class="col-sm" id='.$single_user[1].'>
        '.$single_user[1].'
      </div>
      ';
      if($single_user[2] === 'admin' || $single_user[1] === $_SESSION['username']){
          echo '<div class="col-sm" id='.$single_user[0].'>
          <button type="submit" class="btn btn-danger" >N/A</button> Administrator or current user.
         </div>
       </div>
       </div>';
      }
      else{
        echo '<div class="col-sm" id='.$single_user[0].'>
        <button type="submit" class="btn btn-danger" onclick="send('.$single_user[0].')">DELETE</button>
       </div>
     </div>
     </div>';
      }
     
    ;
    }
    }
    
?>


































    </html>
