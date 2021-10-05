<?php   
    session_start();
    session_unset();
    //$_SESSION['user_-id'] = null;
    header('Location: ../Views/login.php');
?>