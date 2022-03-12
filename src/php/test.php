<?php
    echo var_dump($_GET['data']);
    if($_GET['data'] == "pwn"){
        echo "success";
    }
    else{
        echo "fail";
    }
?>