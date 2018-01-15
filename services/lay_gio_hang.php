<?php 
session_start();


// if(@$_SESSION['gio_hang']!=''){
//     echo json_encode($_SESSION['gio_hang']);
//     //print_r($_SESSION["gio_hang"]);
// }else{
//     echo 0;
   
// }

if(@$_SESSION['cart']!=''){
    echo json_encode($_SESSION['cart']);
    //print_r($_SESSION["gio_hang"]);
}else{
    echo 0;
   
}

?>