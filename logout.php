<?php   
    session_start();
    if(isset($_SESSION['User'])){
        unset($_SESSION['User']);
        header("Location: index.php");
        exit();
}