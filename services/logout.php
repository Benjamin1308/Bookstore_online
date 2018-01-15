<?php 
session_start();

if(isset($_SESSION['nguoi_dung'])){
    session_destroy();
    
    echo 1;
}

?>