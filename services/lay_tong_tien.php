<?php 
session_start();


// if(@$_SESSION['gio_hang']!=''){
//     echo json_encode($_SESSION['gio_hang']);
//     //print_r($_SESSION["gio_hang"]);
// }else{
//     echo 0;
   
// }

if(@$_SESSION['cart']!=''){
    $max=count($_SESSION['cart']);
    $sum=0;
    for($i=0;$i<$max;$i++){
        $product_id=$_SESSION['cart'][$i]['product_id'];
        $quantity=$_SESSION['cart'][$i]['quantity'];
        $don_gia=$_SESSION['cart'][$i]['don_gia'];
        $sum+=$don_gia*$quantity;
    }
    echo json_encode($sum);
    //print_r($_SESSION["gio_hang"]);
}else{
    echo 0;
   
}

?>