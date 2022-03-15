<?php
    echo var_dump($_POST['data']);
    if("0ad" == $_SESSION['id']){
        echo "success";
    }
    else{
        echo "fail";
    }
?>