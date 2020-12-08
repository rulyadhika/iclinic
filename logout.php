<?php
session_start();

if(!isset($_SESSION["login"])){
header("Location:./login.php");
exit;
}
session_unset();
session_destroy();
$_SESSION= [];
header("Location:./login.php");
exit;
        

            
    