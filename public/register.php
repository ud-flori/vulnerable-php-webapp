<?php
session_start();
$_SESSION["cli_response"] = null;
$_SESSION['users'] = null;
?>

<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="../resources/icon.png" sizes="16x16">
    <title>ChatForce - Register</title>
</head>
<body style="background-image: url(../resources/index_background.png);height: 100%;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid text-light">
        <h1 style="padding-right: 10px;">ChatForce</h1>
       
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link active text-danger" aria-current="page" href="index.php">Home</a>
            </div>
           
        </div>
    </div>
</nav>

<form method="post" class="text-light" action="../src/php/register_validation.php" style=" margin: 0 auto; margin-top: 5%; width: 20%; height: 20%; padding: 50px;"  >
    <?php
            if(isset($_SESSION["BrokenCredential"])){
                if($_SESSION["BrokenCredential"] === true){
                    echo '<strong style="color: red; "> Registration failed!</strong>';
                }
                else{
                    echo '<strong style="color: green; "> Registration succesful!</strong>';
                }
            }
            unset($_SESSION["BrokenCredential"]);
    ?>
    <h3 style="padding-bottom: 5px">Registration</h3>
    <div class="mb-3">
        <label class="form-label">First name</label>
        <input type=text name= "first_name" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Last name</label>
        <input type=text name= "last_name" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type=email name= "email" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Username</label>
        <input type=text name= "username" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control">
    </div>
    <button type="submit" class="btn btn-danger">Submit</button>
</form>


</body>

</html>
